<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib ada agar Auth::user() bekerja

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani autentikasi user (Login).
    | Kita memodifikasinya agar bisa redirect dinamis berdasarkan Role.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * 1. LOGIKA REDIRECT DINAMIS (PENGGANTI $redirectTo)
     * Laravel akan menjalankan fungsi ini untuk menentukan tujuan setelah login.
     */
    public function redirectTo()
    {
        // Ambil role user yang sedang login
        $role = Auth::user()->role; 

        // Cek: Apakah dia 'superadmin' (Police) ATAU 'admin' (Staff)?
        if ($role == 'superadmin' || $role == 'admin') {
            // Arahkan ke Dashboard Admin
            return '/admin/dashboard';
        }

        // Jika User Biasa / Customer
        // Arahkan ke Halaman Utama Website
        return '/'; 
    }

    /**
     * 2. LOGIKA MONITORING (UPDATE WAKTU LOGIN)
     * Fungsi ini jalan otomatis tepat setelah user berhasil login.
     */
    protected function authenticated(Request $request, $user)
    {
        // Update kolom last_login_at di database
        $user->last_login_at = now();
        $user->save();

        // Setelah ini selesai, Laravel akan lanjut memanggil fungsi redirectTo() di atas.
    }
}