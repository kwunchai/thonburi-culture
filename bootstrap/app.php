<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add trusted hosts middleware for Railway compatibility
        $middleware->append(\App\Http\Middleware\TrustedHosts::class);
        
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'ip.permission' => \App\Http\Middleware\CheckIpPermission::class,
            'trusted.hosts' => \App\Http\Middleware\TrustedHosts::class,
        ]);
    })
    
    ->withProviders([
        JeroenNoten\LaravelAdminLte\AdminLteServiceProvider::class,
    ])

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();