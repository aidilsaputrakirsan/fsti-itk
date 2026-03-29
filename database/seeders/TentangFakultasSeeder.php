<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticPage;

class TentangFakultasSeeder extends Seeder
{
    public function run(): void
    {
        StaticPage::updateOrCreate(
            ['key' => 'tentang_fakultas'],
            [
                'title' => 'Tentang Fakultas',
                'content' => [
                    'statistik' => [
                        'deskripsi' => 'Fakultas Sains dan Teknologi Informasi - Institut Teknologi Kalimantan',
                        'data' => [
                            ['angka' => '2260', 'label' => 'Mahasiswa'], ['angka' => '2', 'label' => 'Jurusan'],
                            ['angka' => '8', 'label' => 'Prodi S1'], ['angka' => '1', 'label' => 'Prodi S2'],
                            ['angka' => '5', 'label' => 'Laboratorium'], ['angka' => '1404', 'label' => 'Alumni'],
                            ['angka' => '107', 'label' => 'Dosen'], ['angka' => '8', 'label' => 'Tendik'],
                        ]
                    ],
                    'tugas_fungsi' => [
                        'tugas' => 'Fakultas mempunyai tugas menyelenggarakan dan mengelola pendidikan akademik, vokasi, dan/atau profesi dalam 1 (satu) atau beberapa pohon/kelompok ilmu pengetahuan dan/atau teknologi.',
                        'fungsi' => [
                            ['judul' => 'Pelaksanaan dan Pengembangan Pendidikan', 'deskripsi' => 'Pelaksanaan dan pengembangan pendidikan di lingkungan fakultas'],
                            ['judul' => 'Pelaksanaan Penelitian', 'deskripsi' => 'Pelaksanaan penelitian untuk pengembangan ilmu pengetahuan dan/atau teknologi di lingkungan fakultas'],
                            ['judul' => 'Pelaksanaan Pengabdian kepada Masyarakat', 'deskripsi' => 'Pelaksanaan pengabdian kepada masyarakat sesuai dengan bidang keilmuan di lingkungan fakultas'],
                            ['judul' => 'Pembinaan Sivitas Akademika', 'deskripsi' => 'Pembinaan Sivitas Akademika dan Tenaga Kependidikan di lingkungan fakultas'],
                            ['judul' => 'Pelaksanaan Urusan Administrasi', 'deskripsi' => 'Pelaksanaan urusan administrasi fakultas'],
                        ]
                    ],
                    'visi_misi' => [
                        'visi' => 'Pada tahun 2029, Fakultas Sains dan Teknologi Informasi (FSTI) ITK akan menjadi pusat keunggulan akademik dan inovasi, menghasilkan lulusan yang kompeten, adaptif, berdaya saing global, dan karya-karya dalam bidang sains dan teknologi informasi yang berdampak bagi kemajuan Kalimantan dan Indonesia.',
                        'misi_tagline' => 'Misi: PRESTASI',
                        'misi' => [
                            ['huruf' => 'P', 'teks' => 'Pendidikan Berkualitas'], ['huruf' => 'R', 'teks' => 'Riset dan Inovasi Terdepan'],
                            ['huruf' => 'E', 'teks' => 'Ekosistem Kolaboratif'], ['huruf' => 'S', 'teks' => 'Sinergi'],
                            ['huruf' => 'T', 'teks' => 'Tata Kelola Optimal'], ['huruf' => 'A', 'teks' => 'Aktivasi Potensi Civitas'],
                            ['huruf' => 'S', 'teks' => 'Sistem Layanan Prima'], ['huruf' => 'I', 'teks' => 'Internasionalisasi'],
                        ]
                    ]
                ]
            ]
        );
    }
}