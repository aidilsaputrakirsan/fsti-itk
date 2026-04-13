<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        Achievement::truncate();

        $sourcePath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'achievements');

        if (!Storage::disk('public')->exists('achievements')) {
            Storage::disk('public')->makeDirectory('achievements');
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
                'image_path' => 'achievements/duta.png'
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
                'image_path' => 'achievements/silat.png'
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
                'image_path' => 'achievements/ttg-balikpapan-utara.png'
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
                'image_path' => 'achievements/krenova.png'
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
                'image_path' => 'achievements/koni-bayan.png'
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
                'image_path' => 'achievements/technotainment.png'
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
                'image_path' => 'achievements/debat.png'
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
                'image_path' => 'achievements/eco-mahar.png'
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
                'image_path' => 'achievements/uiux-itfest.png'
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
                'image_path' => 'achievements/technoart.png'
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
                'image_path' => 'achievements/techno-dies.png'
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
                'image_path' => 'achievements/pfmuda.png'
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
                'image_path' => 'achievements/gamification.png'
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
                'image_path' => 'achievements/etam-ship.png'
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
                'image_path' => 'achievements/mahligai.png'
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
                'image_path' => 'achievements/inteleksa.png'
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
                'image_path' => 'achievements/taekwondo.png'
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
                'image_path' => 'achievements/himasada.png'
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
                'image_path' => 'achievements/aktuaria.png'
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
                'image_path' => 'achievements/uyuh-handak.png'
            ]
        ];

        $copiedCount = 0;

        foreach ($data as $item) {
            if (!empty($item['image_path'])) {
                $imageName = basename($item['image_path']);
                $fullSourcePath = $sourcePath . DIRECTORY_SEPARATOR . $imageName;

                if (File::exists($fullSourcePath)) {
                    Storage::disk('public')->put('achievements/' . $imageName, File::get($fullSourcePath));
                    $copiedCount++;
                } else {
                    $this->command->error("GAGAL: Gambar {$imageName} tidak ditemukan di path: {$fullSourcePath}");
                }
            }

            Achievement::create($item);
        }

        $this->command->info("Selesai! " . count($data) . " Data Prestasi di-seed. Total {$copiedCount} gambar disalin ke Storage.");
    }
}
