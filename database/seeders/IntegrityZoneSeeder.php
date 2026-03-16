<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\ZiProfile;
use App\Models\ZiDocument;
use App\Models\User;

class IntegrityZoneSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BERSIHKAN DATA LAMA (Gaya PPID Seeder)
        Schema::disableForeignKeyConstraints();
        ZiProfile::truncate();
        ZiDocument::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Ambil User Admin
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        // 3. MASUKKAN PROFIL ZI (Otomatis ID 1 karena baru di-truncate)
        ZiProfile::create([
            'id' => 1,
            'user_id' => $adminId,
            'description' => "Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM) melalui reformasi birokrasi yang berkesinambungan serta peningkatan kualitas pelayanan publik yang transparan dan terukur.",
            'service_declaration_image_path' => '/storage/zi-images/maklumat-pelayanan.png',
        ]);

        // 4. SIAPKAN DOKUMEN ZI
        $documents = [
            [
                'title' => 'SK Tim Zona Integritas FSTI Tahun 2025',
                'file_url' => '/storage/zi-documents/sk-tim-zi-fsti.pdf',
            ],
            [
                'title' => 'SK Role Model Zona Integritas FSTI Periode 2025-2027',
                'file_url' => '/storage/zi-documents/sk-role-model-fsti.pdf',
            ],
        ];

        // 5. MASUKKAN DOKUMEN ZI
        foreach ($documents as $doc) {
            ZiDocument::create([
                'user_id' => $adminId,
                'title' => $doc['title'],
                'file_url' => $doc['file_url'],
            ]);
        }
    }
}
