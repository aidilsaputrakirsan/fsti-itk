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
        InternalService::create([
            'name' => 'Layanan FSTI ITK',
            'category' => 'Umum', // Kategori default yang disimpan
            'link_url' => 'https://layanan-fsti.myst-tech.com/',
            'description' => 'Website layanan administrasi untuk  mahasiswa dan dosen FSTI ITK',
        ]);
    }
}
