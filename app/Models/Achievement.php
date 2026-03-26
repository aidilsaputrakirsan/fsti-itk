<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'student_nim',
        'study_program',
        'title',
        'category',
        'level',
        'organizer',
        'year',
        'image_path',
        'certificate_path', 
    ];

    protected $appends = ['image_url', 'certificate_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function getCertificateUrlAttribute(): ?string
    {
        return $this->certificate_path ? asset('storage/' . $this->certificate_path) : null;
    }
}