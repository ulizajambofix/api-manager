<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EnforceApiKeyRateLimit
{
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->header('X-API-Key');
        abort_unless($token, 401, 'API key required');

        $prefix = substr($token, 0, 12);
        $candidateKeys = ApiKey::where('prefix', $prefix)->whereNull('revoked_at')->get();

        $apiKey = $candidateKeys->first(fn ($key) => hash_equals($key->key_hash, hash('sha256', $token)));
        abort_unless($apiKey, 401, 'Invalid API key');

        if ($apiKey->expires_at && $apiKey->expires_at->isPast()) {
            abort(401, 'API key expired');
        }

        $limit = $apiKey->api->rate_limit_per_minute;
        $bucketKey = "rl:{$apiKey->id}:".now()->format('YmdHi');
        $count = Cache::increment($bucketKey);
        Cache::put($bucketKey, $count, 60);

        if ($count > $limit) {
            return new JsonResponse(['message' => 'Rate limit exceeded'], 429);
        }

        $request->attributes->set('resolved_api_key', $apiKey);

        return $next($request);
    }
}
