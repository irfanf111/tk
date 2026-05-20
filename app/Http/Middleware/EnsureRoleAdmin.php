<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleAdmin
{
    /**
     * Pastikan yang mengakses halaman Admin PPDB adalah admin (role: 'admin').
     *
     * Jika belum login → redirect ke /login.
     * Jika login tapi bukan admin → 403 Forbidden.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk Admin.');
        }

        return $next($request);
    }
}
