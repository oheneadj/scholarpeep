<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function view(User $user, User $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function create(User $user): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function update(User $user, User $model): bool
    {
        // Only Super Admins can update users
        if ($user->role !== \App\Enums\UserRole::SUPER_ADMIN) {
            return false;
        }

        // Cannot modify another Super Admin's role or status
        if ($model->role === \App\Enums\UserRole::SUPER_ADMIN && $user->id !== $model->id) {
            return false;
        }

        return true;
    }

    public function delete(User $user, User $model): bool
    {
        // Only Super Admins can delete users
        if ($user->role !== \App\Enums\UserRole::SUPER_ADMIN) {
            return false;
        }

        // Cannot delete a Super Admin
        if ($model->role === \App\Enums\UserRole::SUPER_ADMIN) {
            return false;
        }

        return true;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function forceDelete(User $user, User $model): bool
    {
        // Only Super Admins can force delete users
        if ($user->role !== \App\Enums\UserRole::SUPER_ADMIN) {
            return false;
        }

        // Cannot force delete a Super Admin
        if ($model->role === \App\Enums\UserRole::SUPER_ADMIN) {
            return false;
        }

        return true;
    }
}
