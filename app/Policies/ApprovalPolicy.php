<?php

namespace App\Policies;

use App\Models\User;

class ApprovalPolicy
{
    public function viewAny(User $authUser): bool
    {
        return $authUser->isSuperAdmin() || $authUser->isAdmin();
    }

    public function approve(User $authUser, User $user): bool
    {
        if ($authUser->isSuperAdmin()) {
            return true;
        }

        if ($authUser->isAdmin() && $user->isStudent()) {
            return $authUser->course === $user->course;
        }

        return false;
    }
}