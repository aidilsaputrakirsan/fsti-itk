<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Models\CommunityService;
use App\Models\StudyProgram;

class CommunityServiceSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        CommunityService::truncate();
        Schema::enableForeignKeyConstraints();

        $jsonPath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'research' . DIRECTORY_SEPARATOR . 'sinta_data.json');

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
            if (isset($lecturer['services']) && is_array($lecturer['services'])) {

                $prodiName = $lecturer['prodi'] ?? 'Sistem Informasi';
                $prodi = StudyProgram::where('name', 'like', "%{$prodiName}%")->first();

                foreach ($lecturer['services'] as $service) {
                    if (!empty($service['title']) && !empty($service['year'])) {
                        CommunityService::create([
                            'study_program_id' => $prodi ? $prodi->id : null,
                            'nama_dosen'       => $lecturer['name'],
                            'judul'            => $service['title'],
                            'tahun'            => $service['year'],
                        ]);
                    }
                }
            }
        }

        $this->command->info('Data Pengabdian Masyarakat berhasil di-seed dari sinta_data.json!');
    }
}