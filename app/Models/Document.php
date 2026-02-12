<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_url',
        'uploaded_by',
        'category_id',
        'visibility',
        'status',
        'view_count',
    ];

    protected $casts = [
        'visibility' => DocumentVisibility::class,
        'status' => DocumentStatus::class,
        'view_count' => 'integer',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'document_tags')
            ->withTimestamps();
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function isPublic(): bool
    {
        return $this->visibility === DocumentVisibility::PUBLIC;
    }

    public function isRestricted(): bool
    {
        return $this->visibility === DocumentVisibility::RESTRICTED;
    }

    public function isActive(): bool
    {
        return $this->status === DocumentStatus::ACTIVE;
    }

    public function isArchived(): bool
    {
        return $this->status === DocumentStatus::ARCHIVED;
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function isFavoritedBy(User $user): bool
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
