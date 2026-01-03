<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import Auth

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect setelah login user biasa.
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Modifikasi Redirect setelah login sukses (Bawaan Laravel).
     * Jika admin login lewat form biasa (/login), akan diarahkan kesini.
     */
    public function redirectTo()
    {
        $role = Auth::user()->role; 
        if ($role == 'superadmin' || $role == 'admin') {
            return '/admin/dashboard';
        }
        return '/'; 
    }

    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = now();
        $user->save();
    }

    // =========================================================
    //       TAMBAHAN BARU: KHUSUS LOGIN ADMIN (/admin/login)
    // =========================================================

    // 1. Tampilkan Form Login Khusus Admin
    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    // 2. Proses Login Admin
    public function loginAdmin(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Coba Login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            
            // Cek Role: Apakah dia Admin atau Superadmin?
            $user = Auth::user();

            if ($user->role == 'superadmin' || $user->role == 'admin') {
                // Update waktu login
                $user->last_login_at = now();
                $user->save();

                // Sukses! Masuk ke Dashboard
                return redirect()->intended('/admin/dashboard');
            }

            // Kalau ternyata dia User Biasa yang iseng login lewat sini
            Auth::logout();
            return back()->with('error', 'Anda bukan Admin! Silakan login di halaman user.');
        }

        // Kalau Email/Password salah
        return back()->withInput($request->only('email', 'remember'))->with('error', 'Email atau Password Admin salah!');
    }
}