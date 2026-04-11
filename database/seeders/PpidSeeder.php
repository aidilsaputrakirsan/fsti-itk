<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPpid;
use App\Models\DokumenPpid;
use Illuminate\Support\Facades\Schema;

class PpidSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DokumenPpid::truncate();
        KategoriPpid::truncate();
        Schema::enableForeignKeyConstraints();

        // ==========================================
        // DATA 1: INFORMASI WAJIB BERKALA
        // ==========================================
        $berkala = [
            [
                'nama_kategori' => 'A. Informasi tentang Profil Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 1,
                'dokumen' => [
                    ['judul' => 'Informasi alamat lengkap fakultas', 'url' => '/kontak'],
                    ['judul' => 'Struktur organisasi fakultas', 'url' => '/profil/bagan-organisasi'],
                    ['judul' => 'Gambaran umum/tentang fakultas', 'url' => '/profil/tentang-fakultas'],
                    ['judul' => 'Profil pejabat fakultas', 'url' => '/profil/pimpinan-fakultas'],
                    ['judul' => 'Tugas dan fungsi fakultas', 'url' => '/profil/tentang-fakultas'],
                    ['judul' => 'Visi dan misi fakultas', 'url' => '/profil/visi-misi'],
                    ['judul' => 'Laporan Harta Kekayaan Bagi Pejabat Negara (LHKPN)', 'url' => '#'], 
                ]
            ],
            [
                'nama_kategori' => 'B. Ringkasan program dan/atau kegiatan Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 2,
                'dokumen' => [
                    ['judul' => 'Agenda Kegiatan Fakultas', 'url' => '/informasi/agenda'],
                    ['judul' => 'Informasi Penerimaan Mahasiswa Baru (PMB)', 'url' => '/kemahasiswaan/informasi-penerimaan-mahasiswa-baru'],
                    ['judul' => 'Kegiatan Mahasiswa', 'url' => '/kemahasiswaan/kegiatan-mahasiswa'],
                    ['judul' => 'Informasi Beasiswa', 'url' => '/kemahasiswaan/informasi-beasiswa'],
                    ['judul' => 'Informasi Program Studi', 'url' => '/prodi'],
                ]
            ],
            [
                'nama_kategori' => 'C. Informasi tentang kinerja Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 3,
                'dokumen' => [
                    ['judul' => 'Laporan kinerja fakultas', 'url' => '#'], 
                ]
            ],
            [
                'nama_kategori' => 'D. Laporan Keuangan',
                'jenis_informasi' => 'Berkala',
                'urutan' => 4,
                'dokumen' => [
                    ['judul' => 'Laporan keuangan tahunan', 'url' => '#'], 
                ]
            ],
            [
                'nama_kategori' => 'E. Ringkasan Laporan Akses Informasi Publik',
                'jenis_informasi' => 'Berkala',
                'urutan' => 5,
                'dokumen' => [
                    ['judul' => 'Ringkasan Laporan Akses Informasi Publik', 'url' => '#'], 
                ]
            ],
            [
                'nama_kategori' => 'F. Kebijakan/Edaran Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 6,
                'dokumen' => [
                    ['judul' => 'Kebijakan/Edaran/Pengumuman Dekan', 'url' => '/informasi/pengumuman'],
                    ['judul' => 'Daftar Rancangan Kebijakan/Edaran/Pengumuman Dekan', 'url' => 'https://docs.google.com/spreadsheets/d/1uiiMLgJZrzFQWeOMI-Q1DlGeEGPlSClSOor052xsU_s/edit?gid=0#gid=0'],
                ]
            ],
            [
                'nama_kategori' => 'G. Informasi Terkait Hak Dan Tata Cara Memperoleh Informasi Publik',
                'jenis_informasi' => 'Berkala',
                'urutan' => 7,
                'dokumen' => [
                    ['judul' => 'Tata Cara Permohonan Informasi Publik', 'url' => '/assets/ppid/sop-pengelolaan-informasi-publik.pdf'],
                    ['judul' => 'Formulir Permohonan Informasi Publik', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSfqWYCCyMTZ2TXrDGIu0dkOgh_xPIy__31NZLdjYNpjNv422w/viewform'],
                    ['judul' => 'Tata Cara Pengajuan Keberatan', 'url' => '/assets/ppid/sop-pengelolaan-keberatan-informasi.pdf'],
                    ['judul' => 'Formulir Pengajuan Keberatan Atas Layanan Informasi Publik', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSefIA7eJNmNHt0YXzWaWyLdp4zJUulojXUmh7xlVN-MQxZLlw/viewform'],
                    ['judul' => 'Tata Cara Pengaduan Penyalahgunaan Wewenang Atau Pelanggaran', 'url' => 'https://ppid.itk.ac.id/pengaduan-penyalahgunaan-wewenang/'],
                ]
            ]
        ];

        // ==========================================
        // DATA 2: INFORMASI WAJIB SETIAP SAAT
        // ==========================================
        $setiapSaat = [
            [
                'nama_kategori' => 'A. Daftar Informasi Publik Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 1,
                'dokumen' => [
                    ['judul' => 'Daftar Informasi Publik Fakultas Sains dan Teknologi Informasi', 'url' => '/assets/ppid/daftar-informasi-publik-fsti.pdf']
                ]
            ],
            [
                'nama_kategori' => 'B. Dokumen pendukung dalam penyusunan kebijakan/edaran/pengumuman yang telah ditetapkan Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 2,
                'dokumen' => [
                    ['judul' => 'Risalah Rapat', 'url' => 'https://docs.google.com/spreadsheets/d/1eUE6s6IAK42Qu7sUfNulnif5NuaAPeAon2TP6gWwy0E/edit?gid=0#gid=0']
                ]
            ],
            [
                'nama_kategori' => 'C. Informasi Tentang Organisasi, Administrasi, Kepegawaian, dan Keuangan Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 3,
                'dokumen' => [
                    ['judul' => 'Informasi tentang pedoman pengelolaan organisasi', 'url' => 'https://ppid.itk.ac.id/pedoman-pengelolaan-organisasi/'],
                    ['judul' => 'Informasi tentang pedoman pengelolaan administrasi', 'url' => 'https://ppid.itk.ac.id/wp-content/uploads/2025/09/6_PERATURAN-REKTOR-TENTANG-PEDOMAN-TATA-NASKAH-DINAS-DI-LINGKUNGAN-INSTITUT-TEKNOLOGI-KALIMANTAN_compressed.pdf'],
                    ['judul' => 'Informasi tentang pedoman kepegawaian', 'url' => 'https://ppid.itk.ac.id/pedoman-kepegawaian/'],
                    ['judul' => 'Informasi tentang pedoman pengelolaan keuangan', 'url' => 'https://ppid.itk.ac.id/pedoman-pengelolaan-keuangan/'],
                    ['judul' => 'Informasi tentang pedoman akademik', 'url' => 'https://api-web.itk.ac.id/storage/ppid-documents/1758949789-Peraturan%20Akademik%20Nomor%204%20dan%20Nomor%209_compressed.pdf'],
                    ['judul' => 'Informasi tentang data statistik fakultas', 'url' => '/profil/tentang-fakultas']
                ]
            ],
            [
                'nama_kategori' => 'D. Surat Menyurat Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 4,
                'dokumen' => [
                    ['judul' => 'Dokumen Surat Menyurat', 'url' => 'https://docs.google.com/spreadsheets/d/1fHqfcNs2Q7cait-lDzS9uzxF2O2KpLNT/edit?gid=1618885833#gid=1618885833']
                ]
            ],
            [
                'nama_kategori' => 'E. Daftar Penelitian & Pengabdian Masyarakat Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 5,
                'dokumen' => [
                    ['judul' => 'Daftar Penelitian & Pengabdian Masyarakat', 'url' => '#'] 
                ]
            ],
            [
                'nama_kategori' => 'F. Rencana Strategis dan Rencana Kerja Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 6,
                'dokumen' => [
                    ['judul' => 'Rencana Strategis', 'url' => '#'], 
                    ['judul' => 'Perjanjian Kinerja', 'url' => '/assets/ppid/perjanjian-kinerja.pdf']
                ]
            ]
        ];

        $semuaData = array_merge($berkala, $setiapSaat);

        foreach ($semuaData as $kategoriData) {
            $kategori = KategoriPpid::create([
                'nama_kategori' => $kategoriData['nama_kategori'],
                'jenis_informasi' => $kategoriData['jenis_informasi'],
                'urutan' => $kategoriData['urutan'],
            ]);

            foreach ($kategoriData['dokumen'] as $dokumenData) {
                DokumenPpid::create([
                    'kategori_ppid_id' => $kategori->id,
                    'judul_dokumen' => $dokumenData['judul'],
                    'file_url' => $dokumenData['url'],
                ]);
            }
        }
    }
}