<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        Partner::truncate();

        $sourcePath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'partners');

        if (!Storage::disk('public')->exists('partners')) {
            Storage::disk('public')->makeDirectory('partners');
        }

        $partners = [
            ['name' => 'Chongqing University of Technology (CQUT), China', 'logo' => 'cqut.webp', 'activities' => []],
            ['name' => 'Krishna Institute of Engineering and Technology (KIET), India', 'logo' => 'kiet.webp', 'activities' => []],

            ['name' => 'Universitas Brawijaya', 'logo' => 'universitas-brawijaya.webp', 'activities' => ['Penyelenggaraan Pendidikan, Penelitian, dan Pengabdian Masyarakat', 'Mahasiswa Inbound Departemen Fisika', 'Mahasiswa Inbound Departemen Matematika']],
            ['name' => 'Universitas Hasanuddin', 'logo' => 'universitas-hasanuddin.webp', 'activities' => ['Pendidikan, Penelitian, dan Pengabdian Masyarakat']],
            ['name' => 'Universitas Kristen Maranatha', 'logo' => 'universitas-kristen.webp', 'activities' => ['Pelaksanaan Tridharma PT']],
            ['name' => 'FHB Universitas Kristen Maranatha', 'logo' => 'universitas-kristen.webp', 'activities' => ['Pelaksanaan Tridharma PT']],
            ['name' => 'FTRC Universitas Kristen Maranatha', 'logo' => 'universitas-kristen.webp', 'activities' => ['Pelaksanaan Tridharma PT']],
            ['name' => 'FSAD ITS', 'logo' => 'fsad-its.webp', 'activities' => ['Pelaksanaan Kegiatan Peningkatan Kapasitas Tata Kelola Fakultas', 'Pendidikan, Penelitian, dan Pengabdian Masyarakat']],
            ['name' => 'Departemen Matematika ITS', 'logo' => 'matematika-its.webp', 'activities' => ['Pelatihan Peningkatan Pembelajaran Berbasis Artificial Intelligence di SMK Cendekia Al-Izzah Balikpapan']],
            ['name' => 'Fakultas Teknologi Elektro dan Informatika Cerdas ITS', 'logo' => 'fteic-its.webp', 'activities' => ['Pelatihan Peningkatan Pembelajaran Berbasis Artificial Intelligence di SMK Cendekia Al-Izzah Balikpapan']],
            ['name' => 'FT Univ Negeri Malang', 'logo' => 'universitas-malang.webp', 'activities' => []],
            ['name' => 'FT Unesa', 'logo' => 'unesa.webp', 'activities' => []],
            ['name' => 'UPN Veteran Jawa Timur', 'logo' => 'upn.webp', 'activities' => ['Pelaksanaan Seminar Sains Data (SENADA) 2025']],
            ['name' => 'SMAN 7 Balikpapan', 'logo' => 'sma-7.webp', 'activities' => ['Program Mengajar di Sekolah dan Pembimbingan Akademik']],
            ['name' => 'SMAN 9 Balikpapan', 'logo' => 'sma-9.webp', 'activities' => ['Program Mengajar di Sekolah dan Pembimbingan Akademik SDM']],
            ['name' => 'SMK Cendikia Al-Izzah Balikpapan', 'logo' => 'smk-cendekia.webp', 'activities' => ['Pengembangan Sumber Daya Manusia Melalui Kegiatan Pengajaran dan Pembimbingan']],

            ['name' => 'OIKN Bidang Transformasi Hijau dan Digital', 'logo' => 'oikn.webp', 'activities' => []],
            ['name' => 'BPSDMP Kominfo Banjarmasin KOMDIGI', 'logo' => 'bpsdm.webp', 'activities' => ['Sertifikasi VSGA', 'Program DEA (Digital Entrepreneurship Acedemy)', 'Pelatihan Diploy']],
            ['name' => 'BPSDM Komdigi', 'logo' => 'bpsdm.webp', 'activities' => ['Penyelenggaran Program Beasiswa Talenta Digital', 'Pelaksanaan Program Pendidikan dan Pengembangan SDM Bidang Komunikasi dan Digital']],
            ['name' => 'Brida Kaltim', 'logo' => 'brida-kaltim.webp', 'activities' => ['Pelaksanaan Pendidikan, Penelitian, dan Pengabdian Masyarakat']],
            ['name' => 'BPS Kota Balikpapan', 'logo' => 'bps.webp', 'activities' => ['Kegiatan Workshop Satria Data 2025', 'Kuliah Tamu Hari Statistik Nasional', 'Kegiatan Expo Kerja Praktik']],
            ['name' => 'DKUMKMP Balikpapan', 'logo' => 'dkumkmp.webp', 'activities' => ['Kemitraan Dalam Kegiatan Inovasi Sosial Mahasiswa']],
            ['name' => 'Posyantek Prov Kaltim', 'logo' => 'posyantek.webp', 'activities' => ['Pengolahan Sampah Plastik Menjadi Produk', 'Penguatan Inovasi Teknologi Tepat Guna']],
            ['name' => 'Pusat Kolaborasi Desain Chip Indonesia (PKDCI) / Indonesia Chip Design Collaborative Center (ICDEC)', 'logo' => 'icdec.webp', 'activities' => []],

            ['name' => 'PT Pertamina Bina Medika IHC (Rumah Sakit Pertamina Panorama Balikpapan)', 'logo' => 'pertamedika.webp', 'activities' => []],
            ['name' => 'PT Jasindo', 'logo' => 'jasindo.webp', 'activities' => ['Tridharma PT', 'Pengembangan Sumber Daya Manusia Melalui Kegiatan Pengajaran dan Pembimbingan', 'Kegiatan Pembekalan Wisuda 2025']],
            ['name' => 'PT Javan Cipta Solusi', 'logo' => 'javan.webp', 'activities' => ['Magang Mahasiswa']],
            ['name' => 'Astra Honda', 'logo' => 'astra.webp', 'activities' => ['Pelaksanaan Astra Motor Campus Network']],
            ['name' => 'Terra Drone', 'logo' => 'terra-drone.webp', 'activities' => ['Pelatihan Remote Pilot']],
            ['name' => 'Inixindo Jogjakarta', 'logo' => 'inixindo.webp', 'activities' => ['Sertifikasi Kopetensi']],
        ];

        $copiedCount = 0;

        foreach ($partners as $partner) {
            $logoName = $partner['logo'];
            $fullSourcePath = $sourcePath . DIRECTORY_SEPARATOR . $logoName;

            if (File::exists($fullSourcePath)) {
                Storage::disk('public')->put('partners/' . $logoName, File::get($fullSourcePath));
                $copiedCount++;
            } else {
                $this->command->error("GAGAL: Gambar {$logoName} tidak ditemukan di path: {$fullSourcePath}");
            }

            Partner::create([
                'name' => $partner['name'],
                'logo' => 'partners/' . $logoName,
                'activities' => $partner['activities']
            ]);
        }

        if ($copiedCount > 0) {
            $this->command->info("Selesai! {$copiedCount} gambar berhasil disalin ke storage, dan 30 Data Kerjasama di-seed.");
        } else {
            $this->command->warn("Peringatan: Data di-seed, TAPI TIDAK ADA SATUPUN GAMBAR YANG DISALIN!");
        }
    }
}
