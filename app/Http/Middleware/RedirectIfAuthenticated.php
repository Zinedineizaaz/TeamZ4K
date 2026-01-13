<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Jika SUDAH LOGIN
        if (Auth::check()) {

<<<<<<< HEAD
            $role = Auth::user()->role;

            // 🔐 ADMIN / POLICE TIDAK BOLEH LIHAT LOGIN ADMIN
            if (
                $request->is('admin/login') &&
                in_array($role, ['admin', 'superadmin', 'police'])
            ) {
                return redirect()->route('admin.dashboard');
=======
        foreach ($guards as $guard) {
            // Cek apakah user sudah login?
            if (Auth::guard($guard)->check()) {
                
                $user = Auth::user();

                // PERBAIKAN: Logika Redirect berdasarkan ROLE
                
                // 1. Jika Role Admin atau Police -> Lempar ke Dashboard Admin
                if ($user->role == 'admin' || $user->role == 'police') {
                    return redirect()->route('admin.dashboard');
                }

                // 2. Jika Role User Biasa -> Lempar ke Home
                // Jadi user gak akan bisa lihat halaman login admin lagi
                return redirect()->route('profile');
>>>>>>> 984efa60b5a6bd1f4beb10174f217cb29beea260
            }

            // 👤 USER BIASA BOLEH AKSES /admin/login
            return $next($request);
        }

        return $next($request);
    }
}