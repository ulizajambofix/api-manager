<?php

namespace App\Services;

use App\Models\WebhookEndpoint;
use Illuminate\Support\Facades\Http;

class WebhookService
{
    public function dispatch(int $tenantId, string $event, array $payload): void
    {
        $hooks = WebhookEndpoint::where('tenant_id', $tenantId)
            ->where('event', $event)
            ->where('is_active', true)
            ->get();

        foreach ($hooks as $hook) {
            Http::withHeaders([
                'X-Webhook-Event' => $event,
                'X-Webhook-Signature' => hash_hmac('sha256', json_encode($payload), $hook->secret),
            ])->post($hook->url, $payload);
        }
    }
}
