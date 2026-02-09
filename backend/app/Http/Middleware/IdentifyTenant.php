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
        $slug = $request->header('X-Tenant-Slug')
            ?? $request->route('slug')
            ?? $request->route('mosque_slug');

        $mosque = null;

        if ($slug) {
            $mosque = Mosque::where('slug', $slug)->first();
        }

        if (!$mosque) {
            $host = $request->getHost();
            $mosque = Mosque::where('custom_domain', $host)->first();
        }

        if (!$mosque) {
            return response()->json(['message' => 'Mosque not found.'], 404);
        }

        $context = app(TenantContext::class);
        $context->set($mosque);

        app()->instance(Mosque::class, $mosque);

        if ($request->user('tenant') && $request->user('tenant')->mosque_id !== $mosque->id) {
            return response()->json(['message' => 'Access denied to this mosque.'], 403);
        }

        return $next($request);
    }
}
