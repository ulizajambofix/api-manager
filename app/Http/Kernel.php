<?php

namespace App\Http;

use App\Http\Middleware\EnforceApiKeyRateLimit;
use App\Http\Middleware\EnsureRole;
use App\Http\Middleware\EnsureTenantContext;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        'role' => EnsureRole::class,
        'tenant.context' => EnsureTenantContext::class,
        'api.key.rate_limit' => EnforceApiKeyRateLimit::class,
    ];
}
