<?php

namespace App\Policies;

use App\Models\User;

class RequestLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('developer') || $user->hasRole('viewer');
    }
}
