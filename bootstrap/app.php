<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // 1. Platform Admin Routes
            Route::middleware(['web', 'auth:platform'])
                ->prefix('platform-admin')
                ->name('platform.')
                ->group(base_path('routes/platform_admin.php'));

            // 2. Tenant Admin Routes
            Route::middleware(['web', 'tenant.resolve', 'auth:tenant', 'tenant.limit'])
                ->prefix('admin/{mosque_slug}')
                ->name('tenant.')
                ->group(base_path('routes/tenant_admin.php'));

            // 3. Public Mosque Website Routes
            Route::middleware(['web', 'tenant.resolve'])
                ->prefix('m/{mosque_slug}')
                ->name('public.')
                ->group(base_path('routes/public.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'tenant.resolve' => \App\Http\Middleware\IdentifyTenant::class,
            'tenant.limit' => \App\Http\Middleware\EnforcePlanLimits::class,
            'module' => \App\Http\Middleware\EnforceModuleAccess::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'm/*/payments/wish/webhook',
            'api/webhooks/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
