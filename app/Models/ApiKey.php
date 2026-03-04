<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'api_id', 'user_id', 'name', 'key_hash', 'prefix', 'expires_at', 'revoked_at', 'last_used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    public function api()
    {
        return $this->belongsTo(Api::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function requestLogs()
    {
        return $this->hasMany(RequestLog::class);
    }
}
