<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model
{
    protected $table = 'ppid_documents';

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'year',
        'category',
    ];

    protected $casts = [
        'year' => 'integer',
    ];
}
