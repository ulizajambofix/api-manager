<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        abort_unless($user && $user->roles()->whereIn('name', $roles)->exists(), 403, 'Forbidden');

        return $next($request);
    }
}
