<?php

namespace App\Policies;

use App\Models\EmailTemplate;
use App\Models\User;

class EmailTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function view(User $user, EmailTemplate $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function create(User $user): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function update(User $user, EmailTemplate $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function delete(User $user, EmailTemplate $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function restore(User $user, EmailTemplate $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function forceDelete(User $user, EmailTemplate $model): bool
    {
        return $user->role === \App\Enums\UserRole::SUPER_ADMIN;
    }
}
