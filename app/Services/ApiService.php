<?php

namespace App\Services;

use App\Models\Api;

class ApiService
{
    public function create(array $data): Api
    {
        return Api::create($data);
    }

    public function update(Api $api, array $data): Api
    {
        $api->update($data);
        return $api->refresh();
    }

    public function toggleStatus(Api $api): Api
    {
        $api->status = ! $api->status;
        $api->save();

        return $api;
    }
}
