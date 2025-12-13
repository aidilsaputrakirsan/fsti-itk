<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniTracer extends Model
{
    protected $fillable = [
        'title',
        'type',
        'url',
        'file_path',
        'year',
        'description',
        'is_active',
    ];
}
