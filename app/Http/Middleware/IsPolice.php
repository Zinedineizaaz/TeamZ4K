<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsPolice
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek Login
        if (Auth::check()) {
            $role = Auth::user()->role;

            // 2. HANYA BOLEHIN POLICE & SUPERADMIN
            // Admin biasa (Staff) bakal ditolak disini
            if ($role === 'police' || $role === 'superadmin') {
                return $next($request);
            }
        }

        // 3. Kalau bukan Police -> Tampilkan Error 403 (Forbidden)
        // Atau bisa juga redirect back() dengan pesan error
        abort(403, 'DILARANG MASUK! Area ini khusus Police & Superadmin.');
    }
}