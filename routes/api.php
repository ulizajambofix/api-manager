<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiKeyController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\RequestLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified', 'tenant.context'])->group(function () {
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics']);

    Route::apiResource('apis', ApiController::class);
    Route::patch('apis/{api}/toggle', [ApiController::class, 'toggle']);

    Route::get('api-keys', [ApiKeyController::class, 'index']);
    Route::post('api-keys', [ApiKeyController::class, 'store']);
    Route::patch('api-keys/{apiKey}/revoke', [ApiKeyController::class, 'revoke']);

    Route::get('request-logs', [RequestLogController::class, 'index']);
});

Route::middleware(['api.key.rate_limit'])->group(function () {
    Route::post('/gateway/{api:slug}/{version}', fn () => response()->json(['ok' => true]));
});
