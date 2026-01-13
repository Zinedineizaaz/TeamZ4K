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
        
        // UPDATE: Tambahin 'police' disini
        if ($role == 'superadmin' || $role == 'admin' || $role == 'police') {
            return '/admin/dashboard';
        }

        // Kalau User biasa -> Ke Home
        return '/profile'; 
    }

    // --- LOGIKA 2: CATAT WAKTU LOGIN ---
    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = now();
        $user->save();
    }

    // =========================================================
    //       FITUR KHUSUS: LOGIN ADMIN (/admin/login)
    // =========================================================

    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
    {
        // 1. Validasi Input Standar
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 2. Coba Login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            
            // --- HAPUS PENGECEKAN ROLE DISINI ---
            // Pokoknya kalau email pas, langsung lempar ke dashboard
            return redirect()->route('admin.dashboard');
        }

        // Kalau password salah
        return back()->withInput($request->only('email', 'remember'))->with('error', 'Email atau Password salah!');
    }
}