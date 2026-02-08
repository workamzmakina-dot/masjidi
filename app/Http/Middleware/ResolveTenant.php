<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Mosque;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('mosque_slug');
        $host = $request->getHost();

        // 1. Resolve by Custom Domain first, then by Slug
        $mosque = Mosque::where('custom_domain', $host)
            ->orWhere('slug', $slug)
            ->first();

        if (!$mosque) {
            abort(404, "Mosque not found.");
        }

        // 2. Bind the Mosque instance as a singleton to the container
        // This allows Models and Controllers to access current context via app(Mosque::class)
        app()->instance(Mosque::class, $mosque);

        // 3. Share with all Blade views
        view()->share('currentMosque', $mosque);

        // 4. Ensure tenant admins are accessing their own mosque
        if ($request->user('tenant') && $request->user('tenant')->mosque_id !== $mosque->id) {
            abort(403, "Access denied to this mosque administrative area.");
        }

        return $next($request);
    }
}