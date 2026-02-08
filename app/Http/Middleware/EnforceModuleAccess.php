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
            // Check for explicit overrides in DB (optional performance hit, but allows granular control)
            $mosque = $context->get();
            $override = $mosque->overrides()
                ->where('feature_name', $module)
                ->where('enabled', true)
                ->exists();

            if (!$override) {
                // Return 404 instead of 403 to prevent feature discovery/probing
                abort(404, "Module '{$module}' is not enabled for this mosque.");
            }
        }

        return $next($request);
    }
}
