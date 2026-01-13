<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPolice
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sedang login DAN apakah rolenya superadmin
        if (auth()->check() && auth()->user()->role === 'police') {
            
            // Kalau IYA (Police), silakan lanjut masuk
            return $next($request);
        }

        // --- UBAH BAGIAN INI ---
        // Jangan redirect ke '/', tapi stop proses dan tampilkan Error 403.
        // Laravel otomatis akan mencari file view di resources/views/errors/403.blade.php
        abort(403, 'Akses Ditolak! Halaman ini hanya untuk Police.');
    }
}