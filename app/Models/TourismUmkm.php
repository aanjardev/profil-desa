<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class TourismUmkm extends Model
{
    protected $table = 'tourism_umkm';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'location',
        'maps_link',
        'contact',
        'website',
        'image',
        'is_active',
        'views',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views'     => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────
    public function images(): HasMany
    {
        return $this->hasMany(TourismUmkmImage::class, 'tourism_umkm_id');
    }

    public function thumbnail()
    {
        return $this->images()->where('is_thumbnail', true)->first();
    }

    // ─── Scopes ───────────────────────────────────────────
    public function scopeWisata(Builder $query): Builder
    {
        return $query->where('type', 'wisata');
    }

    public function scopeUmkm(Builder $query): Builder
    {
        return $query->where('type', 'umkm');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // ─── Helper ───────────────────────────────────────────
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
