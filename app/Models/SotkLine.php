<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SotkLine extends Model
{
    protected $fillable = [
        'source_id',
        'target_id',
        'line_type',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(VillageOfficial::class, 'source_id');
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(VillageOfficial::class, 'target_id');
    }
}
