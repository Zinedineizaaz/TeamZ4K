<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPolice
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            // HANYA BOLEHIN POLICE & SUPERADMIN
            // Staff (admin) tidak ada di sini, jadi bakal ditolak
            if ($role === 'police' || $role === 'superadmin') {
                return $next($request);
            }
        }

        // Tendang Staff atau User biasa
        abort(403, 'DILARANG MASUK! Area ini khusus Police & Superadmin.');
    }
}