<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageStatistic extends Model
{
    protected $table = 'village_statistics';

    // Hanya updated_at, tidak ada created_at
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'label',
        'icon',
        'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    // ─── Helper ────────────────────────────────────────────
    public static function getByKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }

    public static function getValueByKey(string $key, string $default = '-'): string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }
}
