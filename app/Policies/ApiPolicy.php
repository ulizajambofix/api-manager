<?php

namespace App\Policies;

use App\Models\Api;
use App\Models\User;

class ApiPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('admin') || $user->hasRole('developer') || $user->hasRole('viewer'); }
    public function view(User $user, Api $api): bool { return $this->viewAny($user); }
    public function create(User $user): bool { return $user->hasRole('admin') || $user->hasRole('developer'); }
    public function update(User $user, Api $api): bool { return $user->hasRole('admin') || $user->hasRole('developer'); }
    public function delete(User $user, Api $api): bool { return $user->hasRole('admin'); }
}
