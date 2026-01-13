<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login?
        if (Auth::check()) {
            
            $user = Auth::user();

            // 2. CEK ROLE
            // Hanya Admin, Police, dan Superadmin yang boleh lewat.
            if ($user->role === 'admin' || $user->role === 'police' || $user->role === 'superadmin') {
                return $next($request);
            }

            // 3. PERBAIKAN UTAMA DISINI (FIX ERROR GITHUB ACTIONS):
            // Kalau User Biasa coba masuk -> JANGAN Redirect, tapi kasih ERROR 403.
            // Test di GitHub menuntut respons 403 (Forbidden), bukan 200 (Halaman Profile).
            abort(403, 'Akses Ditolak! Anda tidak memiliki izin untuk mengakses halaman Admin.');
        }

        // 4. Kalau belum login sama sekali -> Lempar ke Login Admin
        return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
    }
}