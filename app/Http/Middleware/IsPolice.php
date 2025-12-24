<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPolice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sedang login?
        // 2. Cek apakah kolom 'role' di database isinya 'superadmin'?
        if (auth()->check() && auth()->user()->role === 'superadmin') {
            
            // Kalau IYA (Police), silakan lanjut masuk
            return $next($request);
        }

        // Kalau BUKAN Police, tendang balik ke halaman home/dashboard
        return redirect('/')->with('error', 'Akses Ditolak! Halaman ini hanya untuk Police.');
    }
}