<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    protected $table = 'post_images';

    protected $fillable = [
        'post_id',
        'image_path',
        'caption',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
