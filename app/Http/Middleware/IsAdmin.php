<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek: Apakah dia sudah login?
        if (Auth::check()) {
            // --- HAPUS PENGECEKAN ROLE ---
            // LANGSUNG BOLEHIN LEWAT SIAPAPUN DIA
            return $next($request);
        }

        // Kalau belum login sama sekali, suruh login dulu
        return redirect('/admin/login')->with('error', 'Login dulu bro!');
    }
}