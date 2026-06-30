<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tourism extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'tickets',
        'spots',
        'opening_hours',
        'location',
        'maps_link',
        'digital_map_link',
        'instagram_link',
        'youtube_link',
        'order_link',
        'facilities',
        'contact_person',
        'main_image',
        'supporting_images',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'supporting_images' => 'array',
        'tickets' => 'array',
        'spots' => 'array',
    ];
}
