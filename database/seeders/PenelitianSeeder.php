<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Penelitian;
use App\Models\StudyProgram;

class PenelitianSeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('seeders/data/sinta_data.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("File tidak ditemukan di: {$jsonPath}");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        if (!isset($data['lecturers'])) {
            $this->command->error("Format JSON tidak valid (tidak ada array 'lecturers').");
            return;
        }

        foreach ($data['lecturers'] as $lecturer) {
            if (isset($lecturer['research']) && is_array($lecturer['research'])) {

                $prodiName = $lecturer['prodi'] ?? 'Sistem Informasi';
                $prodi = StudyProgram::where('name', 'like', "%{$prodiName}%")->first();

                foreach ($lecturer['research'] as $research) {
                    if (!empty($research['title']) && !empty($research['year'])) {

                        Penelitian::create([
                            'study_program_id' => $prodi ? $prodi->id : null,
                            'nama_dosen'       => $lecturer['name'],
                            'judul'            => $research['title'],
                            'tahun'            => $research['year'],
                        ]);
                    }
                }
            }
        }

        $this->command->info('Data Penelitian berhasil di-seed dari sinta_data.json!');
    }
}
