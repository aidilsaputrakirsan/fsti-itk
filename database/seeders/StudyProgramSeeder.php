<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyProgram;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class StudyProgramSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        StudyProgram::truncate();
        Schema::enableForeignKeyConstraints();

        $assetPath = database_path('seeders' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'study_programs');

        if (!Storage::disk('public')->exists('study_programs')) {
            Storage::disk('public')->makeDirectory('study_programs');
        }

        $existingFiles = Storage::disk('public')->files('study_programs');
        foreach ($existingFiles as $file) {
            Storage::disk('public')->delete($file);
        }

        $prodiData = [
            [
                'name' => 'Matematika',
                'department' => 'Sains dan Analitika Data',
                'degree' => 'S1',
                'slug' => 's1-matematika',
                'description' => 'Program Studi Matematika Institut Teknologi Kalimantan (ITK), yang berdiri sejak 2015 dan telah terakreditasi Baik oleh LAMSAMA (2023), berfokus pada pengembangan kemampuan analisis matematis dan penerapannya di berbagai bidang. Mahasiswa dibekali keterampilan pemrograman dan software serta dapat memilih empat bidang minat, yaitu analisis, aljabar, matematika industri, serta simulasi dan komputasi matematika. Lulusan diharapkan mampu berkontribusi di sektor sains, teknologi, industri, hingga pendidikan, serta memiliki karakter beriman, berakhlak, dan berjiwa nasionalisme.',
                'vision' => 'Program Studi Matematika menjadi pusat pengembangan keilmuan Matematika dalam bidang industri dan lingkungan di Kalimantan Timur pada tahun 2035 melalui pemberdayaan potensi daerah',
                'mission' => [
                    'Menyelenggarakan pendidikan matematika yang berkualitas untuk menghasilkan lulusan yang berkompeten, sesuai kebutuhan pasar, siap melanjutkan pendidikan ke jenjang yang lebih tinggi, serta mampu memberikan sumbangsih bagi pembangunan nasional.',
                    'Meningkatkan kegiatan penelitian matematika di bidang industri dan lingkungan sehingga mampu menjadi pusat pengembangan keilmuan matematika di Kalimantan Timur.',
                    'Menerapkan ilmu matematika dan terapannya sebagai solusi masalah masyarakat dalam rangka pengabdian kepada masyarakat.',
                    'Menjalin kerjasama dengan perguruan tinggi lain, industri, masyarakat, dan pemerintah.'
                ],
                'goals' => 'Menjadi wadah pengembangan keilmuan matematika dan proses pembelajaran yang berkualitas untuk meningkatkan kompetensi mahasiswa matematika sehingga menghasilkan sarjana yang mampu memahami sepenuhnya konsep dasar matematika, serta beretos kerja tinggi dalam berkarya dan berkontribusi.',
                'graduate_profiles' => [
                    'Data Analyst',
                    'Data Scientist',
                    'Praktisi Industri dan Pemerintahan',
                    'Akademisi dan Peneliti',
                    'Business Analyst',
                    'Aktuaris',
                    'Konsultan',
                    'Analisis Keuangan'
                ],
                'accreditation_certificate_image' => 'akreditasi_matematika.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Matematika-2023-2028.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Lembaga Akreditasi Mandiri Sains Alam dan Ilmu Formal (LAMSAMA) dengan peringkat Baik.',
                'website_link' => 'https://math.itk.ac.id/'
            ],
            [
                'name' => 'Ilmu Aktuaria',
                'department' => 'Sains dan Analitika Data',
                'degree' => 'S1',
                'slug' => 's1-ilmu-aktuaria',
                'description' => 'Program Studi Ilmu Aktuaria mempelajari analisis dan pengukuran dampak finansial dari kejadian tidak pasti di masa depan, khususnya dalam industri asuransi, keuangan, dan bidang terkait, melalui penerapan matematika, probabilitas, dan statistika. Mahasiswa dibekali pengetahuan terintegrasi yang mencakup matematika terapan, keuangan, ekonomi, dan komputasi untuk menentukan nilai kewajiban masa depan secara tepat. Lulusan diharapkan menjadi aktuaris yang mampu menyusun strategi dan mendukung pengambilan keputusan berbasis risiko di berbagai sektor industri.',
                'vision' => 'Menjadi program studi ilmu aktuaria yang unggul dan berperan aktif dalam pengembangan ilmu aktuaria melalui pemberdayaan potensi daerah Kalimantan Timur pada tahun 2035',
                'mission' => [
                    'Menyelenggarakan pendidikan aktuaria yang berkualitas untuk menghasilkan lulusan yang sesuai dengan kebutuhan pasar dan siap melanjutkan pendidikan ke jenjang yang lebih tinggi.',
                    'Meningkatkan kegiatan penelitian di bidang ilmu aktuaria terutama pengelolaan risiko di bidang kelestarian lingkungan.',
                    'Menerapkan ilmu aktuaria sebagai solusi masalah masyarakat dalam rangka pengabdian masyarakat.',
                    'Menjalin kerja sama dengan persatuan aktuaris indonesia, perguruan tinggi lain, industri keuangan, masyarakat, dan pemerintah.'
                ],
                'goals' => null,
                'graduate_profiles' => [
                    'Aktuaris',
                    'Analisis Risiko',
                    'Analisis Data',
                    'Banker',
                    'Pengelola Investasi',
                    'Praktisi Dana Pensiun',
                    'Praktisi Social Care',
                    'Lembaga Pemerintahan'
                ],
                'accreditation_certificate_image' => 'akreditasi_aktuaria.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Ilmu-Aktuaria-2022-2027.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT) dengan peringkat Baik.',
                'website_link' => 'https://actsci.itk.ac.id/'
            ],
            [
                'name' => 'Statistika',
                'department' => 'Sains dan Analitika Data',
                'degree' => 'S1',
                'slug' => 's1-statistika',
                'description' => 'Program Studi Statistika ITK berkomitmen menghasilkan lulusan yang kompeten dalam analisis statistik dan pengolahan big data melalui kurikulum yang berfokus pada manajemen data dan komputasi. Pembelajaran dirancang selaras dengan perkembangan teknologi sehingga lulusan memiliki keterampilan yang relevan dengan kebutuhan zaman. Dengan kompetensi tersebut, lulusan memiliki peluang karier luas di sektor pemerintah, pendidikan, bisnis, dan industri.',
                'vision' => 'Menjadi program studi yang menghasilkan karya unggul dalam pendidikan dan penerapan statistika serta berperan aktif dalam pengembangan potensi daerah Kalimantan, khususnya di bidang ekologi, energi, dan smart city ada tahun 2035.',
                'mission' => [
                    'Menyelenggarakan proses pendidikan tinggi yang unggul dan berbasis pada pengembangan keilmuan statistika dan terapannya melalui kerangka merdeka belajar.',
                    'Berperan aktif dalam menghasilkan karya penelitian dan pengabdian kepada masyarakat sebagai upaya untuk memperkaya serta memperkuat ilmu pengetahuan dan teknologi.',
                    'Membangun relasi dan kerjasama yang baik dengan berbagai sektor industri dan pemerintah dalam pengembangan statistika, khususnya di bidang ekologi, energi, dan smart city.'
                ],
                'goals' => "1. Menyelenggarakan pendidikan tinggi yang unggul dan berkualitas sehingga menghasilkan lulusan yang profesional dan memiliki daya saing.\n2. Menerapkan dan mengembangkan keilmuan statistika melalui kegiatan penelitian.\n3. Berkontirbusi dalam pengabdian kepada masyarakat.",
                'graduate_profiles' => [
                    'Data Scientist',
                    'Data Analyst',
                    'Konsultan Riset'
                ],
                'accreditation_certificate_image' => 'akreditasi_statistika.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Statistika-2022-2027.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT) dengan peringkat Baik.',
                'website_link' => 'https://stat.itk.ac.id/'
            ],
            [
                'name' => 'Fisika',
                'department' => 'Sains dan Analitika Data',
                'degree' => 'S1',
                'slug' => 's1-fisika',
                'description' => 'Program Studi Fisika membekali mahasiswa dengan pemahaman konsep teoritis serta kemampuan analisis terhadap gejala dan permasalahan fisis melalui observasi dan eksperimen. Mahasiswa dilatih untuk memprediksi dan mengembangkan penerapan ilmu fisika dalam teknologi. Lulusan memiliki peluang karier luas di sektor pemerintahan maupun industri, baik di perusahaan negara maupun swasta.',
                'vision' => 'Menjadi lembaga pendidikan dan pengembangan fisika yang unggul serta berkontribusi terhadap ilmu pengetahuan dan teknologi berbasis pada potensi sumber daya Kalimantan.',
                'mission' => [
                    'Menyelenggarakan pendidikan sarjana Fisika berbasis penguasaan ilmu pengetahuan dan teknologi guna menghasilkan lulusan yang unggul.',
                    'Melaksanakan pengembangan Fisika serta aplikasinya yang berbasis pada potensi sumber daya Kalimantan.',
                    'Melaksanakan pengabdian kepada masyarakat sebagai implementasi hasil Pendidikan dan penelitian berbasis keilmuan Fisika.'
                ],
                'goals' => "1. Menyelenggarakan pendidikan dan pengajaran yang efektif sekaligus akuntabel yang mendukung pada peningkatan kemampuan akademik mahasiswa,\n2. Menghasilkan lulusan yang memiliki daya saing sesuai dengan kebutuhan nasional,\n3. Mengembangkan soft skill dan kepemimpinan mahasiswa,\n4. Mengembangkan kegiatan penelitian yang aplikatif, sesuai dengan potensi sumber daya daerah kalimantan,\n5. Melaksanakan kegiatan pengabdian masyarakat berbasis potensi daerah untuk meningkatkan kesejahteraan masyarakat,\n6. Mengembangkan kemitraan dengan perguruan tinggi lain, pemerintah daerah, dan instansi lain untuk mendukung kegiatan penelitian dan pengabdian masyarakat.",
                'graduate_profiles' => [
                    'Data Analyst',
                    'Data Scientist',
                    'Laboran',
                    'Fisikawan Medis',
                    'Entrepreneur',
                    'Jurnalis',
                    'Software Developer',
                    'Ahli Semikonduktor & Elektronika',
                    'Geofisikawan'
                ],
                'accreditation_certificate_image' => 'akreditasi_fisika.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Fisika-2023-2028.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Lembaga Akreditasi Mandiri Sains Alam dan Ilmu Formal (LAMSAMA) dengan peringkat Baik Sekali.',
                'website_link' => 'https://phy.itk.ac.id/'
            ],
            [
                'name' => 'Teknik Informatika',
                'department' => 'Teknik Elektro, Informatika, dan Bisnis',
                'degree' => 'S1',
                'slug' => 's1-teknik-informatika',
                'description' => 'Program Studi Informatika ITK berfokus pada pengembangan kompetensi dasar informatika serta keahlian pemrograman yang kuat untuk mendukung perancangan dan pengembangan sistem berbasis komputer. Mahasiswa dibekali kemampuan dalam menganalisis, mengevaluasi, serta mengimplementasikan solusi teknologi informasi yang adaptif terhadap kebutuhan industri. Dengan bekal tersebut, lulusan diharapkan mampu berkontribusi dalam pengembangan sistem digital yang inovatif dan relevan di berbagai sektor.',
                'vision' => 'Menjadi program studi unggul di bidang Informatika yang inovatif dan kreatif dalam poros Kalimantan pada tahun 2025',
                'mission' => [
                    'Menyelenggarakan sistem pendidikan yang efektif, efisien, dan berkelanjutan dalam rangka menghasilkan lulusan sarjana Informatika.',
                    'Menghasilkan lulusan yang memiliki kompetensi di bidang Informatika, berjiwa wirausaha (entrepreneur) dan dapat berperan positif di tingkat nasional dan internasional (world class).',
                    'Meningkatkan kontribusi dan kolaborasi dengan berbagai pihak dalam masyarakat dengan mengembangkan produk dan layanan dalam bidang Informatika di tingkat regional, nasional maupun internasional.'
                ],
                'goals' => "1. Menghasilkan lulusan yang memiliki kompetensi di bidang Informatika, berjiwa wirausaha dan dapat dipercaya sehingga mampu bekerja sama dan memberikan kontribusi di tingkat nasional maupun internasional.\n2. Menjalankan sistem pendidikan dengan penjaminan mutu sesuai standar nasional dan internasional.\n3. Melibatkan civitas academica dalam penelitian yang memperkaya keilmuan di bidang komputasi.\n4. Melibatkan civitas academica dalam pengabdian masyarakat.\n5. Meningkatkan kontribusi dan kolaborasi dengan mengembangkan inovasi.\n6. Mengembangkan sertifikasi kompetensi di bidang Informatika.",
                'graduate_profiles' => [
                    'Software Engineer',
                    'Digital Entrepreneur',
                    'Artificial Intelligence Engineer',
                    'Computer Scientist',
                    'Data Scientist'
                ],
                'accreditation_certificate_image' => 'akreditasi_informatika.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Informatika-2024-2029.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Lembaga Akreditasi Mandiri Informatika dan Komputer (LAMINFOKOM) dengan peringkat Baik Sekali.',
                'website_link' => 'https://if.itk.ac.id/'
            ],
            [
                'name' => 'Sistem Informasi',
                'department' => 'Teknik Elektro, Informatika, dan Bisnis',
                'degree' => 'S1',
                'slug' => 's1-sistem-informasi',
                'description' => 'Program Studi Sistem Informasi ITK berfokus pada pengembangan keahlian dalam analisis kebutuhan, proses bisnis, serta perancangan dan implementasi sistem informasi untuk meningkatkan kinerja organisasi melalui pemanfaatan teknologi. Pembelajaran menitikberatkan pada aspek Organizational Issues & Information Systems serta Application Deployment Configuration, sehingga lulusan mampu menjembatani kebutuhan bisnis dengan solusi teknologi yang efektif dan adaptif di berbagai sektor.',
                'vision' => 'Visi keilmuan Program Studi adalah menjadi Program Studi Sistem Informasi yang unggul di Indonesia pada tahun 2040 dalam mengintegrasikan ilmu pengetahuan, teknologi informasi, dan praktik bisnis untuk menciptakan solusi inovatif dalam tata kelola organisasi dan transformasi digital khususnya bidang pemerintahan.',
                'mission' => [
                    'Menyelenggarakan pendidikan tinggi dalam bidang Sistem Informasi untuk menghasilkan lulusan yang diakui di tingkat nasional dan internasional.',
                    'Menyelenggarakan penelitian yang inovatif dan kreatif untuk pengembangan Sistem Informasi.',
                    'Menyelenggarakan kegiatan pelayanan kepada masyarakat yang berhubungan dengan Sistem Informasi.',
                    'Membangun kerjasama dengan lembaga pemerintahan dan industri dalam bidang Sistem Informasi.'
                ],
                'goals' => null,
                'graduate_profiles' => [
                    'Information System Engineer',
                    'IT Governance Engineer',
                    'IT Project Manager'
                ],
                'accreditation_certificate_image' => 'akreditasi_sisteminformasi.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Sistem-Informasi-2023-2028.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Lembaga Akreditasi Mandiri Informatika dan Komputer (LAMINFOKOM) dengan peringkat Baik Sekali.',
                'website_link' => 'https://is.itk.ac.id/'
            ],
            [
                'name' => 'Bisnis Digital',
                'department' => 'Teknik Elektro, Informatika, dan Bisnis',
                'degree' => 'S1',
                'slug' => 's1-bisnis-digital',
                'description' => 'Program Studi Bisnis Digital mengintegrasikan keilmuan bisnis dan teknologi untuk menyiapkan sumber daya manusia yang adaptif di era industri 4.0. Pembelajaran dirancang untuk mengembangkan kemampuan analisis bisnis, pemanfaatan teknologi digital, serta inovasi dalam pengembangan usaha. Lulusan diproyeksikan berkarier sebagai entrepreneur, pemasar digital, konsultan bisnis, pengembang bisnis, hingga data analis di berbagai sektor industri.',
                'vision' => 'Menjadi Program Studi Bisnis Digital yang terkemuka di Indonesia 2040 dalam memajukan ilmu pengetahuan, penelitian, dan pengabdian masyarakat dalam menghadapi tantangan global.',
                'mission' => [
                    'Menyelenggarakan pendidikan tinggi pada bidang Bisnis Digital berbasis ilmu pengetahuan dan teknologi untuk menghasilkan lulusan yang diakui di tingkat nasional dan internasional.',
                    'Menyelenggarakan penelitian dalam rangka pengembangan ilmu pengetahuan dan teknologi dalam pemanfaatan potensi daerah dibidang Bisnis Digital.',
                    'Menyelenggarakan kegiatan pengabdian kepada masyarakat yang berkaitan dengan penerapan keilmuan Bisnis Digital.',
                    'Menjalin kerjasama dengan lembaga pemerintahan dan industri yang berkaitan dengan bidang Bisnis Digital.'
                ],
                'goals' => null,
                'graduate_profiles' => [
                    'Wirausaha',
                    'Konsultan Bisnis',
                    'Pemasar Digital',
                    'Analisis Data',
                    'Pengembangan Bisnis Digital'
                ],
                'accreditation_certificate_image' => 'akreditasi_bisdig.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Bisnis-Digital-2024-2029.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Perkumpulan Lembaga Akreditasi Mandiri Ekonomi Manajemen Bisnis dan Akuntansi (LAMEMBA) dengan peringkat Baik.',
                'website_link' => 'https://bisnisdigital.itk.ac.id/'
            ],
            [
                'name' => 'Teknik Elektro',
                'department' => 'Teknik Elektro, Informatika, dan Bisnis',
                'degree' => 'S1',
                'slug' => 's1-teknik-elektro',
                'description' => 'Program Studi Teknik Elektro Institut Teknologi Kalimantan (ITK) berfokus pada penguasaan ilmu listrik, elektronika, dan elektromagnetisme dalam perancangan, pengembangan, serta implementasi sistem dan perangkat teknologi. Mahasiswa dibekali dasar kuat matematika, fisika, dan komputasi melalui pembelajaran seperti sistem kontrol, komunikasi, mikroprosesor, teknik daya, serta teknologi terkini seperti energi terbarukan, robotika, dan kecerdasan buatan. Lulusan diharapkan mampu berpikir kritis, kreatif, dan bekerja dalam tim, serta berkarier di berbagai bidang seperti rekayasa perangkat keras, sistem kontrol, jaringan, teknologi informasi, hingga riset dan pengembangan teknologi.',
                'vision' => null,
                'mission' => null,
                'goals' => null,
                'graduate_profiles' => [
                    'Insinyur di bidang teknik elektro and bidang yang relevan',
                    'Ilmuwan, Peneliti, Guru/Dosen',
                    'Pegawai/Staf Pemerintah dan Tokoh Masyarakat',
                    'Pengusaha'
                ],
                'accreditation_certificate_image' => 'akreditasi_elektro.webp',
                'accreditation_pdf_link' => 'https://ult.itk.ac.id/wp-content/uploads/2024/09/Sertifikat-Akreditasi-Program-Studi-Teknik-Elektro-2023-2027.pdf',
                'accreditation_text' => 'Telah terakreditasi oleh Lembaga Akreditasi Mandiri Program Studi Keteknikan (LAM Teknik) dengan peringkat Baik Sekali.',
                'website_link' => 'https://ee.itk.ac.id/'
            ],
            [
                'name' => 'Magister Manajemen Teknologi',
                'department' => 'Teknik Elektro, Informatika, dan Bisnis',
                'degree' => 'S2',
                'slug' => 's2-magister-manajemen-teknologi',
                'description' => 'Program Magister Manajemen Teknologi (MMT) Institut Teknologi Kalimantan (ITK) dirancang untuk mengintegrasikan keilmuan manajemen strategis dan teknologi guna menjawab tantangan industri modern. Program ini membekali mahasiswa dengan kemampuan dalam pengelolaan inovasi, strategi teknologi, serta pengambilan keputusan berbasis data melalui pendekatan interdisipliner. Lulusan dipersiapkan menjadi pemimpin yang adaptif dan inovatif dalam menghadapi transformasi digital di berbagai sektor industri.',
                'vision' => null,
                'mission' => null,
                'goals' => null,
                'graduate_profiles' => [
                    'Manajer Proyek',
                    'Manajer Industri',
                    'Konsultan',
                    'Entrepreneur',
                    'Peneliti dan Akademisi'
                ],
                'accreditation_certificate_image' => null,
                'accreditation_pdf_link' => null,
                'accreditation_text' => 'Telah terakreditasi oleh Lembaga Akreditasi Mandiri Program Studi Keteknikan (LAM Teknik) dengan peringkat Baik.',
                'website_link' => null
            ]
        ];

        $copiedCount = 0;

        foreach ($prodiData as $data) {
            $imagePath = null;

            if (!empty($data['accreditation_certificate_image'])) {
                $imageName = $data['accreditation_certificate_image'];
                $sourceFile = $assetPath . DIRECTORY_SEPARATOR . $imageName;

                if (File::exists($sourceFile)) {
                    Storage::disk('public')->put('study_programs/' . $imageName, File::get($sourceFile));
                    $imagePath = 'study_programs/' . $imageName;
                    $copiedCount++;
                } else {
                    $this->command->warn("Peringatan: File Gambar '{$imageName}' tidak ditemukan di folder assets/study_programs!");
                }
            }

            $data['accreditation_certificate_image'] = $imagePath;

            StudyProgram::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $this->command->info("Selesai! 9 Program Studi FSTI berhasil di-seed. Total {$copiedCount} sertifikat akreditasi disalin ke folder storage/study_programs.");
    }
}
