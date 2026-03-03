<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiRequest;
use App\Http\Resources\ApiResource;
use App\Models\Api;
use App\Services\ApiService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(private readonly ApiService $apiService)
    {
    }

    public function index(Request $request)
    {
        $tenant = app('tenant');

        $apis = Api::where('tenant_id', $tenant->id)->paginate();

        return ApiResource::collection($apis);
    }

    public function store(StoreApiRequest $request)
    {
        $tenant = app('tenant');
        $api = $this->apiService->create([...$request->validated(), 'tenant_id' => $tenant->id]);

        return new ApiResource($api);
    }

    public function update(StoreApiRequest $request, Api $api)
    {
        $this->authorize('update', $api);
        return new ApiResource($this->apiService->update($api, $request->validated()));
    }

    public function toggle(Api $api)
    {
        $this->authorize('update', $api);
        return new ApiResource($this->apiService->toggleStatus($api));
    }

    public function destroy(Api $api)
    {
        $this->authorize('delete', $api);
        $api->delete();

        return response()->noContent();
    }
}
