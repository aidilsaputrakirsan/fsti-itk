<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyProfile extends Model
{
    use HasFactory;

    protected $table = 'faculty_profiles';

    protected $fillable = ['content'];

    protected $casts = [
        'content' => 'array',
    ];
}
