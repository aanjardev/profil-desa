<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionMember extends Model
{
    protected $table = 'institution_members';

    protected $fillable = [
        'institution_id',
        'name',
        'position',
        'photo',
        'order_num',
    ];

    protected $casts = [
        'order_num' => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
