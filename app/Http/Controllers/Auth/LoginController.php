<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // --- LOGIKA 1: REDIRECT SESUAI ROLE ---
    public function redirectTo()
    {
        $role = Auth::user()->role; 
        
        // Kalau Admin/Police yang login
        if ($role == 'superadmin' || $role == 'admin') {
            return '/admin/dashboard';
        }

        // Kalau User biasa -> Ke Home (biar bisa langsung belanja)
        return '/profile'; 
    }

    // --- LOGIKA 2: CATAT WAKTU LOGIN ---
    protected function authenticated(Request $request, $user)
    {
        // Update kolom last_login_at di database
        $user->last_login_at = now();
        $user->save();
    }

    // =========================================================
    //       FITUR KHUSUS: LOGIN ADMIN (/admin/login)
    //       (Tetap kita pertahankan kode yang tadi)
    // =========================================================

    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
{
    // 1. VALIDASI INPUT (Update Bagian Ini)
    $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6',
    //     'g-recaptcha-response' => 'required|captcha' // <--- INI TAMBAHAN WAJIBNYA
    // ], [
    //     // Pesan Error Bahasa Manusia
    //     'g-recaptcha-response.required' => 'Mohon centang verifikasi "Saya bukan robot".',
    //     'g-recaptcha-response.captcha'  => 'Verifikasi robot gagal, silakan coba lagi.',
    ]);

    // 2. PROSES LOGIN (Biarkan kode di bawahnya tetap sama)
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        
        // Cek Role
        if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'){
            return redirect()->route('admin.dashboard');
        }
        
        Auth::logout();
        return back()->with('error', 'Anda bukan Admin/Staff!');
    }

    return back()->withInput($request->only('email', 'remember'))->with('error', 'Email atau Password salah!');
}
}