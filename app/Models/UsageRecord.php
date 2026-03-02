<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageRecord extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'api_id', 'api_key_id', 'period_start', 'period_end', 'requests_count', 'billable_units'];
}
