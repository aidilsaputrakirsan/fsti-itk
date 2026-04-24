<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\ZiProfile;
use App\Models\ZiDocument;
use App\Models\User;

class IntegrityZoneSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ZiProfile::truncate();
        ZiDocument::truncate();
        Schema::enableForeignKeyConstraints();

        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        $sourcePath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'integrity_zones');

        if (!Storage::disk('public')->exists('zi-images')) {
            Storage::disk('public')->makeDirectory('zi-images');
        }
        if (!Storage::disk('public')->exists('zi-documents')) {
            Storage::disk('public')->makeDirectory('zi-documents');
        }

        $maklumatImage = 'maklumat-pelayanan.webp';
        $maklumatSource = $sourcePath . DIRECTORY_SEPARATOR . $maklumatImage;

        if (File::exists($maklumatSource)) {
            Storage::disk('public')->put('zi-images/' . $maklumatImage, File::get($maklumatSource));
        }

        ZiProfile::create([
            'id' => 1,
            'user_id' => $adminId,
            'description' => "Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan senantiasa berkomitmen penuh dalam mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM) melalui reformasi birokrasi yang berkesinambungan serta peningkatan kualitas pelayanan publik yang transparan dan terukur.",
            'service_declaration_image_path' => '/storage/zi-images/' . $maklumatImage,
        ]);

        $documents = [
            [
                'title' => 'SK Tim Zona Integritas FSTI Tahun 2026',
                'file_name' => 'sk-tim-zi-fsti.pdf',
            ],
            [
                'title' => 'SK Role Model Zona Integritas FSTI Periode 2025-2027',
                'file_name' => 'sk-role-model-fsti.pdf',
            ],
        ];

        foreach ($documents as $doc) {
            $fileName = $doc['file_name'];
            $fileSource = $sourcePath . DIRECTORY_SEPARATOR . $fileName;

            if (File::exists($fileSource)) {
                Storage::disk('public')->put('zi-documents/' . $fileName, File::get($fileSource));
            }

            ZiDocument::create([
                'user_id' => $adminId,
                'title' => $doc['title'],
                'file_url' => '/storage/zi-documents/' . $fileName,
            ]);
        }
    }
}
