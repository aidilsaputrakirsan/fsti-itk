<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        Partner::truncate();

        $imagePath = public_path('images/mitra');
        if (File::exists($imagePath)) {
            $files = File::files($imagePath);
            foreach ($files as $file) {
                if (preg_match('/^[0-9]+_/', $file->getFilename())) {
                    File::delete($file);
                }
            }
        }

        $partners = [
            ['name' => 'BPSDMP Kominfo Banjarmasin KOMDIGI', 'logo' => 'bpsdm.png', 'activities' => ['Sertifikasi VSGA', 'Program DEA (Digital Entrepreneurship Acedemy)', 'Pelatihan Diploy']],
            ['name' => 'Terra Drone', 'logo' => 'terra-drone.png', 'activities' => ['Pelatihan Remote Pilot']],
            ['name' => 'PT Jasindo', 'logo' => 'jasindo.png', 'activities' => ['Tridharma PT', 'Pengembangan Sumber Daya Manusia Melalui Kegiatan Pengajaran dan Pembimbingan', 'Kegiatan Pembekalan Wisuda 2025']],
            ['name' => 'SMK Cendikia Al-Izzah Balikpapan', 'logo' => 'smk-cendekia.png', 'activities' => ['Pengembangan Sumber Daya Manusia Melalui Kegiatan Pengajaran dan Pembimbingan']],
            ['name' => 'SMAN 7 Balikpapan', 'logo' => 'sma-7.png', 'activities' => ['Program Mengajar di Sekolah dan Pembimbingan Akademik']],
            ['name' => 'SMAN 9 Balikpapan', 'logo' => 'sma-9.png', 'activities' => ['Program Mengajar di Sekolah dan Pembimbingan Akademik SDM']],
            ['name' => 'Posyantek Prov Kaltim', 'logo' => 'posyantek.png', 'activities' => ['Pengolahan Sampah Plastik Menjadi Produk', 'Penguatan Inovasi Teknologi Tepat Guna']],
            ['name' => 'DKUMKMP Balikpapan', 'logo' => 'dkumkmp.png', 'activities' => ['Kemitraan Dalam Kegiatan Inovasi Sosial Mahasiswa']],
            ['name' => 'Universitas Brawijaya', 'logo' => 'universitas-brawijaya.png', 'activities' => ['Penyelenggaraan Pendidikan, Penelitian, dan Pengabdian Masyarakat', 'Mahasiswa Inbound Departemen Fisika', 'Mahasiswa Inbound Departemen Matematika']],
            ['name' => 'Brida Kaltim', 'logo' => 'brida-kaltim.png', 'activities' => ['Pelaksanaan Pendidikan, Penelitian, dan Pengabdian Masyarakat']],
            ['name' => 'FSAD ITS', 'logo' => 'fsad-its.png', 'activities' => ['Pelaksanaan Kegiatan Peningkatan Kapasitas Tata Kelola Fakultas', 'Pendidikan, Penelitian, dan Pengabdian Masyarakat']],
            ['name' => 'Universitas Kristen Maranatha', 'logo' => 'universitas-kristen.png', 'activities' => ['Pelaksanaan Tridharma PT']],
            ['name' => 'FHB Universitas Kristen Maranatha', 'logo' => 'universitas-kristen.png', 'activities' => ['Pelaksanaan Tridharma PT']],
            ['name' => 'FTRC Universitas Kristen Maranatha', 'logo' => 'universitas-kristen.png', 'activities' => ['Pelaksanaan Tridharma PT']],
            ['name' => 'Pusat Kolaborasi Desain Chip Indonesia (PKDCI) / Indonesia Chip Design Collaborative Center (ICDEC)', 'logo' => 'icdec.png', 'activities' => []],
            ['name' => 'PT Pertamina Bina Medika IHC (Rumah Sakit Pertamina Panorama Balikpapan)', 'logo' => 'pertamedika.png', 'activities' => []],
            ['name' => 'OIKN Bidang Transformasi Hijau dan Digital', 'logo' => 'oikn.png', 'activities' => []],
            ['name' => 'FT Univ Negeri Malang', 'logo' => 'universitas-malang.png', 'activities' => []],
            ['name' => 'FT Unesa', 'logo' => 'unesa.png', 'activities' => []],
            ['name' => 'Universitas Hasanuddin', 'logo' => 'universitas-hasanuddin.png', 'activities' => ['Pendidikan, Penelitian, dan Pengabdian Masyarakat']],
            ['name' => 'PT Javan Cipta Solusi', 'logo' => 'javan.png', 'activities' => ['Magang Mahasiswa']],
            ['name' => 'Departemen Matematika ITS', 'logo' => 'matematika-its.png', 'activities' => ['Pelatihan Peningkatan Pembelajaran Berbasis Artificial Intelligence di SMK Cendekia Al-Izzah Balikpapan']],
            ['name' => 'Fakultas Teknologi Elektro dan Informatika Cerdas ITS', 'logo' => 'fteic-its.png', 'activities' => ['Pelatihan Peningkatan Pembelajaran Berbasis Artificial Intelligence di SMK Cendekia Al-Izzah Balikpapan']],
            ['name' => 'Astra Honda', 'logo' => 'astra.png', 'activities' => ['Pelaksanaan Astra Motor Campus Network']],
            ['name' => 'UPN Veteran Jawa Timur', 'logo' => 'upn.png', 'activities' => ['Pelaksanaan Seminar Sains Data (SENADA) 2025']],
            ['name' => 'Inixindo Jogjakarta', 'logo' => 'inixindo.png', 'activities' => ['Sertifikasi Kopetensi']],
            ['name' => 'BPS Kota Balikpapan', 'logo' => 'bps.png', 'activities' => ['Kegiatan Workshop Satria Data 2025', 'Kuliah Tamu Hari Statistik Nasional', 'Kegiatan Expo Kerja Praktik']],
            ['name' => 'BPSDM Komdigi', 'logo' => 'bpsdm.png', 'activities' => ['Penyelenggaran Program Beasiswa Talenta Digital', 'Pelaksanaan Program Pendidikan dan Pengembangan SDM Bidang Komunikasi dan Digital']],
            ['name' => 'Chongqing University of Technology  (CQUT), China', 'logo' => 'cqut.png', 'activities' => []],
            ['name' => 'Krishna Institute of Engineering and Technology (KIET), India', 'logo' => 'kiet.png', 'activities' => []],
        ];

        foreach ($partners as $partner) {
            Partner::create([
                'name' => $partner['name'],
                'logo' => $partner['logo'],
                'activities' => $partner['activities']
            ]);
        }

        $this->command->info("Selesai! File sampah gambar dibersihkan, dan 30 Data Kerjasama orisinal berhasil di-seed.");
    }
}