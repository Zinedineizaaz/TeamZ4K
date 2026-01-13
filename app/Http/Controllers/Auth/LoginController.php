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
        // USER ONLY
        $this->middleware('guest:web')->except('logout');
        $this->middleware('auth:web')->only('logout');

        // ADMIN ONLY
        $this->middleware('guest:admin')->only([
            'showAdminLoginForm',
            'loginAdmin'
        ]);
    }

    // ================= USER LOGIN =================
    
    // Validasi User Biasa + Recaptcha
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha', 
        ]);
    }

    public function redirectTo()
    {
        $role = Auth::user()->role;
        if (in_array($role, ['admin', 'police', 'superadmin'])) {
            return '/admin/dashboard';
        }
        return '/profile';
    }

    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = now();
        $user->save();
    }

    // ================= ADMIN LOGIN =================
    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
    {
        // Validasi Admin + Recaptcha
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        if (Auth::guard('admin')->attempt(
            $request->only('email', 'password'),
            $request->remember
        )) {
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau Password admin salah!');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}