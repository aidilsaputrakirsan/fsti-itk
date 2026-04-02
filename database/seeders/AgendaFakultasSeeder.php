<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgendaFakultas;

class AgendaFakultasSeeder extends Seeder
{
    public function run(): void
    {
        $agendas = [
            // --- FEBRUARI ---
            ['title' => 'OPEN HOUSE FSTI', 'start_date' => '2025-01-08', 'end_date' => '2025-02-11', 'organizer' => 'FSTI ITK'],
            ['title' => 'Open Talk Prodi Sistem Informasi', 'start_date' => '2025-02-10', 'end_date' => null, 'organizer' => 'Prodi Sistem Informasi'],
            ['title' => 'Sosialisasi Akademik Teknik Elektro', 'start_date' => '2025-02-11', 'end_date' => null, 'organizer' => 'Prodi Teknik Elektro'],
            ['title' => 'Open Talk Civitas Akademika FSTI', 'start_date' => '2025-02-13', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sosialisasi Akademik Bisnis Digital', 'start_date' => '2025-02-14', 'end_date' => null, 'organizer' => 'Prodi Bisnis Digital'],
            ['title' => 'Workshop "Akal Imitasi (AI) dalam Fisika: Memanfaatkan LLM untuk Guru dan Siswa"', 'start_date' => '2025-02-17', 'end_date' => null, 'organizer' => 'Prodi Fisika'],
            ['title' => 'Kegiatan BizTalktive "Sosialisasi dan Sharing Session P2MW"', 'start_date' => '2025-02-18', 'end_date' => null, 'organizer' => 'Kemahasiswaan ITK'],
            ['title' => 'Sosialisasi HIV/ Aids dan TB beserta cara pencegahannya', 'start_date' => '2025-02-18', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Mukernas "Penandatangan LoI dengan Association for Information System Indonesia Chapter"', 'start_date' => '2025-02-20', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Gerakan Masyarakat Hidup Sehat (GERMAS) Sehat, Bugar, Ceria FSTI', 'start_date' => '2025-02-21', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Germas FSTI', 'start_date' => '2025-02-22', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sharing Session Lomba Krenova "Kreativitas dan Inovasi Tahun 2025"', 'start_date' => '2025-02-26', 'end_date' => null, 'organizer' => 'Kemahasiswaan ITK'],
            ['title' => 'Diskusi Perpanjangan MOU dan PKS untuk TUK Mandiri ITK', 'start_date' => '2025-02-27', 'end_date' => null, 'organizer' => 'FSTI ITK'],

            // --- MARET ---
            ['title' => 'Sharing Session Kompetisi PF Muda Tahun 2025', 'start_date' => '2025-03-04', 'end_date' => null, 'organizer' => 'Kemahasiswaan ITK'],
            ['title' => 'Kuliah Umum Transisi Energi untuk Menghambat Pemanasan Global dan Adaptasi Bencana Perubahan Iklim', 'start_date' => '2025-03-04', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sosialisasi Kerjasama Lisensi dan Sertifikasi Program Microsoft untuk Instansi Pendidikan', 'start_date' => '2025-03-10', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Inisiasi Kolaborasi Global FSTI ITK dan CQUT Jalin Kerjasama Riset Pendidikan', 'start_date' => '2025-03-14', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Inisiasi Kerjasama FSTI ITK dengan TerraDrone Indonesia', 'start_date' => '2025-03-20', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Rapat Perdana Tim Zona Integritas FSTI', 'start_date' => '2025-03-20', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Gerakan Masyarakat Hidup Sehat (GERMAS) Sehat, Bugar, Ceria FSTI', 'start_date' => '2025-03-21', 'end_date' => null, 'organizer' => 'FSTI ITK'],

            // --- APRIL ---
            ['title' => 'Pelatihan Drone dan Sertifikasi Remote Pilot Jurusan Sains dan Analitika Data', 'start_date' => '2025-04-01', 'end_date' => null, 'organizer' => 'Jurusan SAD'],
            ['title' => 'Gerakan Masyarakat Hidup Sehat (GERMAS) Sehat, Bugar, Ceria FSTI', 'start_date' => '2025-04-15', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Expo Kerja Praktik Prodi Ilmu Aktuaria', 'start_date' => '2025-04-23', 'end_date' => null, 'organizer' => 'Prodi Ilmu Aktuaria'],

            // --- MEI ---
            ['title' => 'Pelaksanaan Kelas Kolaborasi Praktisi dan Manajemen Layanan Teknologi Informasi', 'start_date' => '2025-05-05', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pembekalan Wisuda Periode Mei 2025 dan Sosialisasi Pembentukan Ikatan Alumni (IKA FSTI)', 'start_date' => '2025-05-06', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Kunjungan FSTI dan Bappeda Litbang Balikpapan', 'start_date' => '2025-05-09', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-05-16', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sosialisasi Persiapan P2MW Tahun 2025', 'start_date' => '2025-05-19', 'end_date' => null, 'organizer' => 'Kemahasiswaan ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-05-20', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-05-22', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Germas SDM ITK- FSTI', 'start_date' => '2025-05-23', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sosialisasi Djarum Beasiswa Plus', 'start_date' => '2025-05-23', 'end_date' => null, 'organizer' => 'Kemahasiswaan ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-05-27', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sharing Company SLB Schlumberger Limited', 'start_date' => '2025-05-28', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-05-30', 'end_date' => null, 'organizer' => 'FSTI ITK'],

            // --- JUNI ---
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-06-04', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sosialisasi dan Orientasi Calon Pegawai Negeri Sipil (CPNS): "Satu Langkah, Sejuta Manfaat"', 'start_date' => '2025-06-05', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-06-11', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Penandatanganan Perjanjian Kinerja Fakultas Sains dan Teknologi Informasi', 'start_date' => '2025-06-12', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Peningkatan Kemampuan Bahasa Inggris "FSTI English Booster"', 'start_date' => '2025-06-18', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'NIVIDIA Roadshow and Bitracom Goes To campus Tahun 2025', 'start_date' => '2025-06-24', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Gerakan Masyarakat Hidup Sehat (GERMAS) Sehat, Bugar, Ceria FSTI', 'start_date' => '2025-06-26', 'end_date' => null, 'organizer' => 'FSTI ITK'],

            // --- JULI ---
            ['title' => 'Sertifikasi Kompetensi Program Vocational School Graduate Academy (VSGA)', 'start_date' => '2025-07-02', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Sosialisasi Ekuivalensi Kurikulum 2025 Program Studi Ilmu Aktuaria', 'start_date' => '2025-07-18', 'end_date' => null, 'organizer' => 'Prodi Ilmu Aktuaria'],
            ['title' => 'Sosialisasi Lomba Gemastik "Semangat FSTI Menangkan Gemastik 2025"', 'start_date' => '2025-07-21', 'end_date' => null, 'organizer' => 'Kemahasiswaan ITK'],
            ['title' => 'Studi Banding (Benchmarking) dengan Program Studi S1 Teknologi Informasi ITS Surabaya', 'start_date' => '2025-07-25', 'end_date' => null, 'organizer' => 'Prodi Informatika ITK'],
            ['title' => 'GERMAS FSTI X FRTI', 'start_date' => '2025-07-25', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Kunjungan Universitas Kristen Maranatha dalam rangka jalin kerjasama strategis', 'start_date' => '2025-07-28', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Introductory Meeting FSTI ITK - MyEduSolve (Sertifikasi Digital Internasional)', 'start_date' => '2025-07-29', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Workshop Penyusunan Silabus, RPS dan Naskah Akademik', 'start_date' => '2025-07-29', 'end_date' => '2025-07-31', 'organizer' => 'FSTI ITK'],

            // --- AGUSTUS ---
            ['title' => 'Kerjasama Jurusan Sains dan Analitika Data dengan Dinas Sosial', 'start_date' => '2025-08-05', 'end_date' => null, 'organizer' => 'Jurusan SAD'],
            ['title' => 'Pertemuan Ilmiah Nasional Fisika Medis dan Biofisika VIII', 'start_date' => '2025-08-07', 'end_date' => '2025-08-08', 'organizer' => 'Prodi Fisika'],
            ['title' => 'Workshop Persiapan Kurikulum MMT', 'start_date' => '2025-08-08', 'end_date' => null, 'organizer' => 'Prodi MMT'],
            ['title' => 'Serah Terima Jabatan Pembina Kemahasiswaan dan Ketua Himpunan Program Studi Ilmu Aktuaria', 'start_date' => '2025-08-09', 'end_date' => null, 'organizer' => 'Prodi Ilmu Aktuaria'],
            ['title' => 'Orientasi Akademik Mahasiswa Baru "Program Studi Magister Manajemen Teknologi"', 'start_date' => '2025-08-15', 'end_date' => null, 'organizer' => 'Prodi MMT'],
            ['title' => 'Upacara Hari Kemerdekaan RI', 'start_date' => '2025-08-17', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Workshop Strategi Penerapan Good Governance dalam Tata Kelola dan Manajemen Teknologi (UPPS)', 'start_date' => '2025-08-21', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'GERMAS FSTI X FPB– FUN WALK & LOMBA AGUSTUSAN', 'start_date' => '2025-08-22', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Welcome Party Dosen dan Mahasiswa Baru 2025 Program Studi Ilmu Aktuaria', 'start_date' => '2025-08-22', 'end_date' => null, 'organizer' => 'Prodi Ilmu Aktuaria'],
            ['title' => 'Kuliah Perdana Program Studi Magister Manajemen Teknologi (MMT)', 'start_date' => '2025-08-25', 'end_date' => null, 'organizer' => 'Prodi MMT'],
            ['title' => 'Kuliah Perdana "Anatomi dan Fisiologi Bidang Minat Fisika Medis" bersama dr. David Andi Wijaya', 'start_date' => '2025-08-30', 'end_date' => null, 'organizer' => 'Prodi Fisika'],

            // --- SEPTEMBER ---
            ['title' => 'Kunjungan Kerjasama Jurusan Sains dan Analitika Data dengan BRIDA Kaltim', 'start_date' => '2025-09-01', 'end_date' => null, 'organizer' => 'Jurusan SAD'],
            ['title' => 'Kunjungan Kerjasama Jurusan Sains dan Analitika Data dengan PT Taspen (Persero) Samarinda', 'start_date' => '2025-09-01', 'end_date' => null, 'organizer' => 'Jurusan SAD'],
            ['title' => 'Diskusi Kerjasama Bidang Kota Cerdas dengan OIKN', 'start_date' => '2025-09-15', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Digital Entrepreneurship Academy (DEA) bersama BPSDM Kominfo Banjarmasin', 'start_date' => '2025-09-16', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Signing Ceremonial dan Workshop Diplomasi Kepemimpinan', 'start_date' => '2025-09-17', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Kuliah Umum "Sustainable Education-Belajar Hari ini Menjaga Masa Depan" FSTI-Maranatha', 'start_date' => '2025-09-18', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Kunjungan Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA) Universitas Mulawarman', 'start_date' => '2025-09-25', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Germas FSTI', 'start_date' => '2025-09-26', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Kuliah tamu : Material Fungsional untuk Estetika dan Kesehatan Gigi Masa Depan', 'start_date' => '2025-09-27', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pembekalan Wisuda Periode Oktober 2025', 'start_date' => '2025-09-29', 'end_date' => null, 'organizer' => 'FSTI ITK'],

            // --- OKTOBER ---
            ['title' => 'Germas FSTI', 'start_date' => '2025-10-10', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Kuliah Lapangan Program Studi Statistika', 'start_date' => '2025-10-15', 'end_date' => null, 'organizer' => 'Prodi Statistika'],
            ['title' => 'Sosialisasi Akademik dan Kerja Praktek Program Studi Statistika', 'start_date' => '2025-10-16', 'end_date' => null, 'organizer' => 'Prodi Statistika'],

            // --- NOVEMBER ---
            ['title' => 'Roadshow dan Promosi Program Studi Statistika', 'start_date' => '2025-11-01', 'end_date' => null, 'organizer' => 'Prodi Statistika'],
            ['title' => 'Capacity Building Manajemen Fakultas Sains dan Teknologi Informasi', 'start_date' => '2025-11-07', 'end_date' => '2025-11-09', 'organizer' => 'FSTI ITK'],
            ['title' => 'Kunjungan ke Comand Center IKN Program Studi Statistika', 'start_date' => '2025-11-10', 'end_date' => null, 'organizer' => 'Prodi Statistika'],
            ['title' => 'Kuliah Tamu Program Studi Statistika', 'start_date' => '2025-11-12', 'end_date' => null, 'organizer' => 'Prodi Statistika'],
            ['title' => 'Germas FSTI', 'start_date' => '2025-11-14', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Workshop Penyusunan Borang Akreditasi LAMSAMA 3.0 [Hybrid]', 'start_date' => '2025-11-14', 'end_date' => '2025-11-15', 'organizer' => 'FSTI ITK'],
            ['title' => 'Workshop Izin Edar dan Standarisasi', 'start_date' => '2025-11-20', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Workshop Penyusunan Borang Akreditasi LAMINFOKOM [Hybrid]', 'start_date' => '2025-11-21', 'end_date' => '2025-11-22', 'organizer' => 'FSTI ITK'],
            ['title' => 'Workshop Best Practice Pengabdian Karya Terapan', 'start_date' => '2025-11-25', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Pelatihan Edusquad (LAMTEKNIK)', 'start_date' => '2025-11-28', 'end_date' => '2025-11-29', 'organizer' => 'FSTI ITK'],

            // --- DESEMBER ---
            ['title' => 'Rapat Kerja Manajemen Fakultas Sains dan Teknologi Informasi', 'start_date' => '2025-12-01', 'end_date' => null, 'organizer' => 'FSTI ITK'],
            ['title' => 'Germas FSTI', 'start_date' => '2025-12-05', 'end_date' => null, 'organizer' => 'FSTI ITK'],
        ];

        AgendaFakultas::truncate();

        foreach ($agendas as $item) {
            AgendaFakultas::create($item);
        }
    }
}