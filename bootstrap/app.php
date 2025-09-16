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
    ->withMiddleware(function (Middleware $middleware) {
        // Alias middleware route
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // (Opsional) redirect user setelah login secara global
        $middleware->redirectUsersTo(function () {
            return auth()->check() && auth()->user()->role === 'admin'
                ? route('admin.dashboard')
                : route('dashboard');
        });

        // (Opsional) redirect guest ke halaman login
        // $middleware->redirectGuestsTo(fn () => route('login'));
    })
    ->withExceptions(function ($exceptions) {
        //
    })->create();