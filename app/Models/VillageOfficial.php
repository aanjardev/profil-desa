<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VillageOfficial extends Model
{
    protected $table = 'village_officials';

    protected $fillable = [
        'parent_id',
        'level',
        'name',
        'nip',
        'position',
        'photo',
        'status',
        'type',
        'order_num',
        'pos_x',
        'pos_y',
    ];

    protected $casts = [
        'order_num' => 'integer',
        'level'     => 'integer',
        'pos_x'     => 'integer',
        'pos_y'     => 'integer',
    ];

    // ─── Relations ────────────────────────────────────────────────
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order_num');
    }

    // ─── Scopes ───────────────────────────────────────────────────
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order_num');
    }

    public function scopeRoots(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeByLevel(Builder $query, int $level): Builder
    {
        return $query->where('level', $level);
    }

    // ─── Helpers ──────────────────────────────────────────────────
    public function getLevelLabelAttribute(): string
    {
        return match ($this->level) {
            1 => 'Kepala',
            2 => 'Pejabat / Kepala Seksi',
            3 => 'Staff / Staf',
            default => 'Lainnya',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'legislatif'  => 'Legislatif (BPD)',
            'kasun'       => 'Kasun (Kepala Dusun)',
            'staf'        => 'Staf',
            default       => 'Eksekutif',
        };
    }

    /**
     * Returns Tailwind color classes for each type badge.
     * Format: [bg, text, border]
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->type) {
            'legislatif'  => 'bg-purple-100 text-purple-700 border-purple-200',
            'kasun'       => 'bg-amber-100 text-amber-700 border-amber-200',
            'staf'        => 'bg-gray-100 text-gray-600 border-gray-200',
            default       => 'bg-blue-100 text-blue-700 border-blue-200',
        };
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
