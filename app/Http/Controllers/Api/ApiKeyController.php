<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Services\ApiKeyService;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function __construct(private readonly ApiKeyService $apiKeyService)
    {
    }

    public function index(Request $request)
    {
        $tenant = app('tenant');

        return ApiKey::where('tenant_id', $tenant->id)
            ->withCount('requestLogs')
            ->paginate();
    }

    public function store(Request $request)
    {
        $request->validate([
            'api_id' => ['required', 'exists:apis,id'],
            'user_id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:100'],
            'expires_at' => ['nullable', 'date'],
        ]);

        [$apiKey, $plainText] = $this->apiKeyService->generate([
            ...$request->only(['api_id', 'user_id', 'name', 'expires_at']),
            'tenant_id' => app('tenant')->id,
        ]);

        return response()->json(['id' => $apiKey->id, 'token' => $plainText], 201);
    }

    public function revoke(ApiKey $apiKey)
    {
        $this->authorize('update', $apiKey);

        return response()->json($this->apiKeyService->revoke($apiKey));
    }
}
