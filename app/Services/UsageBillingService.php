<?php

namespace App\Services;

use App\Models\UsageRecord;

class UsageBillingService
{
    public function incrementUsage(array $dimensions): void
    {
        UsageRecord::query()->updateOrCreate(
            [
                'tenant_id' => $dimensions['tenant_id'],
                'api_id' => $dimensions['api_id'],
                'api_key_id' => $dimensions['api_key_id'] ?? null,
                'period_start' => now()->startOfMonth()->toDateString(),
                'period_end' => now()->endOfMonth()->toDateString(),
            ],
            ['requests_count' => \DB::raw('requests_count + 1'), 'billable_units' => \DB::raw('billable_units + 1')]
        );
    }
}
