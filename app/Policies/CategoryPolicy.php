<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any categories.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view the categories list
       return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can view the category.
     */
    public function view(User $user, Category $category): bool
    {
        // All authenticated users can view individual categories
       return $user->isAdmin() || $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create categories.
     */
    public function create(User $user): bool
    {
        // Only superadmins and admins can create categories
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the category.
     */
    public function update(User $user, Category $category): bool
    {
        // Only superadmins and admins can update categories
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the category.
     */
    public function delete(User $user, Category $category): bool
    {
        // Only superadmins and admins can delete categories
        return $user->isSuperAdmin() || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the category.
     */
    public function restore(User $user, Category $category): bool
    {
        // Only superadmins can restore deleted categories
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the category.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        // Only superadmins can force delete categories
        return $user->isSuperAdmin();
    }
}