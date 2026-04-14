<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidCategory;
use App\Models\PpidDocument;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PpidSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PpidDocument::truncate();
        PpidCategory::truncate();
        Schema::enableForeignKeyConstraints();

        if (!Storage::disk('public')->exists('ppid-documents')) {
            Storage::disk('public')->makeDirectory('ppid-documents');
        }

        $assetPath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'ppid_documents');

        // ==========================================
        // DATA 1: INFORMASI WAJIB BERKALA
        // ==========================================
        $berkala = [
            [
                'nama_kategori' => 'Informasi tentang Profil Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 1,
                'dokumen' => [
                    ['judul' => 'Informasi alamat lengkap fakultas', 'url' => '/kontak', 'is_file' => false],
                    ['judul' => 'Struktur organisasi fakultas', 'url' => '/profil/bagan-organisasi', 'is_file' => false],
                    ['judul' => 'Gambaran umum/tentang fakultas', 'url' => '/profil/tentang', 'is_file' => false],
                    ['judul' => 'Profil pejabat fakultas', 'url' => '/profil/pimpinan-fakultas', 'is_file' => false],
                    ['judul' => 'Tugas dan fungsi fakultas', 'url' => '/profil/tentang', 'is_file' => false],
                    ['judul' => 'Visi dan misi fakultas', 'url' => '/profil/tentang', 'is_file' => false],
                    ['judul' => 'Laporan Harta Kekayaan Bagi Pejabat Negara (LHKPN)', 'url' => '#', 'is_file' => false],
                ]
            ],
            [
                'nama_kategori' => 'Ringkasan program dan/atau kegiatan Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 2,
                'dokumen' => [
                    ['judul' => 'Agenda Kegiatan Fakultas', 'url' => '/agenda-fakultas', 'is_file' => false],
                    ['judul' => 'Informasi Penerimaan Mahasiswa Baru (PMB)', 'url' => '/informasi-pmb', 'is_file' => false],
                    ['judul' => 'Kegiatan Mahasiswa', 'url' => '/kegiatan-mahasiswa', 'is_file' => false],
                    ['judul' => 'Informasi Beasiswa', 'url' => '/beasiswa', 'is_file' => false],
                    ['judul' => 'Informasi Program Studi', 'url' => '/profil/pimpinan-prodi', 'is_file' => false],
                ]
            ],
            [
                'nama_kategori' => 'Informasi tentang kinerja Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 3,
                'dokumen' => [
                    ['judul' => 'Laporan kinerja fakultas', 'url' => '#', 'is_file' => false],
                ]
            ],
            [
                'nama_kategori' => 'Laporan Keuangan',
                'jenis_informasi' => 'Berkala',
                'urutan' => 4,
                'dokumen' => [
                    ['judul' => 'Laporan keuangan tahunan', 'url' => '#', 'is_file' => false],
                ]
            ],
            [
                'nama_kategori' => 'Ringkasan Laporan Akses Informasi Publik',
                'jenis_informasi' => 'Berkala',
                'urutan' => 5,
                'dokumen' => [
                    ['judul' => 'Ringkasan Laporan Akses Informasi Publik', 'url' => '#', 'is_file' => false],
                ]
            ],
            [
                'nama_kategori' => 'Kebijakan/Edaran Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Berkala',
                'urutan' => 6,
                'dokumen' => [
                    ['judul' => 'Kebijakan/Edaran/Pengumuman Dekan', 'url' => '/pengumuman', 'is_file' => false],
                    ['judul' => 'Daftar Rancangan Kebijakan/Edaran/Pengumuman Dekan', 'url' => 'https://docs.google.com/spreadsheets/d/1uiiMLgJZrzFQWeOMI-Q1DlGeEGPlSClSOor052xsU_s/edit?gid=0#gid=0', 'is_file' => false],
                ]
            ],
            [
                'nama_kategori' => 'Informasi Terkait Hak Dan Tata Cara Memperoleh Informasi Publik',
                'jenis_informasi' => 'Berkala',
                'urutan' => 7,
                'dokumen' => [
                    ['judul' => 'Tata Cara Permohonan Informasi Publik', 'url' => 'sop-pengelolaan-informasi-publik.pdf', 'is_file' => true],
                    ['judul' => 'Formulir Permohonan Informasi Publik', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSfqWYCCyMTZ2TXrDGIu0dkOgh_xPIy__31NZLdjYNpjNv422w/viewform', 'is_file' => false],
                    ['judul' => 'Tata Cara Pengajuan Keberatan', 'url' => 'sop-pengelolaan-keberatan-informasi.pdf', 'is_file' => true],
                    ['judul' => 'Formulir Pengajuan Keberatan Atas Layanan Informasi Publik', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSefIA7eJNmNHt0YXzWaWyLdp4zJUulojXUmh7xlVN-MQxZLlw/viewform', 'is_file' => false],
                    ['judul' => 'Tata Cara Pengaduan Penyalahgunaan Wewenang Atau Pelanggaran', 'url' => 'https://ppid.itk.ac.id/pengaduan-penyalahgunaan-wewenang/', 'is_file' => false],
                ]
            ]
        ];

        // ==========================================
        // DATA 2: INFORMASI WAJIB SETIAP SAAT
        // ==========================================
        $setiapSaat = [
            [
                'nama_kategori' => 'Daftar Informasi Publik Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 1,
                'dokumen' => [
                    ['judul' => 'Daftar Informasi Publik Fakultas Sains dan Teknologi Informasi', 'url' => 'daftar-informasi-publik-fsti.pdf', 'is_file' => true]
                ]
            ],
            [
                'nama_kategori' => 'Dokumen pendukung dalam penyusunan kebijakan/edaran/pengumuman yang telah ditetapkan Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 2,
                'dokumen' => [
                    ['judul' => 'Risalah Rapat', 'url' => 'https://docs.google.com/spreadsheets/d/1eUE6s6IAK42Qu7sUfNulnif5NuaAPeAon2TP6gWwy0E/edit?gid=0#gid=0', 'is_file' => false]
                ]
            ],
            [
                'nama_kategori' => 'Informasi Tentang Organisasi, Administrasi, Kepegawaian, dan Keuangan Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 3,
                'dokumen' => [
                    ['judul' => 'Informasi tentang pedoman pengelolaan organisasi', 'url' => 'https://ppid.itk.ac.id/pedoman-pengelolaan-organisasi/', 'is_file' => false],
                    ['judul' => 'Informasi tentang pedoman pengelolaan administrasi', 'url' => 'https://ppid.itk.ac.id/wp-content/uploads/2025/09/6_PERATURAN-REKTOR-TENTANG-PEDOMAN-TATA-NASKAH-DINAS-DI-LINGKUNGAN-INSTITUT-TEKNOLOGI-KALIMANTAN_compressed.pdf', 'is_file' => false],
                    ['judul' => 'Informasi tentang pedoman kepegawaian', 'url' => 'https://ppid.itk.ac.id/pedoman-kepegawaian/', 'is_file' => false],
                    ['judul' => 'Informasi tentang pedoman pengelolaan keuangan', 'url' => 'https://ppid.itk.ac.id/pedoman-pengelolaan-keuangan/', 'is_file' => false],
                    ['judul' => 'Informasi tentang pedoman akademik', 'url' => 'https://api-web.itk.ac.id/storage/ppid-documents/1758949789-Peraturan%20Akademik%20Nomor%204%20dan%20Nomor%209_compressed.pdf', 'is_file' => false],
                    ['judul' => 'Informasi tentang data statistik fakultas', 'url' => '/profil/tentang', 'is_file' => false]
                ]
            ],
            [
                'nama_kategori' => 'Surat Menyurat Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 4,
                'dokumen' => [
                    ['judul' => 'Dokumen Surat Menyurat', 'url' => 'https://docs.google.com/spreadsheets/d/1fHqfcNs2Q7cait-lDzS9uzxF2O2KpLNT/edit?gid=1618885833#gid=1618885833', 'is_file' => false]
                ]
            ],
            [
                'nama_kategori' => 'Daftar Penelitian & Pengabdian Masyarakat Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 5,
                'dokumen' => [
                    ['judul' => 'Daftar Penelitian', 'url' => '/penelitian', 'is_file' => false],
                    ['judul' => 'Daftar Pengabdian Masyarakat', 'url' => '/pengabdian', 'is_file' => false]
                ]
            ],
            [
                'nama_kategori' => 'Rencana Strategis dan Rencana Kerja Fakultas Sains dan Teknologi Informasi',
                'jenis_informasi' => 'Setiap Saat',
                'urutan' => 6,
                'dokumen' => [
                    ['judul' => 'Rencana Strategis', 'url' => '#', 'is_file' => false],
                    ['judul' => 'Perjanjian Kinerja', 'url' => 'perjanjian-kinerja.pdf', 'is_file' => true]
                ]
            ]
        ];

        $semuaData = array_merge($berkala, $setiapSaat);
        $copiedCount = 0;

        foreach ($semuaData as $kategoriData) {
            $kategori = PpidCategory::create([
                'nama_kategori' => $kategoriData['nama_kategori'],
                'jenis_informasi' => $kategoriData['jenis_informasi'],
                'urutan' => $kategoriData['urutan'],
            ]);

            foreach ($kategoriData['dokumen'] as $dokumenData) {

                $finalUrl = $dokumenData['url'];

                if ($dokumenData['is_file'] === true) {
                    $fileName = $dokumenData['url'];
                    $sourceFile = $assetPath . DIRECTORY_SEPARATOR . $fileName;

                    if (File::exists($sourceFile)) {
                        Storage::disk('public')->put('ppid-documents/' . $fileName, File::get($sourceFile));
                        $finalUrl = '/storage/ppid-documents/' . $fileName;
                        $copiedCount++;
                    } else {
                        $this->command->error("GAGAL: File '{$fileName}' tidak ditemukan di folder assets/ppid_documents/");
                        $finalUrl = '#';
                    }
                }

                PpidDocument::create([
                    'ppid_category_id' => $kategori->id,
                    'judul_dokumen' => $dokumenData['judul'],
                    'file_url' => $finalUrl,
                ]);
            }
        }

        $this->command->info("Selesai! Kategori dan Dokumen PPID berhasil di-seed. Total {$copiedCount} file PDF disalin ke Storage.");
    }
}
