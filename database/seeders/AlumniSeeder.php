<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/assets/alumni/data_alumni.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("File data_alumni.csv tidak ditemukan di database/seeders/assets/alumni/");
            return;
        }

        $lines = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (count($lines) < 2) {
            $this->command->error("File CSV kosong atau hanya berisi header.");
            return;
        }

        $headerLine = array_shift($lines);
        $delimiter = strpos($headerLine, ';') !== false ? ';' : ',';

        $this->command->info("Pemisah CSV terdeteksi: " . ($delimiter === ';' ? 'Titik Koma (;)' : 'Koma (,)'));

        $allowedProdis = [
            'matematika',
            'ilmu aktuaria',
            'statistika',
            'fisika',
            'informatika',
            'sistem informasi',
            'bisnis digital',
            'teknik elektro'
        ];

        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($lines as $index => $line) {
            $row = str_getcsv($line, $delimiter);

            $prodiRaw = trim($row[0] ?? '');
            $nim = trim($row[1] ?? '');
            $nama = trim($row[2] ?? '');
            $keterangan = trim($row[3] ?? '');

            $prodiClean = strtolower($prodiRaw);

            if (empty($prodiClean) || !in_array($prodiClean, $allowedProdis)) {
                continue;
            }

            if (strlen($nim) === 7) {
                $nim = '0' . $nim;
            }

            $graduationYear = null;
            if (preg_match('/(20[1-2][0-9])/', $keterangan, $matches)) {
                $graduationYear = $matches[1];
            } else {
                $skippedCount++;
                continue;
            }

            Alumni::updateOrCreate(
                ['nim' => $nim],
                [
                    'name' => $nama,
                    'study_program' => ucwords($prodiClean),
                    'graduation_year' => $graduationYear,
                ]
            );

            $insertedCount++;
        }

        $this->command->info("Selesai! {$insertedCount} data Alumni FSTI berhasil dimasukkan.");
        if ($skippedCount > 0) {
            $this->command->warn("Catatan: Ada {$skippedCount} data yang dilewati karena belum memiliki tahun kelulusan.");
        }
    }
}
