<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleUser
{
    /**
     * Pastikan yang mengakses halaman PPDB adalah user biasa (role: 'user').
     *
     * Jika yang login ternyata admin → redirect ke /admin (panel Filament).
     * Jika belum login sama sekali → redirect ke /login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Belum login
        if (! $user) {
            return redirect()->route('login');
        }

        // Yang login adalah admin — kirim ke panel mereka, bukan PPDB
        if ($user->isAdmin()) {
            return redirect('/admin')->with(
                'warning',
                'Anda login sebagai Admin. Silakan gunakan Panel Admin.'
            );
        }

        // User biasa (role: 'user') — lanjutkan request
        return $next($request);
    }
}
