<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FacultyProfile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FacultyProfileSeeder extends Seeder
{
    public function run(): void
    {
        if (!Storage::disk('public')->exists('profiles')) {
            Storage::disk('public')->makeDirectory('profiles');
        }

        $imageName = 'bagan-organisasi.webp';
        $assetPath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'profiles' . DIRECTORY_SEPARATOR . $imageName);
        $finalImagePath = null;

        if (File::exists($assetPath)) {
            if (Storage::disk('public')->exists('profiles/' . $imageName)) {
                Storage::disk('public')->delete('profiles/' . $imageName);
            }
            Storage::disk('public')->put('profiles/' . $imageName, File::get($assetPath));

            $finalImagePath = 'profiles/' . $imageName;
        } else {
            $this->command->warn("Peringatan: File Gambar '{$imageName}' tidak ditemukan di folder assets/profiles!");
        }

        $contentData = [
            'statistik' => [
                'deskripsi' => 'FSTI terus berkembang sebagai pusat pendidikan dan inovasi di bidang sains dan teknologi, dengan berbagai jurusan, program studi, dan civitas akademika yang mendukung perjalanan belajar, kreativitas, dan prestasi mahasiswa kami.',
                'data' => [
                    ['angka' => '2260', 'label' => 'Mahasiswa'],
                    ['angka' => '2', 'label' => 'Jurusan'],
                    ['angka' => '8', 'label' => 'Prodi S1'],
                    ['angka' => '1', 'label' => 'Prodi S2'],
                    ['angka' => '5', 'label' => 'Laboratorium'],
                    ['angka' => '1404', 'label' => 'Alumni'],
                    ['angka' => '107', 'label' => 'Dosen'],
                    ['angka' => '8', 'label' => 'Tendik'],
                ]
            ],
            'tugas_fungsi' => [
                'tugas' => 'Fakultas mempunyai tugas menyelenggarakan dan mengelola pendidikan akademik, vokasi, dan/atau profesi dalam 1 (satu) atau beberapa pohon/kelompok ilmu pengetahuan dan/atau teknologi',
                'fungsi' => [
                    ['judul' => 'Pelaksanaan dan Pengembangan Pendidikan', 'deskripsi' => 'Pelaksanaan dan pengembangan pendidikan di lingkungan fakultas'],
                    ['judul' => 'Pelaksanaan Penelitian', 'deskripsi' => 'Pelaksanaan penelitian untuk pengembangan ilmu pengetahuan dan/atau teknologi di lingkungan fakultas'],
                    ['judul' => 'Pelaksanaan Pengabdian kepada Masyarakat', 'deskripsi' => 'Pelaksanaan pengabdian kepada masyarakat sesuai dengan bidang keilmuan di lingkungan fakultas'],
                    ['judul' => 'Pembinaan Sivitas Akademika', 'deskripsi' => 'Pembinaan Sivitas Akademika dan Tenaga Kependidikan di lingkungan fakultas'],
                    ['judul' => 'Pelaksanaan Urusan Administrasi', 'deskripsi' => 'Pelaksanaan urusan administrasi fakultas'],
                ]
            ],
            'visi_misi' => [
                'visi' => 'Pada tahun 2029, Fakultas Sains dan Teknologi Informasi (FSTI) ITK akan menjadi pusat keunggulan akademik dan inovasi, menghasilkan lulusan yang kompeten, adaptif, berdaya saing global, dan karya-karya dalam bidang sains dan teknologi informasi yang berdampak bagi kemajuan Kalimantan dan Indonesia',
                'misi_tagline' => 'Misi: PRESTASI',
                'misi' => [
                    ['huruf' => 'P', 'teks' => 'Pendidikan Berkualitas'],
                    ['huruf' => 'R', 'teks' => 'Riset dan Inovasi Terdepan'],
                    ['huruf' => 'E', 'teks' => 'Ekosistem Kolaboratif'],
                    ['huruf' => 'S', 'teks' => 'Sinergi'],
                    ['huruf' => 'T', 'teks' => 'Tata Kelola Optimal'],
                    ['huruf' => 'A', 'teks' => 'Aktivasi Potensi Civitas'],
                    ['huruf' => 'S', 'teks' => 'Sistem Layanan Prima'],
                    ['huruf' => 'I', 'teks' => 'Internasionalisasi'],
                ]
            ],
            'bagan_organisasi' => $finalImagePath,
            
            'pmb_link' => 'https://pmb.itk.ac.id',
            'tracer_study_link' => 'https://docs.google.com/forms/d/e/1FAIpQLSe09s1JB6Sm4005NakxU9uNVnLyGBEiIEv8oSO2EdLG81LIeA/viewform',
            
            'ppid_permohonan_link' => 'https://s.itk.ac.id/permintaanformfsti',
            'ppid_keberatan_link' => 'https://docs.google.com/forms/d/e/1FAIpQLSefIA7eJNmNHt0YXzWaWyLdp4zJUulojXUmh7xlVN-MQxZLlw/viewform'
        ];

        FacultyProfile::updateOrCreate(
            ['id' => 1],
            ['content' => $contentData]
        );

        $this->command->info("Selesai! Profil Fakultas berhasil di-seed. Gambar bagan organisasi disalin ke storage.");
    }
}