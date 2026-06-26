<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'maps_link',
        'audience',
        'organizer',
        'contact_person',
        'image',
        'status',
        'is_active',
    ];
}
