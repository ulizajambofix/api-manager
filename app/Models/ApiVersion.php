<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiVersion extends Model
{
    use HasFactory;

    protected $fillable = ['api_id', 'version', 'status'];

    public function api()
    {
        return $this->belongsTo(Api::class);
    }
}
