<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'file_path',
        'is_active',
    ];
}
