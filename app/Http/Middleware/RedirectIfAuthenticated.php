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

            $role = Auth::user()->role;

            // 🔐 ADMIN / POLICE TIDAK BOLEH LIHAT LOGIN ADMIN
            if (
                $request->is('admin/login') &&
                in_array($role, ['admin', 'superadmin', 'police'])
            ) {
                return redirect()->route('admin.dashboard');
            }

            // 👤 USER BIASA BOLEH AKSES /admin/login
            return $next($request);
        }

        return $next($request);
    }
}
