<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'job', 'study_program', 'graduation_year', 'photo', 'message', 'is_active'
    ];
}