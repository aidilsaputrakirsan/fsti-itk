<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KegiatanMahasiswa;

class KegiatanMahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $kegiatan = [
            // --- FEBRUARI 2025 ---
            ['title' => 'The 2025, IEEE Indonesia Section Member Gathering', 'start_date' => '2025-02-01', 'end_date' => null, 'organizer' => 'IEEE ITK'],
            ['title' => 'Kegiatan Open House Program Studi Fisika Tahun 2025', 'start_date' => '2025-02-08', 'end_date' => '2025-02-09', 'organizer' => 'HIMA Fisika'],
            ['title' => 'Kegiatan STARK " Statistical Enterpreneurship Knowledge"', 'start_date' => '2025-02-16', 'end_date' => null, 'organizer' => 'HIMA Statistika'],

            // --- MARET 2025 ---
            ['title' => 'Kegiatan Big data Workshop Program Studi Ilmu Aktuaria', 'start_date' => '2025-03-15', 'end_date' => null, 'organizer' => 'HIMA Aktuaria'],

            // --- APRIL 2025 ---
            ['title' => 'Kuliah Tamu Statistika dan Expo KP Tahun 2025', 'start_date' => '2025-04-21', 'end_date' => null, 'organizer' => 'HIMA Statistika'],

            // --- MEI 2025 ---
            ['title' => 'Opening Ceremony Inspace Tahun 2025', 'start_date' => '2025-05-17', 'end_date' => null, 'organizer' => 'HIMA Sistem Informasi'],
            ['title' => 'Geophysics Competition ITK Tahun 2025', 'start_date' => '2025-05-17', 'end_date' => '2025-05-25', 'organizer' => 'HIMA Fisika'],
            ['title' => 'Expo Kerja Praktik Mahasiswa Matematika ITK', 'start_date' => '2025-05-23', 'end_date' => null, 'organizer' => 'HIMA Matematika'],
            ['title' => 'Cahaya Syntec 1.0 Social Movement Program Studi Ilmu Aktuaria', 'start_date' => '2025-05-24', 'end_date' => null, 'organizer' => 'HIMA Aktuaria'],
            ['title' => 'Kegiatan Studi Banding Himpunan Mahasiswa Informatika (HMIF) ITK dan AI Unmul', 'start_date' => '2025-05-24', 'end_date' => null, 'organizer' => 'HMIF ITK'],
            ['title' => 'Seminar Tasyakuran Syntec 1.0 Program Studi Ilmu Aktuaria', 'start_date' => '2025-05-31', 'end_date' => null, 'organizer' => 'HIMA Aktuaria'],

            // --- JUNI 2025 ---
            ['title' => 'Actuarial Science Competition Tahun 2025', 'start_date' => '2025-06-01', 'end_date' => null, 'organizer' => 'HIMA Aktuaria'],
            ['title' => 'X-Cite 2025, Innovate Teknik Ellektro Tahun 2025', 'start_date' => '2025-06-04', 'end_date' => null, 'organizer' => 'HIMA Teknik Elektro'],
            ['title' => 'Kegiatan Partisipasi dan Prestasi dalam Mathematical Analysis and Geometry Day (MaG-D) XVI Tahun 2025', 'start_date' => '2025-06-14', 'end_date' => null, 'organizer' => 'HIMA Matematika'],
            ['title' => 'Industry Sight (Insight) Program Studi Sistem Informasi Tahun 2025', 'start_date' => '2025-06-21', 'end_date' => null, 'organizer' => 'HIMA Sistem Informasi'],
            ['title' => 'Infinite Talkshow and Closing Ceremony', 'start_date' => '2025-06-22', 'end_date' => null, 'organizer' => 'HIMA Sistem Informasi'],
            ['title' => 'Econiq Chapter 2 "Future Unlimited : Embracing Growth, Expanding Possibilities"', 'start_date' => '2025-06-26', 'end_date' => '2025-06-30', 'organizer' => 'HIMA Bisnis Digital'],
            ['title' => 'Workshop UI/UX Econiq CH.2 Bisnis Digital', 'start_date' => '2025-06-26', 'end_date' => '2025-06-27', 'organizer' => 'HIMA Bisnis Digital'],
            ['title' => 'Inspace Competitions Tahun 2025', 'start_date' => '2025-06-27', 'end_date' => null, 'organizer' => 'HIMA Sistem Informasi'],
            ['title' => 'Talkshow Exsit Tahun 2025 Insight : Integrating Statistics for Public, Technology and Real Empowerment Program Studi Statistika', 'start_date' => '2025-06-28', 'end_date' => null, 'organizer' => 'HIMA Statistika'],

            // --- JULI 2025 ---
            ['title' => 'Kegiatan Security and Cloud Essentials for Education and Tech Teams', 'start_date' => '2025-07-24', 'end_date' => null, 'organizer' => 'HMIF ITK'],
            ['title' => 'Studi Banding (Benchmarking) dengan Program Studi S1 Teknologi Informasi ITS Surabaya', 'start_date' => '2025-07-25', 'end_date' => null, 'organizer' => 'HMIF ITK'],

            // --- AGUSTUS 2025 ---
            ['title' => 'Kegiatan Workshop Keprofesian "From Design to Development-Bangun Aplikasi Kolaboratif ala Tim Profesional"', 'start_date' => '2025-08-30', 'end_date' => '2025-08-31', 'organizer' => 'HMIF ITK'],

            // --- SEPTEMBER 2025 ---
            ['title' => 'Expo Dies Natalis ke 11 Fakultas Sains dan Teknologi Informasi', 'start_date' => '2025-09-03', 'end_date' => '2025-09-06', 'organizer' => 'KM ITK'],
            ['title' => 'Kunjungan Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA) Universitas Mulawarman', 'start_date' => '2025-09-25', 'end_date' => null, 'organizer' => 'HIMA Matematika'],
            ['title' => 'Kegiatan Elevate (Electrical Engineering Festival Technology) Program Studi Teknik Elektro Tahun 2025', 'start_date' => '2025-09-25', 'end_date' => null, 'organizer' => 'HIMA Teknik Elektro'],
            ['title' => 'Kegiatan Talkshow Program Studi Sistem Informasi', 'start_date' => '2025-09-27', 'end_date' => null, 'organizer' => 'HIMA Sistem Informasi'],
            ['title' => 'Talkshow Inspace 2025', 'start_date' => '2025-09-28', 'end_date' => null, 'organizer' => 'HIMA Sistem Informasi'],

            // --- OKTOBER 2025 ---
            ['title' => 'Octogram Bisnis Digital', 'start_date' => '2025-10-11', 'end_date' => null, 'organizer' => 'HIMA Bisnis Digital'],
            ['title' => 'Kegiatan Syukuran Wisuda Program Studi Statistika Tahun 2025', 'start_date' => '2025-10-12', 'end_date' => null, 'organizer' => 'HIMA Statistika'],
            ['title' => 'Kegiatan Expo JTEIB', 'start_date' => '2025-10-27', 'end_date' => null, 'organizer' => 'HIMA Bisnis Digital'],
            ['title' => 'Kegiatan Kuliah Umum Bisnis Digital', 'start_date' => '2025-10-29', 'end_date' => '2025-10-30', 'organizer' => 'HIMA Bisnis Digital'],
            ['title' => 'Kegiatan Seminar Ilmiah Program Studi Matematika', 'start_date' => '2025-10-31', 'end_date' => null, 'organizer' => 'HIMA Matematika'],

            // --- NOVEMBER 2025 ---
            ['title' => 'Kegiatan Elevate (Electrical Engineering Festival Technology) Program Studi Teknik Elektro', 'start_date' => '2025-11-03', 'end_date' => '2025-11-05', 'organizer' => 'HIMA Teknik Elektro'],
            ['title' => 'Kegiatan HMSI', 'start_date' => '2025-11-24', 'end_date' => '2025-11-29', 'organizer' => 'HIMA Sistem Informasi'],
            ['title' => 'Expo Capstone Project IF', 'start_date' => '2025-11-27', 'end_date' => '2025-11-29', 'organizer' => 'HMIF ITK'],
        ];

        KegiatanMahasiswa::truncate();

        foreach ($kegiatan as $item) {
            KegiatanMahasiswa::create($item);
        }
    }
}
