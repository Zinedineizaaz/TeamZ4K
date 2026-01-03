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
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            // Cek apakah dia benar-benar admin?
            if ($user->role == 'superadmin' || $user->role == 'admin') {
                $user->last_login_at = now();
                $user->save();
                return redirect()->intended('/admin/dashboard');
            }

            // Kalau User biasa nyasar ke form admin
            Auth::logout();
            return back()->with('error', 'Anda bukan Admin! Silakan login di halaman user biasa.');
        }

        return back()->withInput($request->only('email', 'remember'))->with('error', 'Email atau Password Admin salah!');
    }
}