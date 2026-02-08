<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Mosque;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforcePlanLimits
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $mosque = app(Mosque::class);
        $plan = $mosque->plan; // Assuming relation from Step 1

        // Example: Check if current route requires a specific feature
        // This is a simple implementation; in production, we'd use route-specific feature checks.
        $requiredFeature = $this->getRequiredFeature($request);

        if ($requiredFeature && !in_array($requiredFeature, $plan->features ?? [])) {
            // Check for overrides
            $override = $mosque->overrides()->where('feature', $requiredFeature)->first();
            if (!$override || !$override->enabled) {
                abort(403, "The '{$requiredFeature}' feature is not included in your current plan.");
            }
        }

        return $next($request);
    }

    protected function getRequiredFeature(Request $request): ?string
    {
        // Logic to map routes to features
        if ($request->is('*/whatsapp/*')) return 'whatsapp';
        if ($request->is('*/donations/*')) return 'donations';
        return null;
    }
}