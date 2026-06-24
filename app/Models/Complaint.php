<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'reporter_name',
        'reporter_phone',
        'reporter_email',
        'title',
        'content',
        'attachment',
        'status',
        'admin_response',
    ];

    // ─── Scopes ───────────────────────────────────────────
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeProses(Builder $query): Builder
    {
        return $query->where('status', 'proses');
    }

    public function scopeSelesai(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }
}
