<?php

namespace App\Policies;

use App\Models\PointRule;
use App\Models\User;

class PointRulePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function view(User $user, PointRule $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function create(User $user): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function update(User $user, PointRule $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function delete(User $user, PointRule $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function restore(User $user, PointRule $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function forceDelete(User $user, PointRule $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }
}
