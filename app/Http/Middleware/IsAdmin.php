<?php

namespace App\Http\Middleware;

use Closure;
<<<<<<< HEAD
=======
use Illuminate\Http\Request;
>>>>>>> 984efa60b5a6bd1f4beb10174f217cb29beea260
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
<<<<<<< HEAD
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Login admin dulu!');
        }

        return $next($request);
=======
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login?
        if (Auth::check()) {
            
            $user = Auth::user();

            // 2. CEK ROLE (INI WAJIB ADA!)
            // Hanya Admin, Police, dan Superadmin yang boleh lewat.
            if ($user->role == 'admin' || $user->role == 'police' || $user->role == 'superadmin') {
                return $next($request);
            }

            // 3. KALAU USER BIASA (Agus dkk) -> TENDANG KELUAR
            // Redirect ke halaman Profile User
            return redirect()->route('profile')->with('error', 'Akses Ditolak! Halaman ini hanya untuk Admin.');
        }

        // 4. Kalau belum login sama sekali -> Lempar ke Login Admin
        return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
>>>>>>> 984efa60b5a6bd1f4beb10174f217cb29beea260
    }
}
