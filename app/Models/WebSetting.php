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

    public function getLogoUrlAttribute()
    {
        if (!$this->logo_path) {
            return asset('images/logo/logo-icon.svg');
        }
        if (str_starts_with($this->logo_path, 'images/')) {
            return asset($this->logo_path);
        }
        return asset('storage/' . $this->logo_path);
    }

    public function getFaviconUrlAttribute()
    {
        if (!$this->favicon_path) {
            return asset('favicon.ico');
        }
        if (str_starts_with($this->favicon_path, 'images/')) {
            return asset($this->favicon_path);
        }
        return asset('storage/' . $this->favicon_path);
    }
}
