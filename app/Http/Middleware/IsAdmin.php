<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Pastikan user login dan memiliki role admin atau police
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'police')) {
            return $next($request);
        }

        // Jika bukan admin, gagalkan dengan status 403 (Sesuai kebutuhan test)
        abort(403, 'Unauthorized access.');
    }
}
