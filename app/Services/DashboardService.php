<?php

namespace App\Services;

use App\Models\Api;
use App\Models\ApiKey;
use App\Models\RequestLog;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function summary(int $tenantId): array
    {
        return [
            'total_apis' => Api::where('tenant_id', $tenantId)->count(),
            'active_api_keys' => ApiKey::where('tenant_id', $tenantId)->whereNull('revoked_at')->count(),
            'requests_today' => RequestLog::where('tenant_id', $tenantId)->whereDate('requested_at', now()->toDateString())->count(),
            'requests_this_month' => RequestLog::where('tenant_id', $tenantId)->whereBetween('requested_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'failed_requests' => RequestLog::where('tenant_id', $tenantId)->where('status_code', '>=', 400)->count(),
        ];
    }

    public function chartData(int $tenantId): array
    {
        return RequestLog::query()
            ->selectRaw('DATE(requested_at) as day, count(*) as total')
            ->where('tenant_id', $tenantId)
            ->whereBetween('requested_at', [now()->subDays(30), now()])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->toArray();
    }
}
