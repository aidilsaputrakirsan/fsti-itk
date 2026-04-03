<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use Illuminate\Database\Seeder;

class BeasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $beasiswas = [
            [
                'title' => 'Beasiswa Bank Indonesia',
                'provider' => 'Bank Indonesia',
                'description' => 'Beasiswa Bank Indonesia untuk seluruh Perguruan Tinggi di Indonesia. Penerima beasiswa ini akan diberikan bantuan berupa dana Rp. 1 juta/bulan selama 1 tahun, mendapatkan pelatihan untuk meningkatkan kompetensi dan mendapat kesempatan untuk mengembangkan karakter dalam sebuah komunitas disebut GENBI.',
            ],
            [
                'title' => 'Beasiswa Peningkatan Prestasi Akademik (PPA)',
                'provider' => 'Pemerintah RI',
                'description' => 'Beasiswa ini diperuntukkan bagi seluruh mahasiswa aktif yang telah menempuh minimal 1 tahun perkuliahan dengan IPK memuaskan. Penerima beasiswa ini akan memperoleh dana sebesar Rp. 400 ribu/bulan selama 1 tahun.',
            ],
            [
                'title' => 'Beasiswa Pertamina Hulu Mahakam',
                'provider' => 'Pertamina Hulu Mahakam (PHM)',
                'description' => 'Beasiswa ini diperuntukkan bagi mahasiswa yang berasal dari wilayah sekitar PHM pada 5 kecamatan, yaitu Kecamatan Samboja, Kecamatan Muara Jawa, Kecamatan Anggana, Kecamatan Muara Badak, dan Kecamatan Sanga-Sanga.',
            ],
            [
                'title' => 'Pertamina Sobat Bumi',
                'provider' => 'Pertamina Foundation',
                'description' => 'Beasiswa Pertamina Sobat Bumi diberikan oleh Pertamina Foundation untuk seluruh mahasiswa berprestasi dalam bidang akademik, mempunyai kepedulian terhadap kelestarian lingkungan dan berusaha berkomitmen untuk berkontribusi terhadap hidup ramah lingkungan. Beasiswa ini diperuntukkan untuk mahasiswa aktif minimal semester 3 dan akan dibuka setiap tahunnya.',
            ],
            [
                'title' => 'Beasiswa KPC',
                'provider' => 'Kaltim Prima Coal (KPC)',
                'description' => 'Beasiswa ini diperuntukkan bagi mahasiswa yang berasal dari wilayah Kutai Timur.',
            ],
            [
                'title' => 'Beasiswa Gratispol',
                'provider' => 'Pemerintah Provinsi Kalimantan Timur',
                'description' => 'Program bantuan pendidikan gratis yang diselenggarakan oleh Pemerintah Provinsi Kalimantan Timur untuk meningkatkan sumber daya manusia Kaltim, mencakup biaya pendidikan penuh hingga lulus untuk jenjang D3 hingga S3, baik di dalam maupun di luar Kaltim, bahkan luar negeri. Program ini bertujuan untuk memberikan kesempatan belajar tinggi kepada warga Kaltim, meskipun terdapat ketentuan besaran subsidi yang berbeda untuk tiap jenjang dan jurusan.',
            ],
            [
                'title' => 'KIP Kuliah',
                'provider' => 'Kementerian Pendidikan dan Kebudayaan',
                'description' => 'KIP Kuliah adalah beasiswa yang diberikan oleh Kementerian Pendidikan dan Kebudayaan (Kemendikbud) bagi "calon" mahasiswa baru berprestasi dan kurang mampu. Penerima beasiswa ini akan mendapat bantuan pembiayaan UKT sebesar Rp. 2.400.000,- dan uang biaya hidup sebesar Rp.700.000/bulan langsung dikirim ke rekening mahasiswa.',
            ],
            [
                'title' => 'ADik',
                'provider' => 'Kementerian Pendidikan dan Kebudayaan',
                'description' => 'Program pemberian bantuan pembiayaan di pendidikan tinggi khusus untuk siswa dan siswi dari Papua, Papua Barat, 3 T, serta anak-anak TKI. Selain itu, program ini juga ditujukan untuk siswa dan siswi penyandang disabilitas.',
            ],
            [
                'title' => 'Beasiswa Inisiatif Zakat Indonesia (IZI)',
                'provider' => 'Inisiatif Zakat Indonesia',
                'description' => 'Beasiswa IZI diberikan oleh lembaga Inisiatif Zakat Indonesia untuk mahasiswa laki-laki muslim dan telah menempuh minimal semester 3. Bagi mahasiswa yang berkomitmen menjadi penghafal Al-Qur’an dan telah memiliki hafalan minimal 1 juz dapat mengikuti program ini.',
            ],
        ];

        foreach ($beasiswas as $beasiswa) {
            Beasiswa::create($beasiswa);
        }
    }
}