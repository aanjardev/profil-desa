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
        'maps_link',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'is_featured'       => 'boolean',
        'supporting_images' => 'array',
    ];

    // Scope untuk item yang disematkan di beranda
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
