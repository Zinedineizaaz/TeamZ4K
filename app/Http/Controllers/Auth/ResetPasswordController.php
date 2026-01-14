<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    // --- LOGIKA UTAMA: REDIRECT KE PROFIL SETELAH SUKSES ---
    // Setelah password diganti, user otomatis login, jadi kita lempar ke Profile.
    protected $redirectTo = '/profile';

    public function __construct()
    {
        // Pastikan tamu yang bisa akses, kecuali logout
        $this->middleware('guest');
    }
}