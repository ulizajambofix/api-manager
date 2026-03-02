<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Api extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'name', 'slug', 'description', 'base_url', 'status', 'rate_limit_per_minute',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function versions()
    {
        return $this->hasMany(ApiVersion::class);
    }

    public function keys()
    {
        return $this->hasMany(ApiKey::class);
    }
}
