<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Achievement;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition(): array
    {
        // --- Logika untuk Foto Mahasiswa ---
        $photoDirectory = 'achievement/photos';

        // Pastikan direktori ada
        if (!Storage::disk('public')->exists($photoDirectory)) {
            Storage::disk('public')->makeDirectory($photoDirectory);
        }

        $photoFiles = Storage::disk('public')->files($photoDirectory);

        // Jika folder foto kosong, gunakan placeholder path
        if (empty($photoFiles)) {
            $selectedPhotoPath = 'achievement/photos/placeholder-' . $this->faker->uuid() . '.jpg';
        } else {
            $selectedPhotoPath = $this->faker->randomElement($photoFiles);
        }

        // --- Logika untuk Bukti (Opsional) ---
        $proofDirectory = 'achievement/proofs';

        // Pastikan direktori ada
        if (!Storage::disk('public')->exists($proofDirectory)) {
            Storage::disk('public')->makeDirectory($proofDirectory);
        }

        $proofFiles = Storage::disk('public')->files($proofDirectory);

        $selectedProofPath = null; // Defaultnya null (opsional)
        // Jika ada file bukti dan hasil acak true (kemungkinan 50%), baru kita isi path-nya
        if (!empty($proofFiles) && $this->faker->boolean(50)) {
            $selectedProofPath = $this->faker->randomElement($proofFiles);
        }

        // --- BAGIAN LAMA ANDA (TIDAK DIUBAH) ---
        $studyPrograms = [
            'Teknik Elektro',
            'Sistem Informasi',
            'Informatika',
            'Bisnis Digital',
            'Magister Manajemen Teknologi',
            'Fisika',
            'Matematika',
            'Statistika',
            'Ilmu Aktuaria'
        ];

        $achievementNames = [
            'Juara 1 Lomba Competitive Programming Gemastik',
            'Medali Emas Olimpiade Sains Nasional',
            'Best Paper di Konferensi Internasional IEEE',
            'Juara 2 Kompetisi Robotika Nasional',
            'Finalis Pekan Ilmiah Mahasiswa Nasional (PIMNAS)'
        ];

        $levels = ['Internasional', 'Nasional', 'Provinsi', 'Kota/Kabupaten', 'Universitas'];

        $organizers = [
            'Kemendikbudristek',
            'IEEE Organization',
            'Institut Teknologi Bandung',
            'Telkom University',
            'Pemerintah Kota Balikpapan'
        ];

        // --- PENYESUAIAN PADA RETURN ---
        return [
            'student_name'      => $this->faker->name(),
            'student_nim'       => '1101' . $this->faker->unique()->numerify('21####'),
            'study_program'     => $this->faker->randomElement($studyPrograms),
            'achievement_name'  => $this->faker->randomElement($achievementNames),
            'category'          => $this->faker->randomElement(['Akademik', 'Non-Akademik']),
            'level'             => $this->faker->randomElement($levels),
            'organizer'         => $this->faker->randomElement($organizers),
            'year'              => $this->faker->numberBetween(2021, 2025),

            // Kolom photo_path baru, mengambil dari logika di atas (wajib)
            'photo_path'        => $selectedPhotoPath,

            // Kolom proof_path disesuaikan, mengambil dari logika di atas (opsional)
            'proof_path'        => $selectedProofPath,
        ];
    }
}
