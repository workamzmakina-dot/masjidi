<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        then: function () {
            Route::prefix('api')->group(function () {
                Route::get('health', function () {
                    return response()->json(['status' => 'ok', 'time' => now()->toDateTimeString()]);
                });

                Route::prefix('auth')->group(base_path('routes/api_auth.php'));

                Route::middleware(['api', 'tenant.resolve'])->prefix('public')->group(base_path('routes/api_public.php'));
                Route::middleware(['api', 'tenant.resolve', 'auth:tenant'])->prefix('tenant')->group(base_path('routes/api_tenant.php'));
                Route::middleware(['api', 'auth:platform'])->prefix('platform')->group(base_path('routes/api_platform.php'));
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'tenant.resolve' => \App\Http\Middleware\IdentifyTenant::class,
            'tenant.limit' => \App\Http\Middleware\EnforcePlanLimits::class,
            'module' => \App\Http\Middleware\EnforceModuleAccess::class,
        ]);

        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/public/*/payments/wish/webhook',
            'api/webhooks/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
