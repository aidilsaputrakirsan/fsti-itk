<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $fillable = [
        'key',
        'title',
        'content',
        'image_path',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
