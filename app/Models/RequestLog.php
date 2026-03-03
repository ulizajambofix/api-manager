<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'api_id', 'api_key_id', 'user_id', 'endpoint', 'method', 'status_code', 'response_time_ms', 'ip_address', 'requested_at',
    ];

    protected $casts = ['requested_at' => 'datetime'];
}
