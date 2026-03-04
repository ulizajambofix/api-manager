<?php

namespace App\Policies;

use App\Models\ApiKey;
use App\Models\User;

class ApiKeyPolicy
{
    public function viewAny(User $user): bool { return $user->hasRole('admin') || $user->hasRole('developer') || $user->hasRole('viewer'); }
    public function create(User $user): bool { return $user->hasRole('admin') || $user->hasRole('developer'); }
    public function update(User $user, ApiKey $apiKey): bool { return $user->hasRole('admin') || $user->id === $apiKey->user_id; }
    public function delete(User $user, ApiKey $apiKey): bool { return $user->hasRole('admin'); }
}
