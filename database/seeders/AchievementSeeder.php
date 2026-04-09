<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kosongkan tabel database
        Achievement::truncate();

        // 2. Siapkan folder Storage (Tujuan) dan Folder Assets (Sumber)
        $storagePrestasiPath = storage_path('app/public/prestasi');
        $assetPrestasiPath = database_path('seeders/assets/prestasi');

        // Buat folder di storage jika belum ada
        if (!File::exists($storagePrestasiPath)) {
            File::makeDirectory($storagePrestasiPath, 0755, true);
        }

        foreach (File::files($storagePrestasiPath) as $file) {
            File::delete($file);
        }

        $data = [
            [
                'student_name' => "Febriyan Adit Tama",
                'student_nim' => null,
                'study_program' => 'Bisnis Digital',
                'title' => '2nd Runner-Up Duta Pustaka Indonesia 2025',
                'category' => 'Non-Akademik',
                'level' => 'Nasional',
                'organizer' => 'Duta Pustaka Indonesia',
                'year' => 2025,
                'image_path' => 'prestasi/duta.png'
            ],
            [
                'student_name' => "Karina Ambar Wati",
                'student_nim' => null,
                'study_program' => 'Matematika',
                'title' => 'Juara 2 Kejuaraan Pencak Silat',
                'category' => 'Non-Akademik',
                'level' => 'Kota/Kabupaten',
                'organizer' => 'Kota Balikpapan',
                'year' => 2025,
                'image_path' => 'prestasi/silat.png'
            ],
            [
                'student_name' => "Tim Recraft",
                'student_nim' => null,
                'study_program' => 'Sistem Informasi',
                'title' => 'Juara 2 Lomba Teknologi Tepat Guna (TTG) Unggulan',
                'category' => 'Akademik',
                'level' => 'Kota/Kabupaten',
                'organizer' => 'Kecamatan Balikpapan Utara',
                'year' => 2025,
                'image_path' => 'prestasi/ttg-balikpapan-utara.png'
            ],
            [
                'student_name' => "Siti Aminatuzzuhriyah\nZidane Alfarizi\nRifki Anashirul",
                'student_nim' => "10221014\n10221034\n10221044",
                'study_program' => 'Sistem Informasi',
                'title' => 'Juara 1 Krenova Kategori Mahasiswa',
                'category' => 'Akademik',
                'level' => 'Kota/Kabupaten',
                'organizer' => 'Bappeda Litbang Kota Balikpapan',
                'year' => 2025,
                'image_path' => 'prestasi/krenova.png'
            ],
            [
                'student_name' => "Karina Ambar Wati",
                'student_nim' => null,
                'study_program' => 'Matematika',
                'title' => 'Juara 3 Kelas B Dewasa Putri Koni-Bayan Championship 2025',
                'category' => 'Non-Akademik',
                'level' => 'Provinsi',
                'organizer' => 'Koni Bayan',
                'year' => 2025,
                'image_path' => 'prestasi/koni-bayan.png'
            ],
            [
                'student_name' => "Tim Himawari",
                'student_nim' => null,
                'study_program' => 'Sistem Informasi',
                'title' => 'Juara Harapan 2 UI/UX Competition Technotainment',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'UKM ITC Universitas Trunojoyo Madura',
                'year' => 2025,
                'image_path' => 'prestasi/technotainment.png'
            ],
            [
                'student_name' => "Tim Debat Pemuda ITK",
                'student_nim' => null,
                'study_program' => null,
                'title' => 'Juara 2 Lomba Debat Pemuda',
                'category' => 'Non-Akademik',
                'level' => 'Kota/Kabupaten',
                'organizer' => 'Disporapar Kota Balikpapan',
                'year' => 2025,
                'image_path' => 'prestasi/debat.png'
            ],
            [
                'student_name' => "Tim ECO-MAHAR",
                'student_nim' => null,
                'study_program' => null,
                'title' => 'Pemenang Pendanaan Kategori Sociopreneurship',
                'category' => 'Non-Akademik',
                'level' => 'Nasional',
                'organizer' => 'Pertamina Foundation',
                'year' => 2025,
                'image_path' => 'prestasi/eco-mahar.png'
            ],
            [
                'student_name' => "Gibran Ivantry Dilma\nMohammad Qudus\nZahra Elycia Armans",
                'student_nim' => "10221006\n10221048\n10221076",
                'study_program' => 'Sistem Informasi',
                'title' => 'Juara 3 Lomba UI/UX Design IT Fest',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'Universitas Brawijaya Malang',
                'year' => 2025,
                'image_path' => 'prestasi/uiux-itfest.png'
            ],
            [
                'student_name' => "Tim Sugar Monster",
                'student_nim' => null,
                'study_program' => 'Informatika',
                'title' => 'Juara 3 AI Hackathon Technoart 2025',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'Universitas Bunda Mulia',
                'year' => 2025,
                'image_path' => 'prestasi/technoart.png'
            ],
            [
                'student_name' => "Tim Medisense ITK",
                'student_nim' => null,
                'study_program' => "Teknik Elektro\nRekayasa Keselamatan",
                'title' => 'Juara 2 Kategori Mahasiswa Techno Competition',
                'category' => 'Akademik',
                'level' => 'Universitas',
                'organizer' => 'Dies Natalis Institut Teknologi Kalimantan',
                'year' => 2025,
                'image_path' => 'prestasi/techno-dies.png'
            ],
            [
                'student_name' => "Tim Blessplast",
                'student_nim' => null,
                'study_program' => 'Teknik Material Metalurgi',
                'title' => 'Pemenang Pendanaan PFMuda Kategori Ideation',
                'category' => 'Non-Akademik',
                'level' => 'Nasional',
                'organizer' => 'Pertamina Foundation',
                'year' => 2025,
                'image_path' => 'prestasi/pfmuda.png'
            ],
            [
                'student_name' => "Tim KidUp",
                'student_nim' => null,
                'study_program' => 'Sistem Informasi',
                'title' => 'Best Essay Compassionate Gamification Challenge 2025',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'Compassionate Gamification Challenge 2025 (CGC 2025)',
                'year' => 2025,
                'image_path' => 'prestasi/gamification.png'
            ],
            [
                'student_name' => "Danang Windaryoko\nKeyshal Naufal Juliantila\nRafi Muhammad Akbar",
                'student_nim' => "04211016\n04231045\n04231074",
                'study_program' => 'Teknik Elektro',
                'title' => 'Juara 1 Ship Prototype Electric Competition Etam Ship Competition 2025',
                'category' => 'Akademik',
                'level' => 'Universitas',
                'organizer' => 'Teknik Perkapalan ITK',
                'year' => 2025,
                'image_path' => 'prestasi/etam-ship.png'
            ],
            [
                'student_name' => "Tim KidUp",
                'student_nim' => null,
                'study_program' => 'Sistem Informasi',
                'title' => 'Juara 1 Business Model Competition',
                'category' => 'Non-Akademik',
                'level' => 'Provinsi',
                'organizer' => 'Bank Indonesia Kantor Perwakilan Balikpapan',
                'year' => 2025,
                'image_path' => 'prestasi/mahligai.png'
            ],
            [
                'student_name' => "Dwi Arnesta Saputra",
                'student_nim' => null,
                'study_program' => 'Teknik Elektro',
                'title' => 'Gold Medal National Writing Competition 2025',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'Inteleksa & HMDE Universitas Andalas',
                'year' => 2025,
                'image_path' => 'prestasi/inteleksa.png'
            ],
            [
                'student_name' => "Michell Patricia",
                'student_nim' => "20221073",
                'study_program' => 'Bisnis Digital',
                'title' => 'Juara 2 Taekwondo Mulawarman Championship 2025',
                'category' => 'Non-Akademik',
                'level' => 'Provinsi',
                'organizer' => 'Universitas Mulawarman',
                'year' => 2025,
                'image_path' => 'prestasi/taekwondo.png'
            ],
            [
                'student_name' => "Muhammad Hafidz Ardan\nAmelia Ramadhani\nFebriyanti Nur",
                'student_nim' => null,
                'study_program' => 'Bisnis Digital',
                'title' => 'Juara 2 UI/UX ACTION 2025',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'HIMASADA Universitas Negeri Surabaya',
                'year' => 2025,
                'image_path' => 'prestasi/himasada.png'
            ],
            [
                'student_name' => "Nadya Azwarelda Haryanto\nAhmad Tijani Noor\nAura Nabil Arsy\nMila Fitria Sari",
                'student_nim' => null,
                'study_program' => 'Ilmu Aktuaria',
                'title' => 'Juara Harapan 2 Lomba Pemodelan Aktuaria BPJS Kesehatan 2025',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'BPJS Kesehatan Pusat',
                'year' => 2025,
                'image_path' => 'prestasi/aktuaria.png'
            ],
            [
                'student_name' => "Tim KidUp",
                'student_nim' => null,
                'study_program' => 'Sistem Informasi',
                'title' => 'Juara 1 UI/UX Competition FTI Fest UKDW 2025',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'organizer' => 'Universitas Kristen Duta Wacana',
                'year' => 2025,
                'image_path' => 'prestasi/uyuh-handak.png'
            ]
        ];

        $copiedCount = 0;

        // 3. Eksekusi Input ke Database & Proses Copy File
        foreach ($data as $item) {

            // Logika untuk menyalin file gambar
            if (!empty($item['image_path'])) {
                $imageName = basename($item['image_path']);

                $sourceFile = $assetPrestasiPath . '/' . $imageName;
                $destinationFile = $storagePrestasiPath . '/' . $imageName;

                if (File::exists($sourceFile)) {
                    File::copy($sourceFile, $destinationFile);
                    $copiedCount++;
                } else {
                    $this->command->warn("Peringatan: File Gambar '{$imageName}' tidak ditemukan di assets/prestasi!");
                }
            }

            Achievement::create($item);
        }

        $this->command->info("Selesai! " . count($data) . " Data Prestasi berhasil di-seed. Total {$copiedCount} gambar disalin ke Storage.");
    }
}
