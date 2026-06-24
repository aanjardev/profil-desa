<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RtRw extends Model
{
    protected $table = 'rt_rws';

    protected $fillable = [
        'rw_number',
        'rt_number',
        'head_name',
        'head_phone',
        'total_kk',
        'total_male',
        'total_female',
        'area_name',
        'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'total_kk'     => 'integer',
        'total_male'   => 'integer',
        'total_female' => 'integer',
    ];

    // ─── Helper ───────────────────────────────────────────
    public function getTotalPendudukAttribute(): int
    {
        return $this->total_male + $this->total_female;
    }

    public function getIsRwAttribute(): bool
    {
        return is_null($this->rt_number);
    }

    // ─── Scopes ───────────────────────────────────────────
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByRw(Builder $query, string $rw): Builder
    {
        return $query->where('rw_number', $rw);
    }
}
