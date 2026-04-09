<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'activities', 'logo'];

    // Mengubah JSON di database menjadi Array saat dipanggil
    protected $casts = [
        'activities' => 'array',
    ];
}