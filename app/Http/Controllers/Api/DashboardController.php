<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService)
    {
    }

    public function summary()
    {
        $tenant = app('tenant');
        return response()->json($this->dashboardService->summary($tenant->id));
    }

    public function analytics()
    {
        $tenant = app('tenant');
        return response()->json(['data' => $this->dashboardService->chartData($tenant->id)]);
    }
}
