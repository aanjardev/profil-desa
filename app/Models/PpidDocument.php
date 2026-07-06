<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model
{
    protected $table = 'ppid_documents';

    protected $fillable = [
        'register_no',
        'title',
        'description',
        'file_path',
        'file_label',
        'is_active',
        'year',
        'category',
        'established_date',
    ];

    protected $casts = [
        'year' => 'integer',
        'established_date' => 'date',
        'is_active' => 'boolean',
    ];
}
