<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPolice
{
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !in_array($admin->role, ['police', 'superadmin'])) {
            abort(403, 'AKSES KHUSUS POLICE / SUPERADMIN');
        }

        return $next($request);
    }
}
