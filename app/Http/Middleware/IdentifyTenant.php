<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Mosque;
use App\Services\TenantContext;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('mosque_slug');
        $host = $request->getHost();

        // 1. Resolve Mosque (Custom Domain > Slug)
        // We do NOT allow mosque_id to be passed via request to prevent spoofing
        $mosque = Mosque::where('custom_domain', $host)
            ->orWhere('slug', $slug)
            ->first();

        if (!$mosque) {
            abort(404, "Mosque not found.");
        }

        // 2. Bind to singleton context service
        $context = app(TenantContext::class);
        $context->set($mosque);

        // 3. Bind Mosque instance as a singleton for convenience
        app()->instance(Mosque::class, $mosque);

        // 4. Share with all views
        view()->share('currentMosque', $mosque);

        // 5. SECURITY: Cross-Tenant Session Protection
        // If a user is logged in via the tenant guard, they MUST belong to this mosque
        if ($request->user('tenant')) {
            if ($request->user('tenant')->mosque_id !== $mosque->id) {
                auth('tenant')->logout();
                return redirect()->route('public.home', $mosque->slug)
                    ->with('error', 'Your session was terminated due to a tenant mismatch.');
            }
        }

        return $next($request);
    }
}
