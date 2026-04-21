<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('scholarships')->truncate();

        $scholarships = [
            [
                'title' => 'Beasiswa Kaltim Tuntas 2026',
                'provider' => 'Pemerintah Provinsi Kalimantan Timur',
                'description' => 'Program Beasiswa Kaltim Tuntas diberikan kepada mahasiswa asal Kalimantan Timur yang sedang menempuh pendidikan jenjang D3, D4, S1, S2, dan S3. Beasiswa ini mencakup bantuan biaya UKT/SPP hingga lulus.',
                'link_url' => 'https://beasiswa.kaltimprov.go.id/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Beasiswa Bank Indonesia (GenBI) 2026',
                'provider' => 'Bank Indonesia',
                'description' => 'Beasiswa dari Bank Indonesia untuk mahasiswa jenjang S1 yang memiliki prestasi akademik, aktif berorganisasi, dan berasal dari keluarga pra-sejahtera. Penerima beasiswa akan tergabung dalam komunitas Generasi Baru Indonesia (GenBI).',
                'link_url' => 'https://generasibaruindonesia.com/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Djarum Beasiswa Plus',
                'provider' => 'Djarum Foundation',
                'description' => 'Program Djarum Beasiswa Plus tidak hanya memberikan dana beasiswa, melainkan juga memberikan berbagai macam pelatihan soft skills (keterampilan lunak) kepada para penerimanya (Beswan Djarum) untuk membentuk karakter pemimpin masa depan.',
                'link_url' => 'https://djarumbeasiswaplus.org/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Beasiswa Unggulan Masyarakat Berprestasi',
                'provider' => 'Kemendikbudristek RI',
                'description' => 'Beasiswa Unggulan ditujukan kepada masyarakat berprestasi tingkat nasional maupun internasional untuk melanjutkan pendidikan di jenjang sarjana, magister, dan doktor di perguruan tinggi negeri maupun swasta.',
                'link_url' => 'https://beasiswaunggulan.kemdikbud.go.id/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'BSI Scholarship Inspirasi',
                'provider' => 'Bank Syariah Indonesia (BSI)',
                'description' => 'BSI Scholarship Inspirasi adalah program beasiswa yang ditujukan untuk mahasiswa prasejahtera. Fasilitas meliputi bantuan Uang Kuliah Tunggal (UKT), pembinaan kepemimpinan, dan literasi ekonomi syariah.',
                'link_url' => 'https://bsischolarship.id/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Beasiswa VDMI (Van Deventer-Maas Indonesia)',
                'provider' => 'Yayasan VDMI',
                'description' => 'Beasiswa VDMI diberikan kepada mahasiswa dari keluarga kurang mampu namun memiliki prestasi akademik yang baik. Fasilitas berupa bantuan dana bulanan, bonus kelulusan tepat waktu, dan pelatihan pengembangan diri.',
                'link_url' => 'https://vandeventermaas.or.id/ers/',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Informasi Beasiswa Internal ITK',
                'provider' => 'Kemahasiswaan ITK',
                'description' => 'Daftar pembaruan beasiswa yang dikoordinir langsung oleh pihak Kemahasiswaan Institut Teknologi Kalimantan, termasuk beasiswa mitra perusahaan dan Ikatan Alumni.',
                'link_url' => 'https://kemahasiswaan.itk.ac.id/beasiswa',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('scholarships')->insert($scholarships);
    }
}
