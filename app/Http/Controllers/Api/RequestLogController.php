<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RequestLog;
use Illuminate\Http\Request;

class RequestLogController extends Controller
{
    public function index(Request $request)
    {
        $tenant = app('tenant');

        $query = RequestLog::where('tenant_id', $tenant->id)
            ->when($request->date, fn ($q) => $q->whereDate('requested_at', $request->date))
            ->when($request->status_code, fn ($q) => $q->where('status_code', $request->status_code))
            ->when($request->api_id, fn ($q) => $q->where('api_id', $request->api_id))
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id));

        return $query->latest('requested_at')->paginate();
    }
}
