<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TenantContext;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforcePlanLimits
{
    public function handle(Request $request, Closure $next): Response
    {
        $requiredFeature = $this->getRequiredFeature($request);
        $context = app(TenantContext::class);

        if ($requiredFeature && !$context->feature($requiredFeature)) {
            return response()->json([
                'message' => "The '{$requiredFeature}' feature is not included in your current plan."
            ], 403);
        }

        return $next($request);
    }

    protected function getRequiredFeature(Request $request): ?string
    {
        if ($request->is('api/tenant/whatsapp/*')) {
            return 'whatsapp';
        }

        if ($request->is('api/tenant/donations*') || $request->is('api/public/*/donations*')) {
            return 'donations';
        }

        return null;
    }
}
