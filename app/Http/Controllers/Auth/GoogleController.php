<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Arahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Handle balikan dari Google setelah user klik "Allow"
    // 2. Handle balikan dari Google setelah user klik "Allow"
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $userToLogin = null;

            $findUser = User::where('google_id', $googleUser->id)->first();

            if ($findUser) {
                // User lama
                $userToLogin = $findUser;
            } else {
                // User baru atau link manual
                $existingUser = User::where('email', $googleUser->email)->first();
                if ($existingUser) {
                    $existingUser->update(['google_id' => $googleUser->id]);
                    $userToLogin = $existingUser;
                } else {
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'role' => 'user', 
                        'password' => Hash::make(Str::random(16)),
                        'last_login_at' => now(),
                    ]);
                    $userToLogin = $newUser;
                }
            }

            Auth::login($userToLogin);

            // === UPDATE LOGIKA REDIRECT ===
            if ($userToLogin->role == 'superadmin' || $userToLogin->role == 'admin') {
                // Kalau Admin tetep ke Dashboard Admin
                return redirect()->route('admin.dashboard');
            } else {
                // Kalau User biasa -> ARAHKAN KE PROFILE
                // Pastikan route 'profile' ada di web.php
                return redirect()->route('profile'); 
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }
}