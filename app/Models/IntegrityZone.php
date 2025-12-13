<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrityZone extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'document_path',
        'image_path',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
