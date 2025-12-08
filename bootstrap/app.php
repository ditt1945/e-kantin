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
        // Trust all proxies for Cloudflare tunnel
        $middleware->trustProxies(at: '*');

        // Middleware alias
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'customer' => \App\Http\Middleware\CustomerMiddleware::class,
            'tenant_owner' => \App\Http\Middleware\TenantOwnerMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/payment/callback',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();