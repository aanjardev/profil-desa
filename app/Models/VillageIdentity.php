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
        'image_path',
        'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) return null;
        if (str_starts_with($this->image_path, 'http')) return $this->image_path;
        return asset('storage/' . $this->image_path);
    }

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
