<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternalService;

class InternalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Layanan FSTI ITK',
                'category' => 'Umum',
                'link_url' => 'https://layanan-fsti.myst-tech.com/',
                'description' => 'Website layanan administrasi untuk mahasiswa dan dosen FSTI ITK',
            ],
            [
                'name' => 'Gerbang ITK',
                'category' => 'Umum',
                'link_url' => 'https://gerbang.itk.ac.id/',
                'description' => 'portal sistem informasi akademik berbasis website yang terintegrasi di Institut Teknologi Kalimantan',
            ],
            [
                'name' => 'Learning Management System (LMS) ITK',
                'category' => 'Umum',
                'link_url' => 'https://kuliah.itk.ac.id/login/index.php',
                'description' => 'platform Learning Management System resmi Institut Teknologi Kalimantan untuk mendukung pembelajaran daring/hybrid',
            ]
        ];

        foreach ($services as $index => $service) {
            InternalService::updateOrCreate(
                ['name' => $service['name']],
                [
                    'category' => $service['category'],
                    'link_url' => $service['link_url'],
                    'description' => $service['description'],
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
