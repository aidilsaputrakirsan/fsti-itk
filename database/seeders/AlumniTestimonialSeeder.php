<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlumniTestimonial;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AlumniTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        AlumniTestimonial::truncate();
        Storage::disk('public')->deleteDirectory('alumni_testimonials');
        Storage::disk('public')->makeDirectory('alumni_testimonials');

        $testimonials = [
            [
                'name' => 'Rachman Setiawan Amir',
                'job' => 'Pegawai Negeri Sipil Badan Kepegawaian Negara',
                'study_program' => 'Sistem Informasi',
                'graduation_year' => '2013',
                'filename' => 'rachman-setiawan.webp',
                'message' => 'Sebagai alumni FSTI ITK, saya bangga pernah menjadi bagian dari angkatan pertama yang menyaksikan perjalanan awal kampus ini, dari kondisi yang masih terbatas hingga berkembang dengan fasilitas yang semakin memadai. Proses tersebut memberikan banyak pelajaran tentang perjuangan, kebersamaan, semangat untuk terus berkembang, serta menumbuhkan rasa memiliki yang kuat serta membentuk karakter saya hingga saat ini. Saya berharap FSTI terus menjaga semangat tersebut, meningkatkan kualitas pembelajaran dan fasilitas, serta mencetak lulusan yang kompeten, inovatif, dan berintegritas.',
                'is_active' => true,
            ],
            [
                'name' => 'Rosa Eliviani',
                'job' => 'Dosen Program Studi Sistem Informasi ITK',
                'study_program' => 'Sistem Informasi',
                'graduation_year' => '2016',
                'filename' => 'rosa-eliviani.webp',
                'message' => 'Walaupun saat berkuliah dulu fasilitas serba terbatas, namun saya merasa setelah lulus baru merasakan manfaatnya. Apa yang saya pelajari sangat berguna untuk mencari pekerjaan, hingga akhirnya saya memutuskan untuk melanjutkan perkuliahan. Saya pun merasa tidak kalah jauh dengan teman-teman lainnya; artinya, semua yang saya pelajari sungguh menunjang perkuliahan magister saya. Saya berharap, dengan adanya fakultas di ITK, maka kemajuan ITK juga terus berkembang, khususnya untuk FSTI yang menaungi prodi saya, Sistem Informasi.',
                'is_active' => true,
            ],
            [
                'name' => 'Samuel Govery',
                'job' => 'Tenaga Kependidikan ITK',
                'study_program' => 'Sistem Informasi',
                'graduation_year' => '2017',
                'filename' => 'samuel-govery.webp',
                'message' => "Sebagai alumni FSTI Institut Teknologi Kalimantan, saya bangga pernah menjadi bagian dari lingkungan yang membentuk kemampuan akademik sekaligus karakter. Banyak pengalaman berharga yang menjadi bekal hingga saat ini.\n\nPesan saya, semoga FSTI terus berkembang, inovatif, dan mampu mencetak lulusan yang kompeten serta berintegritas. Untuk mahasiswa, manfaatkan setiap kesempatan yang ada sebaik mungkin.",
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            $sourcePath = database_path('seeders/assets/alumni/' . $data['filename']);
            $destPath = 'alumni_testimonials/' . $data['filename'];

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($destPath, File::get($sourcePath));
            }

            AlumniTestimonial::create([
                'name' => $data['name'],
                'job' => $data['job'],
                'study_program' => $data['study_program'],
                'graduation_year' => $data['graduation_year'],
                'photo' => $destPath,
                'message' => $data['message'],
                'is_active' => $data['is_active'],
            ]);
        }
    }
}
