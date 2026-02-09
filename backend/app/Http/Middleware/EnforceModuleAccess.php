<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TenantContext;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceModuleAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $context = app(TenantContext::class);

        if (!$context->feature($module)) {
            return response()->json(['message' => 'Module is not enabled for this mosque.'], 404);
        }

        return $next($request);
    }
}
