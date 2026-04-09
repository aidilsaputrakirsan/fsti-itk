<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hapus data lama agar tidak dobel
        Post::truncate();

        // 2. Siapkan folder Storage (Tujuan) dan Folder Assets (Sumber)
        $storagePostPath = storage_path('app/public/posts');
        $assetPostPath = database_path('seeders/assets/posts');

        // Buat folder di storage jika belum ada
        if (!File::exists($storagePostPath)) {
            File::makeDirectory($storagePostPath, 0755, true);
        }

        foreach (File::files($storagePostPath) as $file) {
            File::delete($file);
        }

        $posts = [
            [
                'judul' => 'Rapat Koordinasi Akademik Persiapan Perkuliahan Semester Genap 2024/2025',
                'kategori' => 'Akademik',
                'isi_berita' => 'Senin, 3 Februari 2025. Telah dilaksanakan Rapat Koordinasi Akademik terkait Persiapan Perkuliahan Semester Genap 2024/2025 Fakultas Sains dan Teknologi Informasi (FSTI) yang dipimpin oleh Wakil Dekan Bidang Akademik dan Kemahasiswaan, Irma Fitria, S.Si., M.Si., CDS. Dalam rapat tersebut dibahas mengenai finalisasi jadwal perkuliahan, keterlibatan dosen praktisi dalam pengajaran, pembukaan kelas Mata Kuliah lintas prodi untuk meningkatkan MBKM, serta persiapan perwalian dan FRS. Tidak hanya itu, dalam waktu dekat FSTI juga akan mengumumkan pembukaan pendaftaran asisten dosen pada mata kuliah prodi di FSTI.',
                'gambar' => 'rapat-koordinasi-akademik.png'
            ],
            [
                'judul' => 'The 2025 IEEE Indonesia Section Member Gathering',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Pertemuan tahun ini menampilkan diskusi tentang inisiatif IEEE, pembaruan dari IEEE Indonesia Section dan Region 10. Acara dimulai dengan menyanyikan lagu "Indonesia Raya" dan disambut dengan opening ceremony by Azzahraly robot dari Universitas Negeri Surabaya, diikuti dengan Opening Remarks by the Director of PENS, Aliridho Barakbah S.Kom, Ph.D. Rangkaian selanjutnya adalah sambutan oleh Dr. Kurnianingsih selaku ketua dari IEEE Indonesia Section 2025 yang juga menyampaikan beberapa gambaran umum serta progres terkait program-program yang dijalankan.',
                'gambar' => 'ieee-gathering-2025.png'
            ],
            [
                'judul' => 'Open Talk Prodi Sistem Informasi',
                'kategori' => 'Akademik',
                'isi_berita' => 'Program Studi Sistem Informasi kembali mengadakan kegiatan rutin semester dalam bentuk Open Talk. Kegiatan ini bertujuan sebagai wadah penyampaian informasi dari prodi kepada civitas akademika terutama dalam mempersiapkan awal semester baru. Kegiatan yang dilaksanakan pada awal Semester Genap Tahun Akademik 2024/2025 ini dibuka oleh Ketua Jurusan Teknik Elektro, Informatika, dan Bisnis, Bapak. M. Ihsan Alfani Putera, STr.Kom., M.Kom, sekaligus memperkenalkan Fakultas FSTI. Selain perkenalan FSTI, terdapat juga beberapa agenda lainnya, yaitu: Sosialisasi Layanan FSTI, Timeline Perkuliahan (KP dan TA), Motivasi Kegiatan MBKM Mandiri, dan Pengumuman Prestasi Mahasiswa Prodi SI. Dengan adanya kegiatan ini diharapkan mahasiswa dapat lebih mempersiapkan diri untuk menghadapi masa perkuliahan yang akan segera dimulai.',
                'gambar' => 'open-talk-si.png'
            ],
            [
                'judul' => 'Rapat Koordinasi Akademik FSTI',
                'kategori' => 'Akademik',
                'isi_berita' => "Jum'at, 14 Februari 2024\nFSTI melaksanakan rapat koordinasi akademik yang di pimpin oleh Wakil Dekan Bidang Akademik dan Kemahasiswaan ibu Irma Fitria, S.Si., M.Si. Rapat koordinasi kali ini membahas strategi Riset, PKM dan Roadmap laboratorium FSTI. dimana FSTI berupaya meningkatkan meningkatkan PKM di berbagai sektor termasuk air, gizi, sosial, ekonomi, pertanian, dan energi terbarukan . di daerah-daerah yang membutuhkan perhatian dalam berbagai sektor melalui program-program yang bersifat aplikatif, berbasis riset, dan kolaboratif dengan berbagai pihak terkait.",
                'gambar' => 'rapat-riset-fsti.png'
            ],
            [
                'judul' => 'BizTalktive : Sosialisasi & Sharing Session P2MW',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Departemen BUMH Himpunan Mahasiswa Bisnis Digital mengadakan kegiatan BizTalktive: Sosialisasi & Sharing Session P2MW yang bertempat di Gedung E-202 Institut Teknologi Kalimantan. Kegiatan ini bertujuan untuk memberikan pemahaman lebih dalam mengenai Program Pembinaan Mahasiswa Wirausaha (P2MW), mulai dari pemilihan topik yang tepat hingga penyusunan proposal yang sesuai dengan standar penilaian. BizTalktive menjadi wadah bagi mahasiswa Bisnis Digital untuk memperoleh informasi langsung dari mahasiswa yang telah berhasil mendapatkan pendanaan P2MW pada tahun sebelumnya. Dalam sesi sharing ini, para peserta mendapatkan wawasan mengenai proses seleksi, tantangan yang dihadapi, serta strategi agar dapat lolos pendanaan.',
                'gambar' => 'biztalktive-p2mw.png'
            ],
            [
                'judul' => 'MUKERNAS dan Penanda Tanganan LoI dengan AISINDO',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Association for Information System Indonesian Chapter (AISINDO) atau Asosiasi Ilmuwan Sosial Indonesia menggelar Musyawarah Kerja Nasional (Mukernas) di kampus UPN Veteran Yogyakarta, Sabtu (15/2/2025). Selain membahas berbagai isu terkini terkait sistem informasi Indonesia dan dunia, dalam momen tersebut terpilih Ketua Umum AISINDO 2025-2029 yakni Tony Dwi Susanto Phd. AISINDO berupaya membuat kurikulum untuk prodi sistem informasi agar terstandar internasional dengan kekhasan Indonesia. dan pada hari Minggu (16/2/2025), AISINDO mengadakan kerjasama dalam bentuk penanda tanganan LoI (Letter of Intent) dengan 6 Industri dan 29 perwakilan kampus di seluruh Indonesia salah satunya yaitu Institut Teknologi Kalimantan.',
                'gambar' => 'loi-aisindo.png'
            ],
            [
                'judul' => 'Kuliah Lapangan Mata Kuliah Desain dan Manajemen Jaringan Komputer di UPA TIK ITK',
                'kategori' => 'Akademik',
                'isi_berita' => 'Pada pertemuan hari ini (Kamis, 6 Maret 2025), pembelajaran Mata Kuliah Desain dan Manajemen Jaringan Komputer (khususnya Kelas DMJK - A) dilakukan di UPA TIK ITK, bertujuan agar mahasiswa lebih memahami sistem jaringan IT/komputer secara nyata pada suatu organisasi (kasus di ITK), termasuk pengenalan perangkat-perangkat dan topologi apa yang digunakan pada jaringan IT/komputer di ITK.',
                'gambar' => 'kuliah-lapangan-dmjk.png'
            ],
            [
                'judul' => 'Kelas Kolaborasi Praktisi - Manajemen Layanan Teknologi Informasi (ITSM - A)',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Pada Senin, 5 Mei 2025 ialah sesi perdana Kelas Kolaborasi Praktisi untuk Mata Kuliah Manajemen Layanan Teknologi Informasi (ITSM), khususnya Kelas ITSM - A, diisi oleh Bapak Reza Fahlevi (Senior Risk Management di Tokopedia), dulunya pernah jadi rekan sejawat dari Bapak I Putu Deny Arthawan Sugih Prabowo (Dosen Pengampu Mata Kuliah ITSM) saat masih bekerja di XL Axiata lebih dari 10 tahun lalu. Mahasiswa yang mengambil Mata Kuliah ITSM diharapkan dapat memperoleh banyak manfaat dari "Sharing Session" Bersama Dosen Praktisi ini.',
                'gambar' => 'kelas-praktisi-itsm.png'
            ],
            [
                'judul' => 'INSPACE 2025 OPENING CEREMONY',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => "FSTI Resmi Membuka Rangkaian INSPACE 2025\n\nBalikpapan, 17 Mei 2025 – Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan (ITK) secara resmi membuka rangkaian kegiatan INSPACE (Information System Path to Creativity) 2025 melalui seremoni pembukaan (Opening Ceremony) yang dilaksanakan pada Sabtu, 17 Mei 2025 bertempat di Auditorium Gedung A ITK.\n\nINSPACE 2025 merupakan ajang tahunan berskala nasional yang diselenggarakan oleh Program Studi Sistem Informasi ITK. Kegiatan ini menghadirkan berbagai kompetisi, lomba, hingga talkshow inspiratif yang ditujukan kepada masyarakat umum, khususnya siswa/i SMA sederajat dan mahasiswa/i dari seluruh Indonesia.\n\nOpening Ceremony dibuka secara resmi oleh Dekan FSTI ITK, Bapak Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D., bersama dengan Koordinator Program Studi Sistem Informasi, Ibu Sri Rahayu Natasia, S.Komp., M.Si., M.Sc. Acara ini juga dihadiri oleh segenap civitas akademika ITK, yang mencerminkan antusiasme dan dukungan terhadap terselenggaranya INSPACE sebagai sarana pengembangan kreativitas dan inovasi generasi muda di bidang teknologi informasi.\n\nSejak pertama kali diselenggarakan pada tahun 2020 secara daring akibat pandemi COVID-19, INSPACE telah berkembang menjadi ajang kompetisi prestisius dan mulai dilaksanakan secara luring sejak tahun 2022.\n\nInformasi lebih lanjut mengenai kegiatan INSPACE 2025 dapat diakses melalui situs resmi: https://inspace.itk.ac.id",
                'gambar' => 'opening-inspace-2025.png'
            ],
            [
                'judul' => 'Expo Hasil KP Matematika 2025',
                'kategori' => 'Akademik',
                'isi_berita' => 'Kegiatan berupa pameran hasil Kerja Praktik mahasiswa Matematika yang dilaksanakan dalam periode Desember 2024 - Februari 2025. Kegiatan ini dihadiri oleh berbagai mahasiswa ITK maupun pihak eksternal delegasi dari himpunan Perguruan Tinggi di Balikpapan.',
                'gambar' => 'expo-kp-matematika.png'
            ],
            [
                'judul' => 'Industry Sigth (INSIGHT) 2025',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Industry Sigth (INSIGHT) 2025, merupakan suatu kegiatan kunjungan Mahasiswa Sistem Informasi ITK ke korporat/industri di Balikpapan, yang mana pada kali ini (Jumat, 21 Juni 2025) berkunjung ke IOH (Indosat Ooredoo Hutchison) Balikpapan. Kegiatan ini didamping oleh Bapak Ir. I Putu Deny A. S. P., M.Eng, juga Bapak Henokh Lugo Hariyanto, S.Si., M.Sc. Pihak IOH sangat terbuka menerima Mahasiswa Sistem Informasi ITK atau secara umum, Mahasiswa FSTI ITK untuk magang di IOH Balikpapan.',
                'gambar' => 'insight-ioh.png'
            ],
            [
                'judul' => 'Security and Cloud Essentials for Education and Tech Teams',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Pada Kamis, 24 Juli 2025 di Hotel Bumi, Kota Surabaya, Bapak Ir. I Putu Deny Arthawan Sugih Prabowo, M.Eng. (Dosen FSTI ITK) turut mengisi Acara "Security and Cloud Essentials for Education and Tech Teams" yang diselenggarakan atas Kolaborasi Alibaba Cloud, Indonet, dan AISINDO (Asosiasi Sistem Informasi Indonesia). Pak Deny berkesempatan melakukan inisiasi kerjasama dengan Pihak Indonet dan Alibaba Cloud, terutama terkait kolaborasi dunia akademik dan dunia industri/usaha (DUDI) dalam Tri Dharma Perguruan Tinggi.',
                'gambar' => 'security-cloud-alibaba.png'
            ],
            [
                'judul' => 'Studi Banding dengan Prodi S1 Teknologi Informasi ITS Surabaya',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Pada Jumat, 25 Juli 2025 lalu, Tim Persiapan Program Studi (Prodi) Teknologi Informasi Institut Teknologi Kalimantan melakukan studi banding/benchmarking dengan Departemen Teknologi Informasi Institut Teknologi Sepuluh Nopember Surabaya (ITS) terkait Kurikulum Program Studi Sarjana Teknologi Informasi ITS. Kegiatan benchmarking ini dilakukan secara hybrid oleh Tim Persiapan Prodi Teknologi Informasi ITK serta didampingi oleh Bapak M. Ihsan Alfani Putera S. Tr. Kom, M. Kom. (Ketua JTEIB - FSTI ITK).',
                'gambar' => 'benchmarking-its.png'
            ],
            [
                'judul' => 'Studi Ekskursi Sistem Informasi (SESI)',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Kegiatan Studi Ekskursi Sistem Informasi (SESI) 2025 dilaksanakan oleh Himpunan Mahasiswa Sistem Informasi (HMSI) ITK sebagai bentuk pembelajaran lapangan untuk menambah wawasan mahasiswa mengenai penerapan teknologi informasi di instansi pemerintahan. Dalam kegiatan ini, mahasiswa berkesempatan untuk berkunjung ke Dinas Komunikasi dan Informatika Provinsi Kalimantan Timur serta Command Center Ibu Kota Nusantara (IKN).',
                'gambar' => 'studi-ekskursi-ikn.png'
            ],
            [
                'judul' => 'Promosi Program Pascasarjana ITS',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Dalam rangka menjalin kerja sama akademik dan memperluas jejaring antar perguruan tinggi, Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan (ITK) menerima kunjungan dari tim promosi Pascasarjana Departemen Teknik Elektro, Fakultas Teknologi Elektro dan Informatika Cerdas (FTEIC) Institut Teknologi Sepuluh Nopember (ITS). Kegiatan ini bertujuan untuk memperkenalkan program studi Magister (S2) dan Doktor (S3) yang ada di Departemen Teknik Elektro ITS serta menjajaki potensi kolaborasi dalam bidang pendidikan dan penelitian.',
                'gambar' => 'kunjungan-pascasarjana-its.png'
            ],
            [
                'judul' => 'Seminar Ilmiah Matematika (SEMATIKA) 2025',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Seminar Ilmiah Matematika(SEMATIKA) 2025 merupakan salah satu rangkaian kegiatan dari Math Competition ITK 2025 yang diselenggarakan oleh Himpunan Mahasiswa Matematika Institut Teknologi Kalimantan. Acara ini mengusung tema “From Equations to Reality: Transforming Industries Through Mathematics” dan dilaksanakan pada Minggu, 2 November 2025, bertempat di Auditorium Laboratorium Terpadu ITK. Seminar menghadirkan pemateri inspiratif Alif Hijriah, S.Si., M.Si., Founder Cerebrum.id.',
                'gambar' => 'sematika-matematika.png'
            ],
            [
                'judul' => 'Kuliah Tamu: Kontribusi Ilmu Aktuaria pada Pembiayaan dan Asuransi Risiko Bencana',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Pada tanggal 11 Oktober 2025, Program Studi Ilmu Aktuaria ITK sukses menyelenggarakan kuliah tamu yang membuka wawasan tentang peran besar aktuaria dalam pembiayaan dan mitigasi risiko bencana di Indonesia. Sesi berjalan interaktif melalui diskusi dan tanya jawab. Banyak mahasiswa memperoleh insight baru tentang bagaimana aktuaria dapat berperan dalam meningkatkan ketahanan nasional terhadap bencana.',
                'gambar' => 'kuliah-tamu-parb.png'
            ],
            [
                'judul' => 'ELEVATE 2025 (Electrical Engineering Festival of Technology)',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Pada hari itu dilaksanakan rangkaian lomba Tech Challenge yang diselenggarakan oleh panitia ELEVATE 2025. Tepatnya pada Rabu, 11 November 2025, dua cabang lomba yaitu PLC (Programmable Logic Controller) dan Essay berlangsung di Laboratorium Terpadu 1, Lantai 2, Ruang Bekerja Bersama. Dalam kompetisi tersebut, para siswa SMK dan SMA saling beradu kemampuan untuk meraih gelar juara serta menunjukkan potensi terbaik mereka.',
                'gambar' => 'elevate-tech-challenge.png'
            ],
            [
                'judul' => 'Serah Terima Modul Edukit dan Pojok Literasi di SMK Cendekia',
                'kategori' => 'Pengabdian Masyarakat',
                'isi_berita' => 'Serah terima Modul Edukit yang memuat materi Matematika tingkat SMA/SMK/MA dan Pojok Literasi yang berisi berbagai buku bacaan bermanfaat serta sebagai media ekspresi bagi siswa/i telah berlangsung dengan lancar pada Rabu, 12 November 2025 di SMK Cendekia Balikpapan. Kegiatan ini diharapkan dapat menjadi sarana belajar yang lebih lengkap sekaligus ruang tumbuh bagi kreativitas siswa.',
                'gambar' => 'inovasi-sosial-edukit.png'
            ]
        ];

       $copiedCount = 0;

        // 3. Eksekusi Input ke Database dan Copy File
        foreach ($posts as $data) {
            $category = PostCategory::firstOrCreate(
                ['slug' => Str::slug($data['kategori'])],
                ['name' => $data['kategori']]
            );

            $slug = Str::slug($data['judul']);
            if (Post::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            // Rapikan Format Konten
            $content = '<p style="text-align: justify;">' . str_replace("\n", '</p><p style="text-align: justify;">', $data['isi_berita']) . '</p>';
            $content = str_replace('<p></p>', '', $content);
            $excerpt = Str::limit(strip_tags($content), 150);

            // LOGIKA COPY FILE GAMBAR
            $imageName = $data['gambar'];
            $sourceFile = $assetPostPath . '/' . $imageName;
            $destinationFile = $storagePostPath . '/' . $imageName;

            if (File::exists($sourceFile)) {
                File::copy($sourceFile, $destinationFile);
                $copiedCount++;
            } else {
                $this->command->warn("Peringatan: File Gambar '{$imageName}' tidak ditemukan di database/seeders/assets/posts!");
            }

            Post::create([
                'title' => $data['judul'],
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $content,
                'post_category_id' => $category->id,
                'status' => 'Terbitkan',
                'published_at' => now(),
                'views' => 0,
                'image_path' => 'posts/' . $imageName,
            ]);
        }

        $this->command->info("Selesai! 19 Berita FSTI berhasil di-seed. Total {$copiedCount} gambar disalin ke Storage.");
    }
}
