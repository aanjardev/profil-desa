<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageIdentity extends Model
{
    protected $table = 'village_identities';

    // Hanya updated_at, tidak ada created_at
    public $timestamps = false;

    protected $fillable = [
        'key',
        'title',
        'content',
        'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    // ─── Helper: ambil konten berdasarkan key ─────────────
    public static function getByKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }

    public static function getContentByKey(string $key, string $default = ''): string
    {
        return static::where('key', $key)->value('content') ?? $default;
    }
}
