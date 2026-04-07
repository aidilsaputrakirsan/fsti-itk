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

        // 1. Jika URL foto kosong atau data seeder berisi teks "Belum tersedia"
        if (empty($url) || trim($url) === 'Belum tersedia pada website') {
            return null; // Memicu Placeholder Abu-abu "Foto Belum Tersedia" di Frontend
        }

        // 2. JIKA FOTO DARI GOOGLE DRIVE (Bypass Pemblokiran Google Terbaru)
        if (str_contains($url, 'drive.google.com')) {
            preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches);
            if (isset($matches[1])) {
                return "https://lh3.googleusercontent.com/d/{$matches[1]}";
            }
        }

        // 3. JIKA URL ADALAH LINK INTERNET EKSTERNAL BIASA
        if (str_starts_with($url, 'http')) {
            return $url;
        }

        // 4. JIKA FOTO HASIL UPLOAD DARI ADMIN (Otomatis masuk ke folder staff/)
        if (str_starts_with($url, 'staff/')) {
            return asset('storage/' . $url);
        }

        // 5. JIKA FOTO DARI SEEDER BAWAAN (Contoh: '/images/dosen/dosen-1.png')
        // Menggunakan ltrim agar slash tidak dobel (http://localhost//images/...)
        return asset('/' . ltrim($url, '/'));
    }
}
