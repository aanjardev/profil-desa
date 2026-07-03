<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'owner_name',
        'opening_hours',
        'location',
        'contact_person',
        'instagram_link',
        'youtube_link',
        'marketplace_link',
        'facilities',
        'main_image',
        'supporting_images',
        'is_active',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'supporting_images' => 'array',
    ];
}
