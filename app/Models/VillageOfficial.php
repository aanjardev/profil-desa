<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class VillageOfficial extends Model
{
    protected $table = 'village_officials';

    protected $fillable = [
        'name',
        'nip',
        'position',
        'photo',
        'status',
        'order_num',
    ];

    protected $casts = [
        'order_num' => 'integer',
    ];

    // ─── Scopes ───────────────────────────────────────────
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order_num');
    }
}
