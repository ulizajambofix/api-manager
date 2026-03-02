<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $request->user()?->tenants()->wherePivot('is_default', true)->first();
        abort_unless($tenant, 403, 'Tenant context missing.');

        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
