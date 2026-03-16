<?php

namespace App\Policies;

use App\Models\DocumentComment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Super Admin bypasses all checks — can create, edit, delete any comment.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Who can create a comment:
     * - Super Admin (handled by before())
     * - Admin: yes
     * - Student: yes
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isStudent();
    }

    /**
     * Who can edit a comment:
     * - Super Admin (handled by before())
     * - Admin: their own comments OR comments by students of their course
     * - Student: only their own comments
     */
    public function update(User $user, DocumentComment $comment): bool
    {
        // Owner can always edit their own
        if ($user->id === $comment->user_id) {
            return true;
        }

        // Admin can edit comments from students in their course,
        // but NOT comments by Super Admins
        if ($user->isAdmin()) {
            $commenter = $comment->user;

            return $commenter !== null
                && !$commenter->isSuperAdmin()  // ← block Super Admin comments
                && $commenter->isStudent()
                && $commenter->course?->value === $user->course?->value;
        }

        return false;
    }

    public function delete(User $user, DocumentComment $comment): bool
    {
        // Owner can always delete their own
        if ($user->id === $comment->user_id) {
            return true;
        }

        // Admin can delete comments from students in their course,
        // but NOT comments by Super Admins
        if ($user->isAdmin()) {
            $commenter = $comment->user;

            return $commenter !== null
                && !$commenter->isSuperAdmin()  // ← block Super Admin comments
                && $commenter->isStudent()
                && $commenter->course?->value === $user->course?->value;
        }

        return false;
    }
}
