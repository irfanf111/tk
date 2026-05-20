<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        // Daftarkan alias middleware agar bisa dipakai di routes
        $middleware->alias([
            'role.user'  => \App\Http\Middleware\EnsureRoleUser::class,
            'role.admin' => \App\Http\Middleware\EnsureRoleAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, \Illuminate\Http\Request $request) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengunggah: Total ukuran file melebihi batas server. Harap pastikan setiap file maksimal berukuran 2 MB.');
        });
    })->create();
