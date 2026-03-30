<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'degree',
        'slug',
        'description',
        'vision',
        'mission',
        'goals',
        'graduate_profiles',
        'accreditation_certificate_image',
        'accreditation_pdf_link',
        'accreditation_text',
        'website_link'
    ];

    protected $casts = [
        'mission' => 'array',
        'graduate_profiles' => 'array',
    ];
}
