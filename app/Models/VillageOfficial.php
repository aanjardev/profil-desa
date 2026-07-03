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
        'order_num',
    ];

    protected $casts = [
        'order_num' => 'integer',
        'level'     => 'integer',
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

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
