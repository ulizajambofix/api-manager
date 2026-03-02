<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'billing_email', 'is_active'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function apis()
    {
        return $this->hasMany(Api::class);
    }
}
