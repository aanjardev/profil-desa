<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'is_hero_banner',
        'category',
    ];

    protected $casts = [
        'is_hero_banner' => 'boolean',
    ];

    // ─── Scopes ───────────────────────────────────────────
    public function scopeHeroBanners(Builder $query): Builder
    {
        return $query->where('is_hero_banner', true);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
