<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::truncate();

        $storagePdfPath = storage_path('app/public/pengumuman');
        $storagePosterPath = storage_path('app/public/pengumuman/poster');

        $assetPdfPath = database_path('seeders/assets/pengumuman');
        $assetPosterPath = database_path('seeders/assets/pengumuman/poster');

        if (!File::exists($storagePdfPath)) File::makeDirectory($storagePdfPath, 0755, true);
        if (!File::exists($storagePosterPath)) File::makeDirectory($storagePosterPath, 0755, true);

        foreach (File::files($storagePdfPath) as $file) File::delete($file);
        foreach (File::files($storagePosterPath) as $file) File::delete($file);

        $announcements = [
            [
                'title' => 'Pengumuman PILMAPRES FSTI 2026',
                'description' => "PENGUMUMAN PILMAPRES FSTI 2026\n\nHalo Sobat FSTI! 👋✨\nDalam rangka Pemilihan Mahasiswa Berprestasi (PILMAPRES) Tahun 2026, FSTI membuka pendaftaran Mahasiswa Berprestasi (Mawapres) tingkat Fakultas 🏆\n\nIni saatnya kamu menunjukkan potensi terbaikmu dan menjadi perwakilan FSTI di tingkat Institut! 💫\n\n📅 Pendaftaran: 17 – 27 Maret 2026\n📌 Syarat utama:\n✔️ IPK minimal 3,00\n✔️ Maksimal semester 6\n✔️ Melengkapi berkas sesuai ketentuan\n\n🔗 Daftar sekarang melalui:\ns.itk.ac.id/mawapresfsti2026\n\n📞 Info lebih lanjut: Chairon Ulfah (0822-3453-9861)\n\nYuk, jadi bagian dari mahasiswa berprestasi FSTI dan ukir prestasimu! 🚀✨",
                'document' => null,
                'poster' => 'pengumuman-pilmapres.png',
                'created_at' => '2026-03-17 09:00:00'
            ],
            ['title' => 'Pengumuman Himbauan Pengisian Tracer Study bagi Alumni FSTI', 'description' => null, 'document' => 'pengumuman-tracer-study.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
            ['title' => 'Pengumuman Penyesuaian Pelaksanaan Perkuliahan dan Pelayanan', 'description' => null, 'document' => 'pengumuman-penyesuaian-perkuliahan.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
            ['title' => 'Pengumuman Penyesuaian Pedoman Akademik di Lingkungan FSTI', 'description' => null, 'document' => 'pengumuman-penyesuaian-panduan.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
            ['title' => 'Pengumuman Pelaksanaan UTS Semester Genap 2024/2025', 'description' => null, 'document' => 'pengumuman-uts.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
            ['title' => 'Pengumuman ke Mahasiswa Penyesuaian Pelaksanaan Perkuliahan selama UTBK', 'description' => null, 'document' => 'pengumuman-pelaksanaan-perkuliahan.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
            ['title' => 'Pengumuman Pelatihan IAET Mahasiswa', 'description' => null, 'document' => 'pengumuman-pelatihan-iaet.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
            ['title' => 'Pengumuman Perpanjangan IPD-IPM Mahasiswa', 'description' => null, 'document' => 'pengumuman-ipd-ipm.pdf', 'poster' => null, 'created_at' => now()->subDays(rand(1, 30))],
        ];

        $copiedCount = 0;

        foreach ($announcements as $data) {
            $docPath = null;
            $posPath = null;

            if ($data['document']) {
                $sourceFile = $assetPdfPath . '/' . $data['document'];
                $destinationFile = $storagePdfPath . '/' . $data['document'];
                if (File::exists($sourceFile)) {
                    File::copy($sourceFile, $destinationFile);
                    $copiedCount++;
                    $docPath = 'pengumuman/' . $data['document'];
                } else {
                    $this->command->warn("Peringatan: File PDF '{$data['document']}' tidak ditemukan di assets/pengumuman!");
                }
            }

            if ($data['poster']) {
                $sourceFile = $assetPosterPath . '/' . $data['poster'];
                $destinationFile = $storagePosterPath . '/' . $data['poster'];
                if (File::exists($sourceFile)) {
                    File::copy($sourceFile, $destinationFile);
                    $copiedCount++;
                    $posPath = 'pengumuman/poster/' . $data['poster'];
                } else {
                    $this->command->warn("Peringatan: File Poster '{$data['poster']}' tidak ditemukan di assets/pengumuman/poster!");
                }
            }

            Announcement::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'document_path' => $docPath,
                'poster_path' => $posPath,
                'created_at' => $data['created_at'],
                'updated_at' => $data['created_at'],
            ]);
        }

        $this->command->info("Selesai! 8 Data Pengumuman berhasil di-seed. Total {$copiedCount} file (PDF/Poster) disalin ke Storage.");
    }
}
