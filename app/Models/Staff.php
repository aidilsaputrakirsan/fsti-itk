<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nip',
        'type',
        'structural_position',
        'functional_position',
        'image_url',
        'education_history',
        'expertise',
        'competency_certification',
        'research_history',
        'community_service_history',
        'work_experience',
        'awards',
        'academic_profiles'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'education_history' => 'array',
        'expertise' => 'array',
        'competency_certification' => 'array',
        'research_history' => 'array',
        'community_service_history' => 'array',
        'work_experience' => 'array',
        'awards' => 'array',
        'academic_profiles' => 'array',
    ];

    protected $appends = ['display_image'];

    public function getDisplayImageAttribute()
    {
        $url = $this->image_url;

        if (!$url) return '/images/default-avatar.png';

        if (str_contains($url, 'drive.google.com')) {
            preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches);
            if (isset($matches[1])) {
                $fileId = $matches[1];
                return "https://lh3.googleusercontent.com/d/{$fileId}";
            }
        }

        return $url;
    }
}
