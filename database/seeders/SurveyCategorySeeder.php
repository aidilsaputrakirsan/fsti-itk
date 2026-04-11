<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveyCategory;

class SurveyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Aksesibilitas Informasi Publik',
            'Kualitas & Kelengkapan Konten Website',
            'Kejelasan Prosedur Layanan Informasi (PPID)',
            'Transparansi Dokumen Zona Integritas'
        ];

        foreach ($categories as $category) {
            SurveyCategory::firstOrCreate(
                ['name' => $category], 
                ['is_active' => true]
            );
        }
    }
}