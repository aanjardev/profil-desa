<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourismUmkmImage extends Model
{
    protected $table = 'tourism_umkm_images';

    // Tidak ada updated_at, hanya created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'tourism_umkm_id',
        'image_path',
        'caption',
        'is_thumbnail',
        'order_num',
    ];

    protected $casts = [
        'is_thumbnail' => 'boolean',
        'order_num'    => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────
    public function tourismUmkm(): BelongsTo
    {
        return $this->belongsTo(TourismUmkm::class, 'tourism_umkm_id');
    }
}
