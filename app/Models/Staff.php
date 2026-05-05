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
        'is_active',
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

        if (empty($url) || trim($url) === 'Belum tersedia pada website') {
            return null;
        }

        if (str_contains($url, 'drive.google.com')) {
            preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches);
            if (isset($matches[1])) {
                $driveId = $matches[1];

                $driveUrl = "https://drive.google.com/uc?export=view&id={$driveId}";

                return "https://wsrv.nl/?url=" . urlencode($driveUrl) . "&w=400&h=400&fit=cover&output=webp&q=80";
            }
        }

        if (str_starts_with($url, 'http')) {
            return $url;
        }

        if (str_starts_with($url, 'staff/')) {
            return asset('storage/' . $url);
        }

        return asset('/' . ltrim($url, '/'));
    }
}
