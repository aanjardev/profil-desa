<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'category',
        'event_date',
        'is_published',
        'is_featured',
        'views',
        'user_id',
    ];

    protected $casts = [
        'event_date'   => 'datetime',
        'is_published' => 'boolean',
        'is_featured'  => 'boolean',
        'views'        => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ───────────────────────────────────────────
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeBerita(Builder $query): Builder
    {
        return $query->where('category', 'berita');
    }

    public function scopePengumuman(Builder $query): Builder
    {
        return $query->where('category', 'pengumuman');
    }

    public function scopeAgenda(Builder $query): Builder
    {
        return $query->where('category', 'agenda');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // ─── Helper ───────────────────────────────────────────
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
