<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

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
            }
        }

        return $next($request);
    }
}