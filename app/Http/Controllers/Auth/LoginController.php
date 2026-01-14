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
        // Middleware Guest: Yang udah login gak boleh buka halaman login lagi
        $this->middleware('guest')->except('logout');
    }

    // ==========================================
    // 1. LOGIN USER BIASA (Masyarakat)
    // ==========================================

    // Validasi input user biasa
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha', // Validasi Recaptcha
        ]);
    }

    // Kalau User Biasa sukses login, lempar kesini
    public function redirectTo()
    {
        $role = Auth::user()->role;

        // Jaga-jaga kalau Admin iseng login lewat form user biasa
        if (in_array($role, ['admin', 'police', 'superadmin'])) {
            return '/admin/dashboard';
        }

        return '/profile';
    }

    // Update waktu login terakhir
    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = now();
        $user->save();
    }

    // ==========================================
    // 2. LOGIN ADMIN (Staff, Police, Superadmin)
    // ==========================================

    // Tampilkan Form Login Admin
    public function showAdminLoginForm()
    {
        return view('auth.admin_login');
    }

    // Proses Login Admin
    public function loginAdmin(Request $request)
    {
        // A. VALIDASI INPUT
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        // B. COBA LOGIN (Pakai Guard Standar 'web')
        // attempt() otomatis ngecek Email & Hash Password di database
        if (
            Auth::guard('web')->attempt(
                ['email' => $request->email, 'password' => $request->password],
                $request->remember
            )
        ) {
            // C. LOGIN BERHASIL -> SEKARANG CEK JABATANNYA (ROLE)
            $user = Auth::user();

            // Cek apakah dia punya hak akses admin?
            if (in_array($user->role, ['admin', 'police', 'superadmin'])) {

                // Catat waktu login
                $user->last_login_at = now();
                $user->save();

                // SILAKAN MASUK BOS!
                return redirect()->route('admin.dashboard');
            }

            // D. KALAU LOGIN SUKSES TAPI ROLE-NYA 'USER' (PENYUSUP)
            Auth::guard('web')->logout(); // Tendang keluar (Logout paksa)
            return back()->with('error', 'Maaf, akun Anda bukan akun Admin/Police.');
        }

        // E. KALAU PASSWORD ATAU EMAIL SALAH
        return back()->with('error', 'Email atau Password salah!');
    }

    // ==========================================
    // 3. LOGOUT (Umum)
    // ==========================================
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}