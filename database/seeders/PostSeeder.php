<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan berita lama agar tidak dobel
        Post::truncate();

        // Data 26 Berita Bersih FSTI yang sudah kita rapikan
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
                'isi_berita' => 'Program Studi Sistem Informasi kembali mengadakan kegiatan rutin semester dalam bentuk Open Talk. Kegiatan ini bertujuan sebagai wadah penyampaian informasi dari prodi kepada civitas akademika terutama dalam mempersiapkan awal semester baru. Kegiatan yang dilaksanakan pada awal Semester Genap Tahun Akademik 2024/2025 ini dibuka oleh Ketua Jurusan Teknik Elektro, Informatika, dan Bisnis, Bapak. M. Ihsan Alfani Putera, STr.Kom., M.Kom, sekaligus memperkenalkan Fakultas FSTI. Selain perkenalan FSTI, terdapat juga beberapa agenda lainnya, yaitu: Sosialisasi Layanan FSTI, Timeline Perkuliahan (KP dan TA), Motivasi Kegiatan MBKM Mandiri, dan Pengumuman Prestasi Mahasiswa Prodi SI.',
                'gambar' => 'open-talk-si.png'
            ],
            [
                'judul' => 'Rapat Koordinasi Akademik dipimpin Ibu WD',
                'kategori' => 'Akademik',
                'isi_berita' => '🔬✨ Menuju Riset Berkualitas dan Berdampak! ✨🔬 Penelitian dan Pengabdian kepada Masyarakat bukan sekadar kewajiban akademik, tetapi juga komitmen untuk menciptakan solusi nyata bagi berbagai permasalahan. 💡📚 Melalui roadmap yang terstruktur, penguatan laboratorium, dan kolaborasi global, kami terus bergerak maju! 🌍🚀 Bersama-sama, kita wujudkan riset yang inovatif dan bermanfaat bagi bangsa! 💪💙',
                'gambar' => 'rapat-riset-fsti.png'
            ],
            [
                'judul' => 'BizTalktive : Sosialisasi & Sharing Session P2MW',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Departemen BUMH Himpunan Mahasiswa Bisnis Digital mengadakan kegiatan BizTalktive: Sosialisasi & Sharing Session P2MW yang bertempat di Gedung E-202 Institut Teknologi Kalimantan. Kegiatan ini bertujuan untuk memberikan pemahaman lebih dalam mengenai Program Pembinaan Mahasiswa Wirausaha (P2MW), mulai dari pemilihan topik yang tepat hingga penyusunan proposal yang sesuai dengan standar penilaian. BizTalktive menjadi wadah bagi mahasiswa Bisnis Digital untuk memperoleh informasi langsung dari mahasiswa yang telah berhasil mendapatkan pendanaan P2MW pada tahun sebelumnya.',
                'gambar' => 'biztalktive-p2mw.png'
            ],
            [
                'judul' => 'MUKERNAS dan Penanda Tanganan LoI dengan AISINDO',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Association for Information System Indonesian Chapter (AISINDO) atau Asosiasi Ilmuwan Sosial Indonesia menggelar Musyawarah Kerja Nasional (Mukernas) di kampus UPN Veteran Yogyakarta, Sabtu (15/2/2025). Selain membahas berbagai isu terkini terkait sistem informasi Indonesia dan dunia, dalam momen tersebut terpilih Ketua Umum AISINDO 2025-2029 yakni Tony Dwi Susanto Phd. AISINDO berupaya membuat kurikulum untuk prodi sistem informasi agar terstandar internasional dengan kekhasan Indonesia. dan pada hari Minggu (16/2/2025), AISINDO mengadakan kerjasama dalam bentuk penanda tanganan LoI (Letter of Intent) dengan 6 Industri dan 29 perwakilan kampus di seluruh Indonesia.',
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
                'isi_berita' => 'Pada Senin, 5 Mei 2025 ialah sesi perdana Kelas Kolaborasi Praktisi untuk Mata Kuliah Manajemen Layanan Teknologi Informasi (ITSM), khususnya Kelas ITSM - A, diisi oleh Bapak Reza Fahlevi (Senior Risk Management di Tokopedia), dulunya pernah jadi rekan sejawat dari Bapak I Putu Deny Arthawan Sugih Prabowo (Dosen Pengampu Mata Kuliah ITSM) saat masih bekerja di XL Axiata lebih dari 10 tahun lalu.',
                'gambar' => 'kelas-praktisi-itsm.png'
            ],
            [
                'judul' => 'INSPACE 2025 OPENING CEREMONY',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Pada Sabtu, 17 Mei 2025, telah dilaksanakan Opening Ceremony dari INSPACE 2025. INSPACE (Information System Path to Creativity) 2025 merupakan rangkaian kegiatan yang berisi berbagai lomba/kompetisi hingga Talkshow di acara puncak (closing ceremony) yang ditujukan kepada masyarakat umum. Opening Ceremony dari INSPACE 2025 dibuka oleh Bapak Adi Mahmud Jaya Marindra, S.T., M.Eng.,Ph.D. (Dekan FSTI ITK) dan Ibu Sri Rahayu Natasia, S.Komp, M.Si., M.Sc. (Koordinator Program Studi Sistem Informasi ITK), serta dihadiri segenap Civitas Akademik ITK.',
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
                'isi_berita' => 'Industry Sigth (INSIGHT) 2025, merupakan suatu kegiatan kunjungan Mahasiswa Sistem Informasi ITK ke korporat/industri di Balikpapan, yang mana pada kali ini (Jumat, 21 Juni 2025) berkunjung ke IOH (Indosat Ooredoo Hutchison) Balikpapan. Pihak IOH sangat terbuka menerima Mahasiswa Sistem Informasi ITK atau secara umum, Mahasiswa FSTI ITK untuk magang di IOH Balikpapan.',
                'gambar' => 'insight-ioh.png'
            ],
            [
                'judul' => 'Security and Cloud Essentials for Education and Tech Teams',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Pada Kamis, 24 Juli 2025 di Hotel Bumi, Kota Surabaya, Bapak Ir. I Putu Deny Arthawan Sugih Prabowo, M.Eng. (Dosen FSTI ITK) turut mengisi Acara "Security and Cloud Essentials for Education and Tech Teams" yang diselenggarakan atas Kolaborasi Alibaba Cloud, Indonet, dan AISINDO (Asosiasi Sistem Informasi Indonesia). Pak Deny berkesempatan melakukan inisiasi kerjasama dengan Pihak Indonet dan Alibaba Cloud.',
                'gambar' => 'security-cloud-alibaba.png'
            ],
            [
                'judul' => 'Studi Banding dengan Prodi S1 Teknologi Informasi ITS Surabaya',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Pada Jumat, 25 Juli 2025 lalu, Tim Persiapan Program Studi (Prodi) Teknologi Informasi Institut Teknologi Kalimantan melakukan studi banding/benchmarking dengan Departemen Teknologi Informasi Institut Teknologi Sepuluh Nopember Surabaya (ITS) terkait Kurikulum Program Studi Sarjana Teknologi Informasi ITS.',
                'gambar' => 'benchmarking-its.png'
            ],
            [
                'judul' => 'Studi Ekskursi Sistem Informasi (SESI)',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Kegiatan Studi Ekskursi Sistem Informasi (SESI) 2025 dilaksanakan oleh Himpunan Mahasiswa Sistem Informasi (HMSI) ITK sebagai bentuk pembelajaran lapangan untuk menambah wawasan mahasiswa mengenai penerapan teknologi informasi di instansi pemerintahan. Dalam kegiatan ini, mahasiswa berkesempatan untuk berkunjung ke Dinas Komunikasi dan Informatika Provinsi Kalimantan Timur serta Command Center Ibu Kota Nusantara (IKN).',
                'gambar' => 'studi-ekskursi-ikn.png'
            ],
            [
                'judul' => 'Kuliah Tamu Infrastruktur Teknologi Informasi di Era 5G',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Kuliah Tamu Program Studi Sistem Informasi, JTEIB, FSTI ITK yang diadakan pada Selasa, 28 Oktober 2025 di Auditorium Lab. Terpadu ITK, mengambil tema "Infrastruktur Teknologi Informasi di Era 5G" dengan berkolaborasi bersama PT. Indosat Ooredoo Hutchison (IOH) Area Kalimantan di Balikpapan.',
                'gambar' => 'kuliah-tamu-indosat.png'
            ],
            [
                'judul' => 'Promosi Program Pascasarjana ITS',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Dalam rangka menjalin kerja sama akademik dan memperluas jejaring antar perguruan tinggi, Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan (ITK) menerima kunjungan dari tim promosi Pascasarjana Departemen Teknik Elektro, Fakultas Teknologi Elektro dan Informatika Cerdas (FTEIC) Institut Teknologi Sepuluh Nopember (ITS).',
                'gambar' => 'kunjungan-pascasarjana-its.png'
            ],
            [
                'judul' => 'Olimpiade Matematika dan Lomba Math Competition 2025',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Babak Final Lomba Media Kreasi dan Inovasi (LINES) serta Olimpiade Matematika (OPTIK) Math Competition 2025 telah sukses diselenggarakan! Para finalis dari berbagai sekolah dan perguruan tinggi se-Kalimantan menampilkan kemampuan terbaik mereka, mulai dari kreativitas dalam kategori Poster dan Videografi di LINES, hingga ketelitian dan strategi dalam menyelesaikan soal-soal Olimpiade Matematika jenjang SMP dan SMA.',
                'gambar' => 'optik-lines-sukses.png'
            ],
            [
                'judul' => 'Seminar Ilmiah Matematika (SEMATIKA) 2025',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Seminar Ilmiah Matematika(SEMATIKA) 2025 merupakan salah satu rangkaian kegiatan dari Math Competition ITK 2025 yang diselenggarakan oleh Himpunan Mahasiswa Matematika Institut Teknologi Kalimantan. Acara ini mengusung tema "From Equations to Reality: Transforming Industries Through Mathematics" dan dilaksanakan pada Minggu, 2 November 2025, bertempat di Auditorium Laboratorium Terpadu ITK.',
                'gambar' => 'sematika-matematika.png'
            ],
            [
                'judul' => 'Kuliah Tamu: Motivasi Menjadi Aktuaris dan Pemahaman Pricing',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Program Studi Ilmu Aktuaria Institut Teknologi Kalimantan (ITK) menyelenggarakan Kuliah Tamu Ilmu Aktuaria 2025 bertajuk "Motivasi Menjadi Aktuaris dan Pemahaman Pricing serta Reserve di Industri Asuransi" pada Sabtu, 25 Oktober 2025, di Auditorium Gedung A ITK.',
                'gambar' => 'kuliah-tamu-aktuaris.png'
            ],
            [
                'judul' => 'Kuliah Tamu: Kontribusi Ilmu Aktuaria pada Pembiayaan dan Asuransi Risiko Bencana',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Pada tanggal 11 Oktober 2025, Program Studi Ilmu Aktuaria ITK sukses menyelenggarakan kuliah tamu yang membuka wawasan tentang peran besar aktuaria dalam pembiayaan dan mitigasi risiko bencana di Indonesia. Sesi berjalan interaktif melalui diskusi dan tanya jawab.',
                'gambar' => 'kuliah-tamu-parb.png'
            ],
            [
                'judul' => 'ELEVATE 2025 (Electrical Engineering Festival of Technology)',
                'kategori' => 'Kegiatan Mahasiswa',
                'isi_berita' => 'Pada hari itu dilaksanakan rangkaian lomba Tech Challenge yang diselenggarakan oleh panitia ELEVATE 2025. Tepatnya pada Rabu, 11 November 2025, dua cabang lomba yaitu PLC (Programmable Logic Controller) dan Essay berlangsung di Laboratorium Terpadu 1, Lantai 2, Ruang Bekerja Bersama.',
                'gambar' => 'elevate-tech-challenge.png'
            ],
            [
                'judul' => 'FSTI ITK Online Guest Lecture 2025',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Kegiatan FSTI ITK Online Guest Lecture 2025 dilaksanakan secara daring melalui platform Zoom pada hari Sabtu, 8 November 2025 pukul 08.00–11.20 WITA. Acara dibuka oleh MC dan dilanjutkan dengan sambutan, kemudian masuk ke sesi utama berupa penyampaian materi oleh Randy Budi Wicaksono, S.Si., M.Sc., CEO Ravelware Technology.',
                'gambar' => 'guest-lecture-aiot.png'
            ],
            [
                'judul' => 'Serah Terima Modul Edukit dan Pojok Literasi di SMK Cendekia',
                'kategori' => 'Pengabdian Masyarakat',
                'isi_berita' => 'Serah terima Modul Edukit yang memuat materi Matematika tingkat SMA/SMK/MA dan Pojok Literasi yang berisi berbagai buku bacaan bermanfaat serta sebagai media ekspresi bagi siswa/i telah berlangsung dengan lancar pada Rabu, 12 November 2025 di SMK Cendekia Balikpapan. Kegiatan ini diharapkan dapat menjadi sarana belajar yang lebih lengkap sekaligus ruang tumbuh bagi kreativitas siswa.',
                'gambar' => 'inovasi-sosial-edukit.png'
            ],
            [
                'judul' => 'Sosialisasi Akademik & Sharing Session 2025',
                'kategori' => 'Akademik',
                'isi_berita' => 'Program Studi Statistika Institut Teknologi Kalimantan telah menyelenggarakan kegiatan Sosialisasi Akademik & Sharing Session pada Kamis, 30 Oktober 2025 bertempat di Auditorium Gedung A ITK. kegiatan ini membahas informasi penting seputar dunia perkuliahan mulai dari Kerja Praktek, Magang, Inovasi Sosial, Layanan FSTI dan berbagai informasi lainnya.',
                'gambar' => 'sosialisasi-akademik-statistika.png'
            ],
            [
                'judul' => 'Kuliah Tamu Statistika ITK',
                'kategori' => 'Kuliah Tamu & Seminar',
                'isi_berita' => 'Program Studi Statistika Institut Teknologi Kalimantan telah menyelenggarakan kegiatan Kuliah Tamu Statistika ITK dengan tema "Peran Strategis Analisis Data Statistik dalam Optimalisasi Operasional dan Pelayanan di Industri Maritim". Kegiatan ini menghadirkan Ibu Ratu Sawitri, S.Si.',
                'gambar' => 'kuliah-tamu-maritim.png'
            ],
            [
                'judul' => 'Focus Group Discussion (FGD) dengan Mitra Prodi Statistika',
                'kategori' => 'Kerja Sama & Kemitraan',
                'isi_berita' => 'Program Studi Statistika ITK melaksanakan Focus Group Discussion (FGD) bersama mitra dengan tema "Kolaborasi Strategis untuk Penguatan Kompetensi dan Daya Saing Mahasiswa Statistika ITK." Kegiatan ini menjadi ruang penting untuk memperoleh masukan terkait kualitas mahasiswa dalam pelaksanaan Kerja Praktik, magang, hingga inovasi sosial.',
                'gambar' => 'fgd-mitra-statistika.png'
            ]
        ];

        // Looping untuk memasukkan data ke Database
        foreach ($posts as $data) {
            // 1. Buat/Cari Kategori
            $category = PostCategory::firstOrCreate(
                ['slug' => Str::slug($data['kategori'])],
                ['name' => $data['kategori']]
            );

            // 2. Buat Slug Judul
            $slug = Str::slug($data['judul']);
            if (Post::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . uniqid();
            }

            // 3. Rapikan Format Konten
            $content = '<p>' . str_replace("\n", '</p><p>', $data['isi_berita']) . '</p>';
            $excerpt = Str::limit($data['isi_berita'], 150);

            // 4. Masukkan ke tabel posts
            Post::create([
                'title' => $data['judul'],
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $content,
                'post_category_id' => $category->id,
                'status' => 'Terbitkan',
                'published_at' => now(),
                'views' => rand(15, 250),
                'image_path' => 'posts/' . $data['gambar'], // Menghubungkan ke folder gambar
            ]);
        }

        $this->command->info('26 Berita FSTI beserta gambarnya berhasil di-seed langsung ke Database!');
    }
}
