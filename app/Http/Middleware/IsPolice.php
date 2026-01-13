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
        // Sesuaikan pengecekan dengan role 'police' sesuai data di TiDB Cloud
        if (auth()->check() && auth()->user()->role === 'police') {
            return $next($request);
        }

        abort(403, 'Akses Ditolak! Jabatan Anda tidak memiliki izin.');
    }
}