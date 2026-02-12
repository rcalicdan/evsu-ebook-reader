<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use App\Enums\UserRole;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any documents.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view the documents list
    }

    /**
     * Determine whether the user can view the document.
     */
    public function view(User $user, Document $document): bool
    {
        // Public documents can be viewed by anyone
        if ($document->isPublic()) {
            return true;
        }

        // Restricted documents can only be viewed by admins/superadmins or the uploader
        return $user->isAdmin() 
            || $user->isSuperAdmin() 
            || $document->uploaded_by === $user->id;
    }

    /**
     * Determine whether the user can create documents.
     */
    public function create(User $user): bool
    {
        // All authenticated users can upload documents
        return true;
    }

    /**
     * Determine whether the user can update the document.
     */
    public function update(User $user, Document $document): bool
    {
        // Admins, superadmins, or the uploader can update
        return $user->isAdmin() 
            || $user->isSuperAdmin() 
            || $document->uploaded_by === $user->id;
    }

    /**
     * Determine whether the user can delete the document.
     */
    public function delete(User $user, Document $document): bool
    {
        // Only admins, superadmins, or the uploader can delete
        return $user->isAdmin() 
            || $user->isSuperAdmin() 
            || $document->uploaded_by === $user->id;
    }

    /**
     * Determine whether the user can restore the document.
     */
    public function restore(User $user, Document $document): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the document.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return $user->isSuperAdmin();
    }
}