<?php

namespace App\Repositories;

use App\Models\Api;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApiRepository
{
    public function paginateForTenant(int $tenantId, int $perPage = 15): LengthAwarePaginator
    {
        return Api::where('tenant_id', $tenantId)->latest()->paginate($perPage);
    }
}
