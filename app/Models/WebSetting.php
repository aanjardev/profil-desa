<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $table = 'web_settings';

    // Hanya satu baris setting, tidak perlu timestamps created_at
    public $timestamps = false;

    protected $fillable = [
        'village_name',
        'subdistrict',
        'city',
        'province',
        'address',
        'phone',
        'email',
        'logo_path',
        'favicon_path',
        'maps_embed',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'updated_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];
}
