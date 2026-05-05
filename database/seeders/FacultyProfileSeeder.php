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

        if (!Storage::disk('public')->exists('fasilitas')) {
            Storage::disk('public')->makeDirectory('fasilitas');
        }

        $fasilitasImages = [
            'gedung-b.webp',
            'taman-b.webp',
            'co-learning-space.webp',
            'lapangan-olahraga.webp',
            'ruang-kelas.webp',
            'fisika.webp',
            'perpustakaan.webp',
            'taman-alumni.webp',
            'klinik.webp',
            'masjid.webp',
            'asrama.webp',
            'ult.webp'
        ];

        foreach ($fasilitasImages as $fImg) {
            $fPath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'fasilitas' . DIRECTORY_SEPARATOR . $fImg);
            if (File::exists($fPath)) {
                Storage::disk('public')->put('fasilitas/' . $fImg, File::get($fPath));
            }
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

            'sambutan_dekan' => 'Selamat datang di Website Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan. Kehadiran website ini merupakan wujud komitmen kami dalam memberikan akses informasi yang cepat, transparan, dan akuntabel terkait berbagai kegiatan akademik, kemahasiswaan, penelitian, pengabdian kepada masyarakat, serta kerja sama yang dilaksanakan di lingkungan fakultas. FSTI hadir sebagai bagian penting dalam pengembangan sumber daya manusia unggul di bidang sains, analitika data, teknik elektro, informatika dan bisnis, khususnya dalam mendukung pembangunan Kalimantan sebagai wilayah strategis nasional dan Ibu Kota Nusantara. Kami terus berupaya menciptakan ekosistem pendidikan tinggi yang adaptif, inovatif, dan berdaya saing global melalui penguatan tridarma perguruan tinggi.',
            'sambutan_dekan_paragraf_2' => 'Melalui website ini, kami berharap seluruh informasi mengenai program studi, layanan administrasi, prestasi mahasiswa, agenda kegiatan, hingga peluang kolaborasi dapat diakses secara mudah, cepat, dan transparan oleh seluruh pemangku kepentingan. Website ini juga merupakan salah satu wujud komitmen Fakultas Sains dan Teknologi Informasi dalam merealisasikan misi mewujudkan tata kelola yang optimal dan berintegritas, serta menghadirkan sistem layanan prima bagi sivitas akademika dan masyarakat luas. Kami mengucapkan terima kasih kepada seluruh pihak yang telah berkontribusi dalam pengembangan Fakultas Sains dan Teknologi Informasi. Semoga website ini memberikan manfaat yang luas dan menjadi jembatan komunikasi yang efektif antara fakultas dengan masyarakat.',

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
            'ppid_keberatan_link' => 'https://docs.google.com/forms/d/e/1FAIpQLSefIA7eJNmNHt0YXzWaWyLdp4zJUulojXUmh7xlVN-MQxZLlw/viewform',
            'prestasi_link' => 'https://docs.google.com/forms/d/e/1FAIpQLSfaToVEnR6vnZSTggEbH_IfAVbOpuPf1aCirsNTRb3m8aFL-Q/viewform?pli=1',

            'fasilitas' => [
                ['nama' => 'Gedung B ITK', 'deskripsi' => 'Pusat administrasi dan akademik utama yang mendukung berbagai kegiatan perkuliahan.', 'gambar' => 'fasilitas/gedung-b.webp'],
                ['nama' => 'Taman Gedung B ITK', 'deskripsi' => 'Area terbuka hijau di sekitar Gedung B untuk tempat istirahat dan diskusi santai civitas akademika.', 'gambar' => 'fasilitas/taman-b.webp'],
                ['nama' => 'Co Learning Space', 'deskripsi' => 'Ruang komunal modern yang dirancang untuk mendukung diskusi, kolaborasi, dan belajar bersama.', 'gambar' => 'fasilitas/co-learning-space.webp'],
                ['nama' => 'Lapangan Basket', 'deskripsi' => 'Fasilitas olahraga luar ruangan untuk mendukung kesehatan dan kegiatan ekstrakurikuler mahasiswa.', 'gambar' => 'fasilitas/lapangan-olahraga.webp'],
                ['nama' => 'Ruang Kelas', 'deskripsi' => 'Ruang belajar yang nyaman dan dilengkapi dengan fasilitas multimedia untuk menunjang perkuliahan.', 'gambar' => 'fasilitas/ruang-kelas.webp'],
                ['nama' => 'Laboratorium', 'deskripsi' => 'Pusat riset dan praktikum yang dilengkapi dengan peralatan modern untuk pengembangan sains dan teknologi.', 'gambar' => 'fasilitas/fisika.webp'],
                ['nama' => 'Perpustakaan', 'deskripsi' => 'Pusat literatur dan referensi akademik lengkap guna mendukung kebutuhan studi dan penelitian mahasiswa.', 'gambar' => 'fasilitas/perpustakaan.webp'],
                ['nama' => 'Unit Layanan Terpadu', 'deskripsi' => 'Pusat layanan administrasi satu pintu bagi mahasiswa dan civitas akademika.', 'gambar' => 'fasilitas/ult.webp'],
                ['nama' => 'Taman Alumni', 'deskripsi' => 'Ruang publik terbuka hijau sebagai tempat berkumpul dan menjalin jejaring antar alumni.', 'gambar' => 'fasilitas/taman-alumni.webp'],
                ['nama' => 'Klinik', 'deskripsi' => 'Fasilitas kesehatan dasar bagi civitas akademika yang siap melayani di lingkungan kampus.', 'gambar' => 'fasilitas/klinik.webp'],
                ['nama' => 'Masjid', 'deskripsi' => 'Tempat ibadah yang representatif, tenang, dan nyaman di dalam lingkungan kampus ITK.', 'gambar' => 'fasilitas/masjid.webp'],
                ['nama' => 'Asrama', 'deskripsi' => 'Hunian mahasiswa yang aman dan terintegrasi langsung dengan lingkungan kampus.', 'gambar' => 'fasilitas/asrama.webp']
            ]

        ];

        FacultyProfile::updateOrCreate(
            ['id' => 1],
            ['content' => $contentData]
        );

        $this->command->info("Selesai! Profil Fakultas berhasil di-seed. Gambar bagan organisasi disalin ke storage.");
    }
}
