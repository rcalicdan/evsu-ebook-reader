<?php

namespace App\Models;

use App\Enums\Course;
use App\Enums\UserRole;
use App\Libraries\Audit\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Auditable, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'course',
        'is_approved',
        'is_suspended',
        'is_rejected',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'role'        => UserRole::class,
        'course'      => Course::class,
        'is_approved' => 'boolean',
        'is_suspended' => 'boolean',
        'is_rejected' => 'boolean',
    ];

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function createdCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'created_by');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteDocuments(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'favorites')
            ->withTimestamps();
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SUPERADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isStudent(): bool
    {
        return $this->role === UserRole::STUDENT;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isSuspended(): bool
    {
        return (bool) $this->is_suspended;
    }

    public function isApproved(): bool
    {
        return (bool) $this->is_approved;
    }

    public function isRejected(): bool
    {
        return (bool) $this->is_rejected;
    }

    public function readLater(): HasMany
    {
        return $this->hasMany(ReadLater::class);
    }

    public function readLaterDocuments(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'read_later')
            ->withPivot(['is_read', 'read_at', 'last_page'])
            ->withTimestamps();
    }

    public function savedForLater(int $documentId): bool
    {
        return $this->readLater()->where('document_id', $documentId)->exists();
    }
}
