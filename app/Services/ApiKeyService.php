<?php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ApiKeyService
{
    public function generate(array $data): array
    {
        $plainText = 'ak_'.Str::random(48);

        $key = ApiKey::create([
            ...$data,
            'prefix' => substr($plainText, 0, 12),
            'key_hash' => hash('sha256', $plainText),
            'expires_at' => $data['expires_at'] ?? null,
        ]);

        return [$key, $plainText];
    }

    public function revoke(ApiKey $key): ApiKey
    {
        $key->update(['revoked_at' => Carbon::now()]);
        return $key;
    }
}
