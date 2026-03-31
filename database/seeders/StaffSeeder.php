<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $dataCivitas = [

            [
                'name' => 'Deli Yansyah, S.E., M.Acc., Ak., CA',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Bisnis Digital',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1fcSC34fYPMNDO-hJn_Q2wOrh7O7R72vi/view?usp=sharing',

                'education_history' => [
                    'S1 Akuntansi Universitas Islam Indonesia',
                    'S2 Magister Akuntansi Universitas Gadjah Mada'
                ],

                'expertise' => [
                    'Auditing',
                    'Financial Accounting'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2021 - Sekarang : Digital Business Lecturer- ITK',
                    '2016 - 2019 : Accounting Supervisor. PT Aqieni',
                    '2013 - 2016 : Accounting Staf. PT Aqieni'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Agung Prabowo, S.E., M.M.',
                'nip' => '199311302022031006',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1NbeBK-Hz_3wqzY_rfc70sSzk1pPQP9bn/view?usp=sharing',

                'education_history' => [
                    'S1 Manajemen Universitas Sebelas Maret',
                    'S2 Magister Manajemen Universitas Sebelas Maret'
                ],

                'expertise' => [
                    'Manajemen',
                    'Pemasaran',
                    'Perilaku Konsumen',
                    'Investasi'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    'Mill Improvement Staff, PT. Indah Kiat Pulp and Paper, Tbk'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Bayu Nur Abdallah, S.T., M.T., CSCA.',
                'nip' => '100118160',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1eO0jki-zodaY6O2xNopKogSQwklgmGHu/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Industri, Universitas Brawijaya',
                    'S2 Teknik Industri, Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Digital Behaviour',
                    'Logistics Systems',
                    'Strategic Supply Chain Management',
                    'Market Research'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Consumer Behaviour'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2021 – Sekarang: Dosen Universitas (Full-time), Departemen Bisnis Digital',
                    '2019 – Sekarang: Business Analyst (Kontrak), Balikpapan, Kalimantan Timur, Indonesia',
                    '2021 – 2022: Digital Marketing Mentor (Kontrak), HashMicro, Jakarta, Indonesia',
                    '2019 – 2021: Kepala Laboratorium Industrial System Engineering (Kontrak)',
                    '2019 – 2020: Assistant Manager, Technology Business Incubator, Institut Teknologi Kalimantan',
                    '2017 – 2017: Management Intern, PT ITS Tekno Sains',
                    '2010 – 2012: Marketing Communication, Korek Api Ads, Malang'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Eka Krisna Santoso, S.Si, MBA',
                'nip' => '198607082022031002',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1vy1kGPyttz-tj0rS9JINzchQoJFJgL55/view?usp=sharing',

                'education_history' => [
                    'S.Si - Mathematics Department, Gadjah Mada University',
                    'MBA - Ohio, The University of Akron'
                ],

                'expertise' => [
                    'UMKM / Small Medium Enterprise',
                    'Fair Value Analysis',
                    'Goal Setting',
                    'Financial Planning',
                    'Feasibility Study',
                    'Design Thinking',
                    'Sales Management'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2025 – Sekarang: Dosen, Departemen Bisnis Digital, Fakultas Sains dan Teknologi Informasi, Institut Teknologi Kalimantan, Balikpapan, Indonesia',
                    '2024 – Sekarang: Equity Research Analyst, Freelance, Indonesia',
                    '2020 – 2025: Dosen, Departemen Aktuaria, Fakultas Sains dan Teknologi Informasi, Institut Teknologi Kalimantan, Balikpapan, Indonesia',
                    '2019 – 2020: Technical Student Assistant, The University of Akron, Cleveland/Akron, Ohio, USA',
                    '2018 – 2019: Student Assistant, The University of Akron, Cleveland/Akron, Ohio, USA',
                    '2018 – 2019: Venture Fund Student Analyst, Northeast Ohio Student Venture Fund, Cleveland/Akron, Ohio, USA',
                    '2015: Head of Sales Division, CV Azra Sentosa Jaya, Balikpapan, Indonesia',
                    '2013 – 2018: Senior Relationship Manager, Sub Branch Manager, Branch Change Agent Ambassador, Business Development Manager – Funding & Wealth Management, PT Bank Muamalat Indonesia Tbk, Balikpapan & Tanah Grogot, Indonesia',
                    '2010 – 2013: Business Development Representative, Customer Service Representative, PT Bank Mandiri (Persero) Tbk, Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Ir. Riovan Styx Roring, S.T., M.Kom',
                'nip' => '199107172025061001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1g-cw7c_CYpCPtvyqLEa9EzoITFPDkuSu/view?usp=sharing',

                'education_history' => [
                    'S2 Teknik Informatika'
                ],

                'expertise' => [
                    'Software Engineering'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Implementasi Failover Di Layer 2 Dengan Spanning Tree Protokol Dalam Mengatasi Terputusnya Jaringan Informasi Ke Gardu Induk Pln Untuk Menghindari Pemadaman Listrik Masal',
                    'Implementasi Sistem Smart Attendance Berbasis Android Menggunakan Quick Response Code',
                    'Penerapan Aplikasi Android “Ojek Gt” Sebagai Startup Industri Kreatif Menuju Society 5.0',
                    'Implementasi Dan Evaluasi Algoritma C5.0 Pada Klasifikasi Emosi Teks Berita Berbahasa Indonesia.'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2025 – Sekarang: Dosen, Institut Teknologi Kalimantan',
                    '2024 – 2025: Dosen, Universitas Balikpapan',
                    '2023 – 2024: Dosen, Universitas Mulia',
                    '2022 – 2023: Dosen, Jakarta International University',
                    '2017 – 2025: CEO, CV. Hosting Rakyat Media',
                    '2015 – 2021: Dosen, Universitas Mulia (STMIK STIKOM Balikpapan)',
                    '2013 – 2015: Trainer Assistant, PT Indosafe Pratama',
                    '2012 – 2013: IT Staff, Surya Gemilang Utama',
                    '2011 – 2012: IT Staff, Universitas Sariputra Indonesia Tomohon',
                    '2007 – 2008: Accounting Intern, Bank Pembangunan Daerah Suluttenggo Cabang Kawangkoan',
                    '2007 – 2008: Finance Intern, Sekretariat Daerah Pemprov Sulawesi Utara'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/riovan-roring/',
                    'https://scholar.google.com/citations?user=D6OC_TEAAAAJ',
                    'https://www.scopus.com/authid/detail.uri?authorId=57657581900'
                ]
            ],

            [
                'name' => 'Fegy Sukris Sri Andriany, M.Ak.',
                'nip' => '199702202025062007',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1kmBhGD44OsTzlZO5JQ65g7V5Z8YrIByE/view?usp=sharing',

                'education_history' => [
                    'S2 Akuntansi'
                ],

                'expertise' => [
                    'Akuntansi Pajak',
                    'Akuntansi Keuangan',
                    'Audit'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    'Auditor, Kantor Akuntan Publik'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Khairunnisa Rahmah, S.E., M.M., CDMS',
                'nip' => '199310132022032006',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1Td1n3tio23suC5zTx3zqwMPqzGI1aV2H/view?usp=sharing',

                'education_history' => [
                    'S1 Agribisnis - IPB University, Bogor',
                    'S2 Manajemen Bisnis - IPB University, Bogor'
                ],

                'expertise' => [
                    'Sales & Marketing',
                    'Management Strategic',
                    'Public Communication',
                    'Internet & Social Media Marketing Management'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2022 – Sekarang: Dosen, Department of Digital Business, Institut Teknologi Kalimantan (ITK)',
                    '2017 – 2019: Relationship Manager, PT Zurich Topas Life Indonesia, Bogor',
                    '2016: Financial Advisor, PT Manulife Indonesia, Bogor'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Luh Made Wisnu Satyaninggrat, S.Kom, M.T',
                'nip' => '199309092022032009',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1PEzQpIc3ktHy2_a0h09_0OMaM3HImLMj/view?usp=sharing',

                'education_history' => [
                    'S1 Sistem Informasi, Institut Teknologi Sepuluh November Surabaya',
                    'S2 Informatika Konsentrasi Sistem Informasi, Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Business Intelligence',
                    'UIUX Design',
                    'Database'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Rancang Bangun Sistem Stok Gudang Berbasis Web Untuk Industri Mikro Dan Kecil Di Kota Penyangga IKN',
                    'Dampak Kemampuan Manajemen Proses Bisnis Dan Adopsi Kecerdasan Buatan Terhadap Kinerja Proses: Studi Kasus UKM Di Kawasan IKN',
                    'Menelaah Faktor-Faktor Cyberloafing Melalui Strategi Gamifikasi Sebagai Pendekatan Inovatif Dalam Meningkatkan Produktivitas Dan Efisiensi Kerja Di Kota Penyangga IKN',
                    'Analisis Preferensi Penduduk Dalam Memilih Hunian Di Wilayah Kecamatan Balikpapan Utara',
                    'Prototype Sistem Informasi Manajemen Stok Gudang Pada Industri Mikro Kecil Di Kota Penyangga IKN',
                    'Kajian Garis Pantai Secara Temporar Di Wilayah Pesisir Ikn Sebagai Persiapan Pembagunan Infrastruktur',
                    'Perancangan Desain UI/UXPrototype Aplikasi Wisata Kuliner Sebagai Media Promosi Dan Pemasaran Digital UMKM Di Kota Penyangga IKN Dengan Menggunakan Pendekatan User Centered Design',
                    'Perancangan Basis Data Wisata Kuliner Sebagai Sarana Promosi Dan Pemasaran Destinasi Kuliner Berbasis Digital Di Kota Penyangga Ibu Kota Negara (IKN)',
                    'Pengaruh Literasi Digital Dan Pengalaman Digital Terhadap Perilaku Digital UMKM Di Kota Penyangga IKN'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2022 – Sekarang: Institut Teknologi Kalimantan',
                    '2017 – 2022: PT Bank Negara Indonesia (Persero) Tbk'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Muhammad Ikhsan Alif S., S.E., M.Sc., CPEC., CHCM.',
                'nip' => '199306112025061001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1T1CHN-B3my-4GDIGQSQsZMcZoslUpcG1/view?usp=sharing',

                'education_history' => [
                    'S1 Management, Universitas Islam Negeri Alauddin, Makassar',
                    'S2 Master Science in Management, Universitas Gadjah Mada, Yogyakarta'
                ],

                'expertise' => [
                    'Management and Organization',
                    'People Management',
                    'Organizational Behavior',
                    'Statistics',
                    'Graphic Design',
                    'Design Thinking'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Tim Ahli Pemetaan Persepsi Pelaku Pengadaan Terhadap Barang/Jasa Pemerintah Yang Berkelanjutan (2021)',
                    'Research Assistant (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2021 – Sekarang: Dosen, Department of Digital Business, Institut Teknologi Kalimantan (ITK)',
                    '2019 – 2020: Academic Assistant, Program Magister & Doktor Fakultas Ekonomi dan Bisnis, Universitas Gadjah Mada',
                    '2019: Erasmus+ Programme of The European Union, Training in Transferable Skills bersama FEB UGM dan UII',
                    '2018 – Sekarang: Trainer of Statistical Tools using Structural Equation Modelling (SEM)',
                    '2018 – 2019: Humanitarian Project, Indonesian Red Crescent di Palu, Lombok, & Sulawesi Selatan sebagai Chief Boards of Design Graphic & Content Video Creator'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Prasis Damai Nursyam Hamijaya, S.P., M.M',
                'nip' => '198709272022031001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Bisnis Digital',
                'image_url' => 'https://drive.google.com/file/d/1TvZup4Kx8yBcafh3FoCvLYCSROWxvnlP/view?usp=sharing',

                'education_history' => [
                    'S1 Agroekoteknologi, Universitas Brawijaya',
                    'S2 Magister Manajemen, Universitas Brawijaya'
                ],

                'expertise' => [
                    'Strategic Operasional Management',
                    'Strategic Management'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2022 – Sekarang: Dosen, Department of Digital Business, Institut Teknologi Kalimantan',
                    '2015 – 2022: Foundation Supervisor, Yayasan Perjuangan Pendidikan Bela Negara',
                    '2010 – 2015: Agronomy Staff, PT Bumitama Gunajaya Agro'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dr. Swastya Rahastama, S.Si., M.Si.',
                'nip' => '199210082019031018',
                'type' => 'Dosen',
                'structural_position' => 'Ketua Jurusan Sains dan Analitika Data',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/19QS_9uRWB6eelgx_Pm8NKm4rP3QjIVnt/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Institut Teknologi Bandung',
                    'S2 Fisika Institut Teknologi Bandung',
                    'S3 Fisika Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Fisika Nuklir',
                    'Fisika Komputasi'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Penelitian Dosen Pemula Ristek Dikti Tahun 2020'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => [
                    'https://phy.itk.ac.id/profile/dosen/detail/a030a214157191538265',
                    'https://scholar.google.com/citations?hl=en&user=JNar1oMAAAAJ&view_op=list_works&sortby=pubdate',
                    'https://phy.itk.ac.id/profile/dosen/detail/57191538265'
                ]
            ],

            [
                'name' => 'Febrian Dedi Sastrawan, S.Si., M.Sc.',
                'nip' => '199002272025061003',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Fisika',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1-JZ27fd4tkafGB_uSx_fgZQV_EYCyeEg/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Universitas Tadulako',
                    'S2 Ilmu Fisika Universitas Gadjah Mada'
                ],

                'expertise' => [
                    'Geofisika'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Identifikasi Sebaran Limbah Cair TPA Manggar dengan Menggunakan Metode Geolistrik (2017)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017 : Pengajar IKIP PGRI Jember',
                    '2014 : Staff Administrasi Himpuna Ahli Geofisika Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Meidi Arisalwadi, S.Si, M.Si.',
                'nip' => '199005112019031015',
                'type' => 'Dosen',
                'structural_position' => 'Kepala Laboratorium Fisika Lanjut',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/19v2I9p2myIkSEtJ2i5gQN-NsXTO4AKIL/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Universitas Mataram',
                    'S2 Ilmu Fisika Universitas Brawijaya'
                ],

                'expertise' => [
                    'Geofisika'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Penerapan Metode Geofisika Terpadu Untuk Menentukan Potensi Geothermal di Kawasan Canggar (2016)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2018 : Universitas Muhammadiyah Mataram'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Fadli Robiandi, S.Si, M.Si.',
                'nip' => '198802162021211001',
                'type' => 'Dosen',
                'structural_position' => 'Kepala Laboratorium Fisika Dasar',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1T8o8lpTOuXckLP_FXx_QKtQTJo-Wie6s/view?usp=sharing',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Agus Rifani, S.Si, M.Si.',
                'nip' => '198408042012121006',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/12nhCa5pSy5rKytN1DfU0I8S96E1iFH7B/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Universitas Brawijaya',
                    'S2 Ilmu Fisika Universitas Brawijaya',
                    'S2 Physics National Central University - Taiwan'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Atut Reni Septiana, S.Pd., M.Si.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Kurikulum dan Pengajaran',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1mkKDgBY8TliWawSEtUBA6SjQY4F2urqm/view?usp=sharing',

                'education_history' => [
                    'S1 Pendidikan Fisika Universitas Negeri Yogyakarta',
                    'S2 Fisika Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Fisika Material'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Sintesis dan Karakterisasi Nanopartikel ZnO untuk Aplikasi Sel Surya (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Chairoh Ulfah, S.Si., M.Sc',
                'nip' => '199901142025062000',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1JMV8vBPVUrfsY57UqyiiiF6wjqctxqEw/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Universitas Gadjah Mada',
                    'S2 Fisika Universitas Gadjah Mada'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dian Mart Shoodiqin, S.Si., M.Si.',
                'nip' => '198803212019031010',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1ZeVuMT16dgvEBMn4ZJ3J2nGhdFBFJyBD/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Institut Teknologi Sepuluh Nopember',
                    'S2 Fisika Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Fisika'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Simple Conductive Glass (2015)',
                    'Composite RAMI (Natural Fiber)-Epoxy For Prosthesis (2016)',
                    'Utilization of Ulin wood (Eusideroxylon Zwageri) for Folding Boat Material (2018)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dr. Musyarofah, S.Pd., M.Si.',
                'nip' => '199101292022032012',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1YxlRl-BGH55BZhLbvP4_QLd3JDZY2gFY/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Universitas Gadjah Mada',
                    'S2 Fisika Universitas Gadjah Mada'
                ],

                'expertise' => [
                    'Fisika Bahan'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Harrys Samosir, M.Sc',
                'nip' => '199201132024061001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1-FT5emwlfzw25bUh9jGD2jKLEhBRReZY/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika Universitas Negeri Medan',
                    'S2 Fisika National Chung Hsing University'
                ],

                'expertise' => [
                    'Quantum Dots',
                    'Dye Sensitized Solar Cells',
                    'Semiconductor Materials',
                    'Material Science'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Menasita Mayantasari, S.Si., M.T.',
                'nip' => '198706282022032006',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1fSdU07vvmjHgWVA0x9WrlZUzgynj7lyX/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika, Fakultas Matematika dan Ilmu Pengetahuan Alam, Institut Pertanian Bogor (IPB)',
                    'S2 Instrumentasi dan Kontrol, Fakultas Teknologi Industri, Institut Teknologi Bandung (ITB)'
                ],

                'expertise' => [
                    'Fisika Instrumentasi Medis'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Rahmania, S.Pd., M.Sc.',
                'nip' => '199002152019032019',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Fisika',
                'image_url' => 'https://drive.google.com/file/d/1lzGGVvJevBKz7X64iRI5JatPj-ckpiBg/view?usp=sharing',

                'education_history' => [
                    'S1 Pendidikan Fisika Universitas Negeri Makassar',
                    'S2 Fisika Universitas Gadjah Mada'
                ],

                'expertise' => [
                    'Geofisika'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2017-2018: Dosen LB di Universitas Andi Jemma Palopo',
                    '2013-2014:Guru Sains Fisika di ELC Education Makassar'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Muhammad Azka, S.Si., M.Sc.',
                'nip' => '198905282022031007',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Ilmu Aktuaria',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1IN49PufA_QB7IKtda-AqcT7uKgQRpQPR/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Universitas Negeri Semarang (Unnes)',
                    'S2 Matematika, Universitas Gadjah Mada (UGM)'
                ],

                'expertise' => [
                    'Matematika Keuangan'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Analisis Kestabilan dan Kendali Optimal pada Model Penyebaran DBD di Kalimantam Timur dengan Memperhatikan Vector Tahap Aquatic (2017)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang : Dosen Ilmu Aktuaria, ITK',
                    '2015 - 2020 : Dosen Matematika, ITK'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Alvianus Kristian Sumual, S.E.,M.E.',
                'nip' => '199004162025061003',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1C5ixFpKr5w9PaPcrnvdSmMqCHjm7ROC6/view?usp=sharing',

                'education_history' => [
                    'S1 Manajemen, Fakultas Ekonomi dan Bisnis Universitas Sam Ratulangi Manado (UNSRAT)',
                    'S2 Ilmu Ekonomi, Universitas Sam Ratulangi Manado (UNSRAT)'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Eli Zulkatri, M.Aktr',
                'nip' => '199109142025061003',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => '',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Indrawan, S.Pd., M.Si.',
                'nip' => '199109122024061001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1ai0WnWzFJugGbCQeixYdD6u79g7NK15k/view?usp=sharing',

                'education_history' => [
                    'S1 Pendidikan Matematika, Universitas Bung Hatta',
                    'S2 Matematika Terapan, Institut Pertanian Bogor'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Isti Kamila, S.Pd., M.Si.',
                'nip' => '198905032024062001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1B4EUXut2izsG4jbQhJATlC1dg3oN6lmJ/view?usp=sharing',

                'education_history' => [
                    'S1 Pendidikan Matematika, Universitas Negeri Medan',
                    'S2 Matematika Terapan, Institut Pertanian Bogor'
                ],

                'expertise' => [
                    'Matematika Keuangan',
                    'Matematika Aktuaria'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Lili Hernawati, S.Pd., M.Si.',
                'nip' => '199106032025062004',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1Qk79GqfK3YdqTRLlPGrFKw6EGSJJqc0u/view?usp=sharing',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Nurul Maqfirah Rauf, M.Mat',
                'nip' => '199506082024062001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1jWElDca7fgLqtlxvc1_mIBHZ3MsRM1UK/view?usp=sharing',

                'education_history' => [
                    'S1 Pendidikan Matematika, Universitas Negeri Makassar',
                    'S2 Matematika Terapan, Institut Pertanian Bogor'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Primadina Hasanah, S.Si., M.Sc.',
                'nip' => '198907172018032001',
                'type' => 'Dosen',
                'structural_position' => 'Lektor',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/16E5DpXx88v2yiz3BHuud5UElPyQAaX4l/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Universitas Diponegoro (Undip)',
                    'S2 Matematika, Universitas Gadjah Mada (UGM)'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2020-Sekarang: Dosen Ilmu Aktuaria, ITK',
                    '2016-2020: Dosen Matematika, ITK'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Putri Amalia, S.Si., M.Si.',
                'nip' => '199504042025062009',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1M7eYc_xX-kRSePVCKG2_ejbC9gqBpBsQ/view?usp=sharing',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Wahyu Dwi Lesmono, S.Si., M.Si.',
                'nip' => '199410162025061004',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Ilmu Aktuaria',
                'image_url' => 'https://drive.google.com/file/d/1tc87BL8IuDIean7KSv8om60PNDNVevb8/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Universitas Pakuan (UNPAK)',
                    'S2 Matematika, Universitas Indonesia (UI)'
                ],

                'expertise' => [
                    'Analisis Data',
                    'Statistika'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Perbedaan Rata-Rata Konsumsi Protein Pangan Hewani Indonesia di Wilayah Perkotaan dan Perdesaan dengan Metode Hotteling T2-Test (2022)',
                    'Formulasi Cemilan Sehat Berbasis Sediaan Bahan Alam dan Penerapan Uji Hedonik Dengan Metode Statistika Nonparametrik (2025)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017-2025: Dosen Matematika dan Statistika, STTIF Bogor'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dr. Moh. Januar Ismail Burhan, S.Si, M.Si.',
                'nip' => '198501042015041002',
                'type' => 'Dosen',
                'structural_position' => 'Kepala Laboratorium Komputasi dan Data',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1qspr-9wPXfVSMebiQ20eWUamvfHHYMp9/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika Universitas Padjadjaran',
                    'S2 Matematika Insitut Teknologi Bandung',
                    'S3 Matematika Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Matematika Analisis'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Analisis Dinamik model matematika pada Hutan Mangrove di Kota Balikpapan',
                    'Teorema Integral Cauchy Numerik',
                    'Analisis Permasalahan Infrastruktur Kota Balikpapan Menggunakan Metode Importance Performance Analysis (IPA) Dalam Menentukan Strategi Pemecahan Masalah',
                    'Pengembangan Ruang Norm-n Berdimensi berhingga'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Kartika Nugraheni, S.Si., M.Si.',
                'nip' => '199110292022032011',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Matematika',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1pSHS9WdMCblGbuSRO4ud7LVC85ppbNkH/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika Universitas Brawijaya',
                    'S2 Matematika Universitas Brawijaya'
                ],

                'expertise' => [
                    'Dynamical Systems',
                    'Biomathics'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Dynamics of a Fractional Order Eco-Epidemiological Model (2017)',
                    'Stability Analysis of Mangrove Forest Resource Depletion Models due to the Opening of Fish Pond Land (2017-2018)',
                    'Stability Analysis of Mangrove Forest Resource Depletion Models due to the Opening of Fish Pond Land with delays (2018-2019)',
                    'Pengaruh Pertumbuhan Populasi Bekantan dan Pembukaan lahan terhadap Pertumbuhan Mangrove dengan Waktu Tunda (2019)',
                    'Model Kendali Optimal Pengaruh Pertumbuhan Pengangguran terhadap Perubahan Angka Kriminalitas untuk Menunjang Smart Governance (2020)',
                    'Optimalisasi Penjadwalan Sistem Produksi Industri Pangan Olahan Menggunakan Aljabar Max Plus (2021)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Adam, S.Si., M.Si',
                'nip' => '199807242022031009',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1wvBs08A7ONdT3GCJXCBZRgtzhpujI926/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Institut Teknologi Bandung',
                    'S2 Matematika, Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Analisis & Geometri'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Aditya Putra Pratama, S.Si., M.Si.',
                'nip' => '199303062025061001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1Fubo-YjHsznFoY0DMxwpRD1ZlH26o_Qh/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Institut Teknologi Sepuluh November',
                    'S2 Matematika, Institut Teknologi Sepuluh November'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => [
                    'Penerapan Kendali Optimal Pada Proses Penyebaran Penyakit Kolera Melalui Control Treatment, Edukasi, dan Klorinasi (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dr. Retno Wahyu Dewanti, S.Si., M.Si.',
                'nip' => '198902032015042002',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1G7lN8aOjmZZXVNi3qcrZizJdzGSdKUbw/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Universitas Brawijaya',
                    'S2 Matematika, Institut Teknologi Sepuluh November',
                    'S3 Matematika, Institut Teknologi Bandung'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Indira Anggriani, S.Si., M.Si.',
                'nip' => '199206222019032020',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1MsMicNa5pk6HYEnG-PZ_fa3s6jO4lKZe/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Institut Teknologi Sepuluh Nopember',
                    'S2 Matematika, Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Pemodelan Matematika'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Simulasi Pergerakan Tumpahan Minyak di Laut dengan Pengaruh Angin (2019)',
                    'Pengembangan Integrasi Offshore Mariculture dan Wind Turbin di Selat Makassar: Desain dan Stabilitas Struktur (2019)',
                    'Model Kendali Optimal Terhadap Potensi Sumber Daya Hutan Melalui Reduksi CO2 dalam Mempersiapkan Ibukota Negara (2020)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Muliady Faisal, S.Si, M.Si.',
                'nip' => '198406232019031010',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1wm956Gquc7UtsvuOe9RTm5utFonF2BUo/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika, Universitas Hasanuddin',
                    'S2 Sains Komputasi, Insitut Teknologi Bandung'
                ],

                'expertise' => [
                    'Computational Science & Engineering',
                    'Cyber Security Profesional',
                    'Quantum Computing'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Penentuan Orde Model SARIMA Terbaik untuk Peramalan Energi Listrik Jangka Pendek di Wilayah Balikpapan (2019)',
                    'Model Dispersi Pencemaran Udara Cerobong Dalam Menentukan Titik – Titik Pemantauan Kualitas Udara Ambien Kota Balikpapan Untuk Mendukung Pemantauan Kualitas Udara Dalam Smart Environment (2021)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Nur Qadri Bahar, S.Si., M.Si.',
                'nip' => '199602062024061002',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1aep1-SB29RgY64WBiUUqmQdpmGh--4bp/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Universitas Negeri Makassar',
                    'S2 Matematika, Universitas Negeri Makassar'
                ],

                'expertise' => [
                    'Pemodelan Matematika'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Winarni, S.Si. M.Si.',
                'nip' => '198202072021212006',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Matematika',
                'image_url' => 'https://drive.google.com/file/d/1kVmhHSpVxF9JRnfnVdDyTbxWp2OaQHJe/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Institut Teknologi Sepuluh Nopember',
                    'S2 Matematika, Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => [
                    'Desain Jaringan Busway Trans Balikpapan dan Penjadwalannya sebagai Upaya Antisipasi Kemacetan di Balikpapan',
                    'Penerapan Metode Predictive Control Pada Optimasi Portofolio untuk Menentukan Strategi dalam Manajemen Investasi Saham',
                    'Pemodelan, Analisis, dan Kontrol Optimal Pada Sistem Penyebaran Penyakit Deman Berdarah di Kota Balikpapan',
                    'Optimasi Penggunaan Moda Angkutan Umum berdasarkan Preferensi Masyarakat (Studi Kasus: Kota Balikpapan)',
                    'Rerouting Trayek Angkutan Kota Balikpapan Terintegrasi Dengan Jaringan Busway Trans Balikpapan Untuk Optimalisasi Layanan Transportasi Umum Di Balikpapan (2019)',
                    'Optimalisasi Penjadwalan Sistem Produksi Industri Pangan Olahan Menggunakan Aljabar Max Plus (2021)'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'M. Ihsan Alfani Putera, S.Tr.Kom, M.Kom',
                'nip' => '199208302019031016',
                'type' => 'Dosen',
                'structural_position' => 'Ketua Jurusan Teknik Elektro, Informatika, dan Bisnis',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1HVsJB2CqoPhKRwnZa5jUanNHwEo_lwCE/view?usp=sharing',

                'education_history' => [
                    'D3 Teknik Informatika Politeknik Negeri Banjarmasin',
                    'D4 Teknik Informatika Politeknik Elektronika Negeri Surabaya',
                    'S2 Teknik Informatika Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'UX Design',
                    'Smart Governance',
                    'Software Development'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Penelitian Dosen Pemula Ristek Dikti Tahun 2020'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2015 - Sekarang : Information Systems Lecturer ITK',
                    '2013 - 2015 : Junior Engineering, Lintasarta'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/ihsanalfani/',
                    'https://scholar.google.com/citations?user=UtyPlF4AAAAJ&hl=en',
                    'https://www.scopus.com/authid/detail.uri?authorId=57431030700'
                ]
            ],

            [
                'name' => 'Sri Rahayu Natasia, S.Komp., M.Si., M.Sc',
                'nip' => '199001082020122003',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Sistem Informasi',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1WK_ifjhbAUIrlJ65zM32OJQaD55WLgXy/view?usp=sharing',

                'education_history' => [
                    'S1 Ilmu Komputer Institut Pertanian Bogor',
                    'S2 Sains Komputasi - Institut Teknologi Bandung, Computational Science - Kanazawa University'
                ],

                'expertise' => [
                    'Information System Development',
                    'IS/IT Evaluation',
                    'UI/UX Research',
                    'Machine Learning'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Pemanfaatan Sistem Informasi Kesehatan untuk Peningkatan Prestasi dan Kesejahteraan Siswa Sekolah Dasar di Balikpapan (2016)',
                    'Purwarupa Tempat Sampah Cerdas dengan Sistem Tertanam Berbasis Fuzzy Inference Sistem (2018)',
                    'Pembangunan Sistem Informasi Penelitian dan Pengabdian Masyarakat (Studi Kasus: Institut Teknologi Kalimantan) (2019)',
                    'Evolusi Sistem Informasi Penelitian dan Pengabdian Masyarakat (SIMPAS LPPM) Institut Teknologi Kalimantan (2020)',
                    'Evaluasi Penerapan Sistem Informasi Manajemen Rumah Sakit (SIMRS) pada RSUD Dr. Kanujoso Djatiwibowo Menggunakan Metode Hot-Fit (2020)',
                    'Evaluasi Usability Website Berita Online Prokal.Co pada PT. Duta Prokal Multimedia Menggunakan Metode Evaluasi Heuristic dan Web Usability Evaluation Tool (Webuse) (2020)',
                    'Evaluasi Usability Website Dinas Perumahan dan Permukiman Kota Balikpapan Menggunakan Metode WEBUSE (2021)',
                    'Evaluasi Usability Website Dinas Tenaga Kerja dan Transmigrasi Kabupaten Berau Menggunakan Metode Think-Aloud (2021)',
                    'Analisis User Interface Pada Situs Web Dinas Kependudukan dan Pencatatan Sipil Kabupaten Paser Menggunakan Metode Heuristik (2021)',
                    'Evaluasi Usability Website Dinas Kesehatan Kota Balikpapan Menggunakan Metode Heuristic Evaluation (2021)',
                    'Evaluasi Pada Website Bappedalitbang Kota Balikpapan (Badan Perencanaan Pembangunan Daerah, Penelitian Dan Pengembangan Kota Balikpapan) Dengan Metode Heuristics Evaluation (2021)',
                    'Evaluasi dan Rekomendasi pada Website Kebun Raya Balikpapan Dengan Metode Evaluasi Heuristik (2021)',
                    'Analisis User Interface Terhadap Website Badan Pusat Statistik Kota Balikpapan Dengan Menggunakan Metode Heuristic Evaluation (2021)',
                    'Analisis User Interface Pada Situs Website Dinas Komunikasi Dan Informatika Kota Balikpapan Dengan Metode Heuristic Evaluation (2021)',
                    'Evaluasi Usability Website Dinas Pendidikan Dan Kebudayaan Kota Balikpapan Menggunakan Metode Think Aloud (2021)',
                    'Evaluasi Website Perpustakaan Kota Samarinda Menggunakan Metode Heuristic Evaluation (2021)',
                    'Evaluasi Usability pada Website Balikpapan Gugus Tugas Tanggap COVID-19 Menggunakan Metode Heuristic Evaluation (2021)',
                    'Evaluasi Usability Website Kepolisian Resor Kota Balikpapan Menggunakan Metode Think Aloud (2021)',
                    'Evaluasi Usability Website Menggunakan Metode Heuristic Evaluation Studi Kasus: Website Dinas Pekerjaan Umum Kota Balikpapan (2021)',
                    'Evaluasi Usability Website Kantor Kesyahbandaran dan Otoritas Pelabuhan Kelas I Balikpapan Menggunakan Metode Heuristic Evaluation (2021)',
                    'Evaluasi Usability Website PDAM (Perusahaan Daerah Air Minum) Kota Balikpapan Menggunakan Metode Webuse (2021)',
                    'Analisis Faktor yang Memengaruhi Continuance Intention pada Penggunaan Mobile Payment dengan Menggunakan Structural Equation Modeling (2021)',
                    'Media Pembelajaran dengan Metode Gamification untuk Pendidikan Formal dan Non-Formal di Kalimantan Era Covid-19 (2021)',
                    'Analisis Penerimaan NUADU Sebagai Platform E-Learning Menggunakan Pendekatan Technology Acceptance Model (TAM) (2021)',
                    'Pengembangan SIMSIS sebagai Sistem Smart City Ranah Pendidikan untuk Menunjang Proses Pembelajaran (2021)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'January 2016 - Sekarang :  Information System Lecturer - ITK',
                    '2012 : Freelance PHP Programmer at Agency for the Assessment and Aplication of Technology (BPPT)',
                    'September 2012 - January 2013 : Lab Assistant for Quantitative Method in Computer Science Department, Bogor Agricultural University',
                    '2011 : Freelance teaching assistant of natural science for junior high school at Bintang Pelajar, Bogor',
                    'March 2010 - May 2010 : Internship at Center for Agricultural Library and Technology Dissemination, Bogor'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://id.linkedin.com/in/natasiaayu',
                    'https://scholar.google.co.id/citations?user=wCiwTCQAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=57191542144'
                ]
            ],

            [
                'name' => 'Aidil Saputra Kirsan, S.ST., M.Tr.Kom.',
                'nip' => '199403172025061004',
                'type' => 'Dosen',
                'structural_position' => 'Kepala Laboratorium Inovasi Digital',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1w_uVbZJZYkVPZnuoiBsZ8mXFCWqR2Os0/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Komputer dan Jaringan - Politeknik Negeri Ujung Pandang',
                    'S2 Teknik Informatika dan Komputer - Politeknik Elektronika Negeri Surabaya'
                ],

                'expertise' => [
                    'Full Stack Web & Mobile Development (Laravel, Next.js, Nuxt.js, React Native, Tailwind CSS, Node.js)',
                    'Cloud & VPS Infrastructure Management (VPS setup and optimization, Nginx, PM2, SSL configuration, domain management, and monitoring)',
                    'Cloud-based Database & Data Services (Supabase, MongoDB Atlas, PostgreSQL, MySQL, Prisma ORM)',
                    'CI/CD & Repository Workflow Management (GitHub Flow, Branch Protection, Role-based Collaboration, Workflow Automation)',
                    'Software Development & API Integration (JavaScript, PHP, Python, RESTful API, WebSocket, JSON)',
                    'System Architecture & Cloud Integration for Web and IoT Applications'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'IMPLEMENTASI SIAKAD BERBASIS WEBSITE DAN ANDROID MENGGUNAKAN FRAMEWORK CODEIGNITER DAN RESTFUL API UNTUK MENDUKUNG EKOSISTEM',
                    'PENDIDIKAN DI SEKOLAH ISLAM BALIKPAPAN'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang : Information Systems Lecturer, Institut Teknologi Kalimantan',
                    '2016 - Sekarang : Full Stack Developer'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/aidil-saputra-kirsan-0808911bb',
                    'https://scholar.google.com/citations?user=lzQbWuEAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=57212062045'
                ]
            ],

            [
                'name' => 'Arif Wicaksono Septyanto, M.Kom',
                'nip' => '199209182022031009',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1V6BhXU7nT0dFs5HkBnKI8a85CyEFdJmE/view?usp=sharing',

                'education_history' => [
                    'S1 Sistem Informasi - STMIK Duta Bangsa',
                    'S2 Sistem Informasi - Universitas Diponegoro'
                ],

                'expertise' => [
                    'Front-End Development',
                    'Back-End Development',
                    'UI/UX Design',
                    'Sentiment Analysis',
                    'Geographic Information System (GIS)',
                    'Data Mining'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2022 - Sekarang : Information Systems Lecturer, Institut Teknologi Kalimantan',
                    '2018 - 2021 : Information Systems Lecturer, Universitas Duta Bangsa Surakarta',
                    '2014 - 2015 : Developer - PT Kusuma Mulia Textile',
                    '2013 - 2014 : Developer - CV Saintek Software House'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://scholar.google.com/citations?user=fI1Db5oAAAAJ',
                    'https://www.scopus.com/authid/detail.uri?authorId=57210463395'
                ]
            ],

            [
                'name' => 'Dwi Arief Prambudi., M.Kom.',
                'nip' => '199208012019031010',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1Lj5ATtxkNla1CzqnhvUX5IXp4czdUK72/view?usp=sharing',

                'education_history' => null,

                'expertise' => [
                    'Artificial Intelligence and Expert Systems',
                    'Information System Security and Evaluation',
                    'Decision Support Systems',
                    'Smart Systems and IoT Applications',
                    'Data Mining and Business Intelligence',
                    'Software Development and Agile Methodologies'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2018 - Sekarang : Information Systems Lecturer - ITK'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dwi Nur Amalia, S.Kom., M.Kom',
                'nip' => '199510172024062001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1x17c64aGmr3b796tUqfe6sps2cupfAOp/view?usp=sharing',

                'education_history' => [
                    'S1 Sistem Informasi - Institut Teknologi Kalimantan',
                    'S2 Sistem Informasi - Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Business Process Management',
                    'Information Systems Audit',
                    'IT Enterprise Architecture'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang: Information Systems Lecturer - ITK',
                    '2019 - 2020: Analis Sistem Pemerintahan Berbasis Elektronik Kota Madiun - PT Tati Surabaya'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Hendy Indrawan Sunardi, S.Kom., M.Eng.',
                'nip' => '199203302024061002',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1CCYy7KFAzRugD2FX1TBBUUE89RVBhOOC/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika - Universitas Islam Indonesia',
                    'S2 Teknologi Informasi - Universitas Gadjah Mada'
                ],

                'expertise' => [
                    'Internet of Things (IoT) and Smart Home Systems',
                    'Information Systems Design and Development',
                    'IT Governance and Strategic Planning',
                    'Information Security and Risk Assessment',
                    'Network and Infrastructure Management',
                    'Systems Analysis and Evaluation'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang: Information Systems Lecturer - ITK'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Henokh Lugo Hariyanto, M.Sc.',
                'nip' => '199303062022041001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1zkkCUj-DuBRMqrvNPC_sJHQcmZhdPvDC/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika - Universitas Gadjah Mada',
                    'S1 Computational Science - Kanazawa University'
                ],

                'expertise' => [
                    'Computational Mathematics',
                    'Numerical Analysis'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang: Information Systems Lecturer, Institut Teknologi Kalimantan',
                    '2021 - 2022: Researcher - LabMath Indonesia - Bandung'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/henokhlugo/',
                    'https://scholar.google.com/citations?user=0-iFtfUAAAAJ',
                    'https://www.scopus.com/authid/detail.uri?authorId=57226545999'
                ]
            ],

            [
                'name' => 'Ir. I Putu Deny Arthawan Sugih Prabowo, M.Eng.',
                'nip' => '199010192019031008',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1qIe7dxM4CrSIN3Rd8XeGyL4a-silDijW/view?usp=sharing',

                'education_history' => null,

                'expertise' => [
                    'IT Service Management',
                    'E-Government',
                    'E-Learning',
                    'E-Commerce',
                    'Project Management',
                    'IT Risk Management',
                    'Digital Security',
                    'Digital Infrastructure/ICT in MEPIT (MEP) System',
                    'Technology Acceptance and Evaluation'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Penyusunan Dokumen Proses Bisnis Tata Kelola dan Manajemen IT (termasuk ITSM) PT. Pos Indonesia (Head Office, Bandung) - Kolaborasi dengan PT. Sentra Data Persada (2022)',
                    'Ketua Penelitian/Proyek Rekayasa Keselamatan dalam Penyusunan Dokumen Justifikasi Teknis untuk Pengembangan Data Center di Bank Pembangunan Daerah Provinsi XYZ (2024)',
                    'Ketua Penelitian/Proyek Penyusunan Justifikasi Teknis dan Disaster Recovery Plan untuk Pengembangan Data Center UPA TIK ITK (2025)',
                    'Anggota/Tenaga Ahli (System Analyst) pada Proyek Pengembangan Sistem ABC Kementerian XYZ Republik Indonesia (2024)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Incident Management Team (IT Service Monitoring Unit, IT Service Delivery) - PT. XL Axiata, Tbk',
                    'ME Inspector - PT. Jaya CM',
                    'Tenaga Ahli MEPIT/MEP (Spesialisasi/Keahlian Jaringan Data/IT Infrastructure), Tim Manajemen Konstruksi Proyek Gedung Tower Bank Sultra Tahap 2 - PT. Garis Rancang Bangun',
                    'Tenaga Ahli MEPIT/MEP (Spesialisasi/Keahlian Jaringan Data/IT Infrastructure), Tim SLF (Sertifikat Laik Fungsi) Proyek Gedung Tower Bank Sultra Tahap 2 - PT. Laras Sembada',
                    'Asesor Kompetensi - LSP Informatika',
                    '2024:Tim Pendamping Ahli di PT. DS dalam suatu Proyek Kementerian XYZ Republik Indonesia',
                    '2024:Tenaga Ahli (System Analyst) di PT. PBA (suatu perusahaan konsultan) dalam suatu Proyek Kementerian XYZ Republik Indonesia',
                    '2023-2024: Asesor Eksternal Sistem Pemerintahan Berbasis Elektronik (SPBE) Kementerian PAN-RB RI, Periode Evaluasi Nasional SPBE'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Lovinta Happy Atrinawati, S.T., M.T., CISA',
                'nip' => '198904152018032001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1LguLELwe2EIhpdoDU3hBIP0I2swOOYU4/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika - Institut Teknologi Bandung',
                    'S2 Teknik Informatika - Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Information System Audit',
                    'Knowledge Management',
                    'Enterprise Resource Planning',
                    'Business Process Management'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Knowledge Management System for BPLHD West Java, Teknik Informatika ITB (2009 - 2010)',
                    'Collaborative Multimedia System for Biodiversity Knowledge, Informatika ITB (2009 - 2010)',
                    'Implementation of Integrated Health Record System in Community Health Centers,Teknik Informatika ITB  (2009 - 2010)',
                    'Mobile Learning System, Institut Teknologi Kalimantan (2015)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2015 – Sekarang: Information System Lecturer, Institut Teknologi Kalimantan (ITK), Indonesia',
                    '2015 – 2015: Internal Audit Supervisor, PT Astra Graphia Tbk.',
                    '2015 – 2015: Continuous Monitoring & Continuous Audit Development, PT Astra Graphia Tbk.',
                    '2015 – 2015: Procedure & Quality Assurance for ERP (MS Dynamics) & eCommerce Implementation, PT Astragraphia Xprins Indonesia',
                    '2012 – 2014: Business Process Implementation and ERP (SAP) Re-implementation, PT Astra Graphia Tbk.',
                    '2012 – 2014: Internal Audit Staff, PT Astra Graphia Tbk.',
                    '2011 – 2012: Management Trainee – Internal Audit, PT Astra International Tbk.',
                    '2010: Training Instructor – Content Management System for Higher Education Institution, Teknik Informatika ITB, Bandung',
                    '2009 – 2009: Information System Analyst – “Information System for Creative Industry”, Bandung High-Tech Valley, Bandung',
                    '2009: Bridging Program Assistant, ITB, Bandung',
                    '2008: Internship – Knowledge Management Assessment, PT Sigma Cipta Utama',
                    '2007 – 2010: Course Assistant, Teknik Informatika ITB, Bandung',
                    '2007 – 2010: Information System Laboratory Assistant, Teknik Informatika ITB, Bandung'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/lovinta/?originalSubdomain=id',
                    'https://scholar.google.co.id/citations?hl=en&user=hoRXNb0AAAAJ',
                    'https://www.scopus.com/authid/detail.uri?authorId=35174300400'
                ]
            ],

            [
                'name' => 'M. Gilvy Langgawan Putra, S.Kom., M.MT',
                'nip' => '199405112019031010',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1pYLi99pyDHFpLSyD20hc8Fh3VhLd5BzM/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika - Universitas Brawijaya',
                    'S2 Manajemen Teknologi Informasi - Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Human Computer Interaction',
                    'E-Learning',
                    'Decision Support System',
                    'Gamification',
                    'Digital Transformation'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2018 - Sekarang: Information Systems Lecturer - ITK'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/muhammad-gilvy-langgawan-putra-65042a12b/',
                    'https://scholar.google.co.id/citations?user=6khCqswAAAAJ&hl=id',
                    'https://orcid.org/0000-0002-5167-1766'
                ]
            ],

            [
                'name' => 'Nursanti Novi Arisa, M.Kom.',
                'nip' => '199111032020122004',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1arhxFKrgYfC33AjpKCLG7CNwO5hxeii3/view?usp=sharing',

                'education_history' => [
                    'S1 Pendidikan Informatika - Universitas Negeri Malang',
                    'S2 Teknik Informatika - Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'UI/UX Research',
                    'Information Systems Development',
                    'Machine Learning',
                    'Data Driven Decision Making'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2021 – Sekarang: Information Systems Lecturer, Institut Teknologi Kalimantan',
                    '2017 – 2018: Information Systems Lecturer, Universitas Gajayana'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Rosa Eliviani, S.Kom., M.T.',
                'nip' => '199808102025062011',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/18TojExlfmsRFG5AoeS-f3rpS2JHBzcwz/view?usp=sharing',

                'education_history' => [
                    'S1 Sistem Informasi - Institut Teknologi Kalimantan',
                    'S2 Teknik Elektro - Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Internet of Things (IoT)',
                    'Wireless Sensor Network (WSN)',
                    'Software Development',
                    'Machine Learning'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2025 – Sekarang: Information Systems Lecturer, Institut Teknologi Kalimantan',
                    '2023 – 2025: Informatics Management Lecturer, Astra Polytechnic',
                    '2023: System Analyst, Artristik Bandung',
                    '2022: Standard Operating Procedure (SOP) Designer Intern, Institut Teknologi Bandung'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/rosaeliviani/',
                    'https://scholar.google.com/citations?user=Mf5WlWgAAAAJ',
                    'https://www.scopus.com/authid/detail.uri?authorId=57980205100'
                ]
            ],

            [
                'name' => 'Vika Fitratunnany Insanittaqwa, S.Kom., M.Kom.',
                'nip' => '199107152022032016',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1-2wf8q8Rzjyy-FW89n24vm0ONrY1OZvo/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika - Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Informatika - Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Software Engineering',
                    'Software Development',
                    'Game Development'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang: Information Systems Lecturer - ITK'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/vika-fitratunnany-insanittaqwa-47719b283/',
                    'https://scholar.google.com/citations?user=KSbR3ScAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=56766076000'
                ]
            ],

            [
                'name' => 'Yuyun Tri Wiranti, S.Kom., M.MT',
                'nip' => '199008092019032016',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Sistem Informasi',
                'image_url' => 'https://drive.google.com/file/d/1BTWFBqOL-mnY7b8sE0A_uq_K5xzEB9iN/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika - Institut Teknologi Sepuluh Nopember',
                    'S2 Manajemen Teknologi Informasi - Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Software Developments',
                    'IS Strategic Planning',
                    'IT Enterprise Architecture',
                    'IT Project Management'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2015 – Sekarang: Information Systems Lecturer, Institut Teknologi Kalimantan',
                    '2014 – 2015: Department of Technology Lecturer, Universitas Muhammadiyah Gresik'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/yuyun-tri-wiranti-5ab11a11b/',
                    'https://scholar.google.co.id/citations?user=-_VrWf0AAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=57221499118'
                ]
            ],

            [
                'name' => 'Irma Fitria, S.Si., M.Si.',
                'nip' => '199303232022032016',
                'type' => 'Dosen',
                'structural_position' => 'Wakil Dekan Bidang Akademik dan Kemahasiswaan Fakultas Sains dan Teknologi Informasi ITK',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1kelyEom6HFkby_YelWvBSLyQ99pyjlsv/view?usp=sharing',

                'education_history' => [
                    'S1 Sarjana Sains di Departemen Matematika Institut Teknologi Sepuluh Nopember (ITS)',
                    'S2 Magister Sains di Departemen Matematika Institut Teknologi Sepuluh Nopember (ITS)'
                ],

                'expertise' => [
                    'Pemodelan Matematika',
                    'Kontrol Optimal',
                    'Optimasi',
                    'Sistem Dinamik'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2025 - Sekarang : Wakil Dekan Bidang Akademik dan Kemahasiswaan Fakultas Sains dan Teknologi Informasi - ITK',
                    '2023 - 2025: Departemen Matematika dan Teknologi Informasi, ITK sebagai Ketua Departemen',
                    '2020 – 2023: Program Studi Statistika, ITK sebagai Koordinator Program Studi',
                    '2017 - 2019: Bagian Kerja Sama ITK sebagai Kepala',
                    '2016 - Sekarang: Reviewer Jurnal Nasional dan Internasional',
                    '2016 - Sekarang: Dosen Matematika, Departemen Matematika, Institut Teknologi Kalimantan (ITK), Balikpapan, Indonesia',
                    '2016 – 2017: Bagian Kemahasiswaan ITK sebagai Mentor (Tim Pembina Kemahasiswaan)',
                    '2014 – 2016: Guru Privat untuk Matematika dan Sains, Surabaya, Indonesia',
                    '2011 - September 2015: Asisten Dosen untuk Mata Kuliah Kalkulus di Institut Teknologi Sepuluh Nopember (ITS) Surabaya, Indonesia'
                ],

                'awards' => [
                    'Reviewer for National and International Journal (2016-present)',
                    'Certified by BNSP as Substantive Editing (2023-2026)',
                    'Best Lecturer in Statistics Study Program (2023)',
                    'ITK Awards for Innovative Lecturer (2022)',
                    'Best Champion 3 Latsar CPNS - KDOD Lan Samarinda (2022)',
                    'Resource persons at the national webinar (ITK-ULM-INDOMS Kal-Tim Collaboration) (2022)',
                    'Jury Satria Data Ministry of Education and Culture Research and Technology (2022)',
                    'Best Lecturer in Statistics Study Program (2021)',
                    'Jury of BPS RI Big Data Hackathon Contest (2021)',
                    'Best Lecturer in Statistics Study Program (2020)',
                    'Best Lecturer in Mathematics Study Program (2019)',
                    'Final Assignment Advisory Team Collaboration of ITK and ITS Mathematics Study Program (2019)',
                    'The Best Graduates of Mathematics for Bachelor Program in 2014 and Master Program in 2016, ITS, Surabaya, Indonesia',
                    'Fresh Graduate Scholarship for Master Program in ITS, Surabaya, Indonesia 2014-2016',
                    'Mathematics Department Outstanding Student in 2010-2014, ITS, Surabaya, Indonesia',
                    'The Best GPA in Bachelor Program since 2010-2014 and Master Program since 2014-2016 in ITS, Surabaya, Indonesia'
                ],

                'academic_profiles' => [
                    'https://www.linkedin.com/in/irma-fitria-187a61133/',
                    'https://scholar.google.co.id/citations?user=esCFdocAAAAJ&hl=en',
                    'https://www.scopus.com/authid/detail.uri?authorId=57201289276'
                ]
            ],

            [
                'name' => 'Diana Nurlaily, S.Si., M.Stat.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Statistika',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1pkyYStCR2bFcWu_xR_uaMosnGYhKUDaU/view?usp=sharing',

                'education_history' => [
                    'S1 Statistika ITS',
                    'S2 Statistika ITS'
                ],

                'expertise' => [
                    'Data Mining',
                    'Klasifikasi'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Farida Nur Hayati, S.Si., M.Stat.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1GSW4OOtXqLbWFAjKRINq0T95_TWPXxMZ/view?usp=sharing',

                'education_history' => [
                    'S1 Statistika ITS',
                    'S2 Statistika ITS'
                ],

                'expertise' => [
                    'Analisis Regresi',
                    'Time Series',
                    'Analisis Data'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Farida Nur Hidayah, S.H., M.H.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/14pX8kpzAZQjOtCPeSxRnnzV8AhvXcDW1/view?usp=sharing',

                'education_history' => [
                    'S1 : Sarjana Studi Hukum Internasional Universitas Diponegoro',
                    'S2: Magister Studi Hukum Internasional Universitas Diponegoro'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Kevin Agung Fernanada Rifki, S.Stat., M.Stat.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1LMERS1igb9q2XLYoC7uipwJkEWIvWIRe/view?usp=sharing',

                'education_history' => [
                    'S1 : Statistika, Institut Teknologi Sepuluh Nopember',
                    'S2 : Statistika, Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/kevin-agung-fernanda-rifki-800911170/',
                    'https://scholar.google.com/citations?user=lh8ohZQAAAAJ&hl=id&authuser=2',
                    'https://www.scopus.com/authid/detail.uri?authorId=58174648600'
                ]
            ],

            [
                'name' => 'Magdalena Effendi, S.Stat., M.Stat.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1hjMfu1tNL2KoyRIr8-kb4xlPU98YaVVM/view?usp=sharing',

                'education_history' => [
                    'S1 : Statistika Institut Teknologi Sepuluh Nopember',
                    'S2 : Statistika Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Mega Silfiani, S.Si., M.Si., M.Sc.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1KKPucFkdpbZaQ8SfUcu1bxgQqx9KJpqK/view?usp=sharing',

                'education_history' => [
                    'S1 Statistika ITS',
                    'S2 Statistika ITS',
                    'S3 (Ongoing) Department of Econometrics, University of Gdansk'
                ],

                'expertise' => [
                    'Time Series',
                    'Ekonometrika',
                    'Optimasi'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Riki Herliansyah, S.Si., M.Stats., Ph.D.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1ST3Eosg5jZnAfAMziduQAYBb8vfIuGMV/view?usp=sharing',

                'education_history' => [
                    'S1 Statistika UNMUL',
                    'S2 Statistika University of New South Wales (UNSW)',
                    'S3 The University of Edinburgh, UK'
                ],

                'expertise' => [
                    'Statistika Komputasi',
                    'Statistika Ekologi'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'DIPA ITK, Mobile Learning System for Higher Education (2015)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2015 – Sekarang: Lecturer, Department of Mathematics and Information Technology, Institut Teknologi Kalimantan, Indonesia',
                    '2010: Data Entry, Jawa Post Institute Pro Otonom, Samarinda, Indonesia',
                    '2009: IT Support, PT Trakindo Utama, Samarinda, Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Sigit Pancahayani, S.Si., M.Si',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/13hsjRRN7_dVotih6bqgDaaBMAM23tgSc/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika ITS',
                    'S2 Matematika ITB',
                    'S3 (Ongoing) Matematika ITB'
                ],

                'expertise' => [
                    'Pemodelan Matematika',
                    'Teori Graf',
                    'Optimasi'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2015 – 2016: Tim Pembina Kemahasiswaan',
                    '2014: Dosen, Sekolah Tinggi Teknologi Nasional, Jambi',
                    '2013 – 2017: Koordinator Program Studi Matematika',
                    '2013 – 2014: Dosen Matematika, Universitas Jambi'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/sigit-pancahayani-4b699438/?originalSubdomain=id',
                    'https://scholar.google.com/citations?hl=en&user=fNTc4YoAAAAJ',
                    'https://www.scopus.com/authid/detail.uri?authorId=56872944100'
                ]
            ],

            [
                'name' => 'Surya Puspita Sari, S.Si., M.Si',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1ZrbmIRSJ2nr9pYCCgGDsVH5g_uZS0w7J/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika Universitas Andalas',
                    'S2 Matematika Universitas Andalas'
                ],

                'expertise' => [
                    'Pengendalian Kualitas Statistik'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    'Asisten Laboratorium Statistika dan Komputasi Universitas Andalas',
                    'Desain Grafis dan Digital Marketing PT. Azhar Mitra Utama',
                    'IT Program dan Tentor Yayasan Pemimpin Patoka Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Syalam Ali Wira Dinata Simatupang, S.Si., M.Si.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1CA0siVzbY60TuOsycAG-qHWKB__DxF0f/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika UIN SUSKA',
                    'S2 Matematika Universitas Riau'
                ],

                'expertise' => [
                    'Time Series',
                    'Forecasting',
                    'Applied Multivariate'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2021 – 2022: Wakil Gubernur IndoMS Wilayah Kalimantan',
                    '2020: Ketua Dies Natalis ITK'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Yumna Aqila Kaltsum, S.Si., M.Stat.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Statistika',
                'image_url' => 'https://drive.google.com/file/d/1mBeUwC_e_H7SrQcLWDMO_mSsNFO3IhSr/view?usp=sharing',

                'education_history' => [
                    'S1 : Sarjana Statistika Universitas Indonesia',
                    'S2 : Magister Statistika Universitas Brawijaya'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Amalia Rizqi Utami, S.T., M.T.',
                'nip' => '100320249',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Bidang Kemahasiswaan',
                'functional_position' => 'Dosen Program Studi Teknik Elektro',
                'image_url' => 'https://drive.google.com/file/d/12_1jrWAUP4yy175S9DCSAxQgym2o8EgX/view?usp=sharing',

                'education_history' => [
                    'S1-TelkomUniversity',
                    'S2-Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Computer System',
                    'Machine Learning',
                    'Algorithm'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang : Lecturer in Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/amalia-rizqi-utami/',
                    'https://scholar.google.com/citations?hl=en&user=Ix9lU8kAAAAJ&view_op=list_works&sortby=pubdate',
                    'https://www.scopus.com/authid/detail.uri?authorId=57206726823'
                ]
            ],

            [
                'name' => 'Muhammad Ridho Dewanto, S.T., M.T.',
                'nip' => '199011092022031007',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Teknik Elektro',
                'functional_position' => 'Dosen Program Studi Teknik Elektro',
                'image_url' => 'https://drive.google.com/file/d/1gioy9TOOyCTmqDF4ppFbID5ywZPpyN_c/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Institut Teknologi Bandung',
                    'S2 Teknik Elektro Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Computer System',
                    'Machine Learning'
                ],

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2022 - Sekarang : Lecturer in Institut Teknologi Kalimantan',
                    '2019-2022 : Senior Electrical Engineer PT. Basara Hydro Power',
                    '2016-2019 : Junior Electrical Engineer PT. Basara Hydro Power'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/muhammad-ridho-dewanto-1b9b7531/',
                    'https://scholar.google.com/citations?user=5bhZNUgAAAAJ&hl=id&authuser=1'
                ]
            ],

            [
                'name' => 'Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D.',
                'nip' => '198907102022031005',
                'type' => 'Dosen',
                'structural_position' => 'Dekan Fakultas Sains dan Teknologi Informasi ITK',
                'functional_position' => 'Dosen Program Studi Teknik Elektro',
                'image_url' => 'https://drive.google.com/file/d/1Atkd4WgMaqaiWBZLDqtWE6RT2uaji68n/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro (Pengolahan Sinyal dan Elektronika) Universitas Gadjah Mada (UGM)',
                    'S2 Computer Engineering (Antennas and Propagation) King Mongkut’s Institute of Technology Ladkrabang (KMITL), Thailand',
                    'S3 Electrical and Electronic Engineering Newcastle University, United Kingdom'
                ],

                'expertise' => [
                    'Radio Frequency Identification (RFID)',
                    'Antennas and Propagation',
                    'Intelligent Sensing'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'INNOWAG: INNOvative monitoring and predictive maintenance solutions on lightweight WAGon 2016-2019 NewRail, Shift2Rail Joint Undertaking',
                    'Sistem Sensor Berbasis Radio Frequency Identification (RFID) untuk Pelacakan dan Monitoring Kualitas Produk Pangan Secara Non-invasif 2021. LPPM ITK',
                    'Project ARSS (Active Radial Suspension System) for rail vehicle 2019-2020 NewRail, LIEBHERR, RSSB (Rail Safety and Standards Board), UK',
                    'IoT-enabled fire detector 2020 KabelFree Ltd, ERDF (European Regional Development Fund)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2025 - Sekarang : Dekan Fakultas Sains dan Teknologi Informasi - ITK',
                    '2021 - 2025 : Kepala Unit Laboratorium Terpadu - ITK',
                    '2018 - 2020 : Research Associate at Newrail, Newcastle, UK',
                    '2015 - Sekarang : Lecturer in Institut Teknologi Kalimantan',
                    '2013 - 2015 : Research Assistant in Radio Frequency Electronics, Wireless Innovations and Security at National National Electronics and Computer Technology Center, Thailand'
                ],

                'awards' => [
                    'ISOC Best Poster Award - International SoC Design Conference 2024',
                    'Best paper Award on 4th Borneo International Conference (BICAME) 2022-Institut Teknologi Kalimantan',
                    'Best Paper Award Depolarizing Chipless RFID Sensor Tag for Characterization of Metal Cracks Based on Dual Resonance Features-Universitas Gadjah Mada',
                    'Second Place for Best Presentation in Intelligent Sensing and Comunications Group in the Electrical and Electronic Engineering-Newcastle University',
                    'Third Place for Best Paper in Intelligent Sensing and Communications Group in Electrical and Electronic Engineering-Newcastle University',
                    'First Place for Best Poster in the Communication, Sensors, Signal, and Information Processing Group-Newcastle University',
                    '2nd Position Award International Sensor and Measurements Student Contest-IEEE Instrumentation and Measurement Society'
                ],

                'academic_profiles' => [
                    'https://www.linkedin.com/in/adi-mahmud-jaya-marindra/',
                    'https://scholar.google.com/citations?user=CiO0e0sAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=55368219400'
                ]
            ],

            [
                'name' => 'Yun Tonce Kusuma Priyanto, S.T., M.T.',
                'nip' => '198406162012121001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Wakil Dekan Bidang Keuangan dan Umum Fakultas Sains dan Teknologi Informasi ITK',
                'image_url' => 'https://drive.google.com/file/d/1pHRiycTBPMuKy5dPMX0e9rtNk-EhwoC4/view?usp=sharing',

                'education_history' => [
                    'S1 Sarjana Sains di Departemen Matematika Institut Teknologi Sepuluh Nopember (ITS)',
                    'S2 Magister Sains di Departemen Matematika Institut Teknologi Sepuluh Nopember (ITS)'
                ],

                'expertise' => [
                    'Simulasi Sistem Tenaga'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'IbM Charging Station Telepon Genggam Bertenaga Surya untuk Penumpang Kapal Klotok Penyeberangan Balikpapan-Penajam (2016-2017)',
                    'Rancang Bangun Gasifier Sebagai Pendukung Pembangkit Listrik Tenaga Sampah (2016-2017)',
                    'Smart Meter untuk Monitoring Sistem Tiga Fasa Menggunakan Komunikasi IEEE 802.15.4 (2017-2018)',
                    'Instalasi kelistrikan cerdas menggunakan mikrokontroller berbasis Internet of Things (IoT) pada rumah sakit (2017-2018)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2025 - Sekarang: Wakil Dekan Bidang Keuangan dan Umum Fakultas Sains dan Teknologi Informasi - ITK',
                    '2016 - 2018: Koordinator Program Studi Teknik Elektro - ITK',
                    '2015 - Sekarang : Lecturer in Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://id.linkedin.com/in/yun-tonce-1a92884b',
                    'https://scholar.google.co.id/citations?user=JSkj07UAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=57053254600'
                ]
            ],

            [
                'name' => 'Andhika Giyantara, S.T., M.T.',
                'nip' => '198702242019031007',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektro',
                'image_url' => 'https://drive.google.com/file/d/1wvvmCge212Wppm8FaeDnYRd1X1C-WOO2/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro – Sistem Pengaturan Institut Teknologi Sepuluh Nopember, Surabaya',
                    'S2 Teknik Elektro – Sistem Pengaturan Institut Teknologi Sepuluh Nopember, Surabaya'
                ],

                'expertise' => [
                    'Control System'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Rancang Bangun Single Conveyor (2016)',
                    'Analisis Perbandingan Kecepatan dan Torsi pada Pengaturan Kecepatan Motor Induksi (2017)',
                    'Smart Meter untuk Monitoring Sistem Tiga Fasa Menggunakan Komunikasi IEEE 802.15.4 (2017-2018)',
                    'Analisis Ground Resistance Laboratorium Teknik Elektro sebagai Sistem Proteksi Arus Bocor (2018)',
                    'Self Balancing pada Robot Roda Dua dengan Menggunakan Inverted Pendulum (2018-2019)',
                    'Rancang Bangun Panel Surya berbasis Time Schedule (2018-2019)',
                    'Battery Management System, Pertamina - DPPU Sepinggan, Balikpapan & PT. Ruang Cipta Teknologi (2020)',
                    'Cooling Water Pump Control Systems, PT. PJB UBJOM PLTU Kaltim Teluk, Balikpapan & PT. Ruang Cipta Teknologi (2020)',
                    'Tank Level and Temperature Control Systems, PT. Kutai Refinery Nusantara (Apical Group), Balikpapan & PT. Ruang Cipta Teknologi (2020)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2016 – Sekarang: Dosen, Institut Teknologi Kalimantan',
                    '2009 – 2013: Electrical Engineer, PT Kaltim Prima Coal, Sangatta, Kalimantan Timur'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/andhika-giyantara-464b425b/?originalSubdomain=id',
                    'https://scholar.google.co.id/citations?user=zT-GacEAAAAJ&hl=en',
                    'https://www.scopus.com/authid/detail.uri?authorId=57193127979'
                ]
            ],

            [
                'name' => 'Barokatun Hasanah, S.T, M.T.',
                'nip' => '198802252019032017',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => '',
                'image_url' => 'https://drive.google.com/file/d/17vT_LrkG69JNQ3vGZza70TR_FWH0avKz/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Universitas Lampung',
                    'S2 Teknik Elektro Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Telecommunication'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Simulasi Jaringan WiMax menggunakan Opnet Modeler (2012)',
                    'Pengolahan Sinyal Radar (2015)',
                    'Aplikasi Bumbung Gelombang Lingkaran (2016)',
                    'Filter Bumbung Gelombang Lingkaran (2018)',
                    'Rancang Bangun Antena Mikrostrip Menggunakan Material Dielektrik Buatan (2019)',
                    'Heart Beat Monitoring (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017 – Sekarang: Dosen Teknik Elektro, Institut Teknologi Kalimantan',
                    '2016 – 2017: Staf Pengajar, Universitas Komputer Indonesia',
                    '2013 – 2014: Staf Pengajar, Universitas Teknokrat'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/barokatun-hasanah-3829a8185/?originalSubdomain=id',
                    'https://scholar.google.co.id/citations?user=qKxwguwAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=57188567669'
                ]
            ],

            [
                'name' => 'Firilia Filiana, S.T, M.T',
                'nip' => '199404022019032031',
                'type' => 'Dosen',
                'structural_position' => 'Kepala Pusat TPB dan MKU',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/10TAr7F7H0gQ-G9t3Ye7ZMp8tPV2Z0Gye/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Elektro Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Power System'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Implementasi Band Pass Filter Menggunakan Circular Waveguide berbasis Resonator Dielektrik Artifisial untuk Mode Propagasi Transfer Elektrik (2018)',
                    'Analisis Penggunaan Rele Proteksi sebagai Pengaman Peralatan dan Penentuan PPE pada Jaringan Distribusi Akibat Gangguan Hubung Singkat (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017 – Sekarang: Dosen Teknik Elektro, Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Happy Aprillia, S.ST., M.T., M.Eng.,Ph.D.',
                'nip' => '199104112020122004',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Kepala Pusat Pengembangan Pendidikan',
                'image_url' => 'https://drive.google.com/file/d/1lyu_i_IscO5QBhI-NvC90qAJ243Y0cKM/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Industri Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Sistem Tenaga Institut Teknologi Sepuluh Nopember - Energy Asian Institute of Technology, Thailand',
                    'S3 Electrical Engineering National Cheng Kung University'
                ],

                'expertise' => [
                    'Load Forecasting',
                    'Power Quality',
                    'Artificial Intelligent'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Sustainable Design of Electrical Installation at Campus of Institut Teknologi Kalimantan, PT. Duta Fuji Electric - PT. Pandu Persada (2020-2021)',
                    'Intelligent Forecast and Analysis Technique for Renewable Energy System Project, Ministry of Science and Technology (MOST), Taiwan, TWD (2019-2020)',
                    'NCKU and Delta Electronics 2018 Joint Research Program, MOST Taiwan (2017-2019)',
                    'Power Quality Improvement of Transmission and Distribution System and Development and Operation Planning of Substituting Transmission Technology MOST, Taiwan - Delta Electronics (2016-2017)',
                    'Implementation of Wireless Sensor Infrastructure on Water Consumption and Quality in Monitoring System of Residence (2016-2017)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2016 – Sekarang: Adjunct Assistant (Asisten Tambahan), Energy and Power System Laboratory – Electrical Engineering NCKU',
                    '2015 – Sekarang: Dosen Tetap PNS, Institut Teknologi Kalimantan',
                    '2015: Dosen Kontrak, Jurusan Maritim, Politeknik Negeri Samarinda'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/happy-aprillia-505351112/',
                    'https://scholar.google.co.id/citations?user=OyXLb04AAAAJ&hl=en',
                    'https://www.scopus.com/authid/detail.uri?authorId=57194449286'
                ]
            ],

            [
                'name' => 'Himawan Wicaksono, S.ST.,M.T.',
                'nip' => '198904012021211002',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Kepala Inkubator Bisnis Teknologi',
                'image_url' => 'https://drive.google.com/file/d/1oyaWa0JomREWftRgunfxP_-MqxnG8sNP/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro - Politeknik Elektronik Negeri Surabaya',
                    'S2 Teknik Elektro - Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Computer System',
                    'Computer Vision'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Pengembangan Instrumen Perekam Penggunaan Kecepatan Dan Kemiringan Jalan Kendaraan Bermotor (2021)',
                    'Evaluasi Objektif Performa OpenBTS Blade RF XA-40 Dengan Metode PESQ (Perceptual Evaluation Of Speech Quality) (2021)',
                    'Pembuatan Kursi Roda Elektrik Untuk Penyandang Disabilitas Di RT.36 Kelurahan Telagasari (2021)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2015 – Sekarang: Lecturer, Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Kharis Sugiarto, SST.,M.T.',
                'nip' => '199202022022031014',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Teknik Elektro',
                'functional_position' => 'Dosen Program Studi Teknik Elektro',
                'image_url' => 'https://drive.google.com/file/d/185UYSIE346TnrxymI_-cIM-QgTayK6zZ/view?usp=sharing',

                'education_history' => [
                    'D4 Teknik Elektronika, Politeknik Negeri Malang',
                    'S2 Teknik Elektro, Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Teknik Elektronika',
                    'Sensor dan Transduser Industri'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Utilization of Used Mineral Water Bottles as Hydroponic Vegetable Planting Media (Hidro-Bokas) in Damai Baru Village, (2020-2021)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2020 - Sekarang: Lecturer in Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Mifta Nur Farid, S.T., M.T.',
                'nip' => '199107152022031007',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1SRN_ZGS56dkyH8u24Dpwywe3Fp_l4Cmz/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Fisika Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Fisika Rekayasa Instrumentasi Industri Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Signal Processing'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Railway Vibration and Noise Control at KRL-KFW (2016-2017)',
                    'Dereverberation Binaural Source Separation Using Deep Learning (2016-2018)',
                    'Spectrum Analysis of Horn (2018)',
                    'Noise Reduction and Speech Separation of Mixture Speech (2018-2019)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2018 – Sekarang: Lecturer, Institut Teknologi Kalimantan',
                    '2018: Audio Signal Processing Engineer, WarungPintar'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Mudeng, Vicky Vendy Hengki, S.T., M.Sc',
                'nip' => '199207302019031009',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1xRD4BROtSPRIMQMvnh0vdri6vp240iZ0/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Universitas Brawijaya',
                    'S2 Mechanical Engineering National Central University'
                ],

                'expertise' => [
                    'Teknik Elektronika'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Three Dimensional Diffuse Optical Imaging (2016-2017)',
                    'Continuous Wave Diffuse Optical Tomography for Agricultural ( 2018)',
                    'Frequency Domain Diffuse Optical Tomography (2018)',
                    'Pengembangan Sensor Tegangan Satu Fasa (2018)',
                    'Pengiriman data mikrokontroler (2018)',
                    'Self Balancing Robot (2019)',
                    'Heart Beat Monitoring (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017 – Sekarang: Dosen Teknik Elektro, Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/vicky-mudeng-a6357a80/?originalSubdomain=id',
                    'https://scholar.google.co.id/citations?user=T4ZYOPUAAAAJ&hl=id',
                    'https://www.scopus.com/authid/detail.uri?authorId=57196216809'
                ]
            ],

            [
                'name' => 'Muhammad Agung Nursyeha, S.T., M.T.',
                'nip' => '199203282022031007',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1l5yoxG4IQyB5AIEzKaSJasaqZ1SYxjMJ/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Institut Teknologi Sepuluh November',
                    'S2 Teknik Elektro Institut Teknologi Sepuluh November'
                ],

                'expertise' => [
                    'Neural Network',
                    'Robot'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Swarm Robot for Gas Leak Localization, Institut Teknologi Sepuluh Nopember',
                    'Spiking Neural Network, Institut Teknologi Sepuluh Nopember'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2020 – Sekarang: Lecturer in Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Risty Jayanti Yuniar,S.T.,M.T.',
                'nip' => '198807282022032007',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1KwFBk_jTRDdLKuG0nuZf-4wVzh0e58Kd/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Universitas Brawijaya',
                    'S2 Teknik Elektro Universitas Brawijaya'
                ],

                'expertise' => [
                    'Control System'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Rancang Bangun Sistem Pembangkit Listrik Tenaga Sampah Type Incenerator Dengan Kontroler PID Optimal'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2020 – Sekarang: Lecturer in Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Riza Hadi Saputra, S.T., M.T',
                'nip' => '199201142022031009',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1aSCEvJh1tWyimbAooq5ki02P-rLM8lz4/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Fisika (Instrumentasi dan Kontrol) Universitas Telkom',
                    'S2 Teknik Fisika (Otomasi Proses Industri) Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Control System',
                    'Renewable Energy'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Estimasi State-Of-Charge Pada Baterai Lithium-Ion Menggunakan Metode Perhitungan Coulomb (2022)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2022 – Sekarang: Lecturer, Institut Teknologi Kalimantan',
                    '2017 – 2022: Lecturer, STT Migas Balikpapan'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/riza-hadi-saputra-55684b105/',
                    'https://scholar.google.com/citations?user=SV4lVIsAAAAJ&hl=en',
                    'https://www.scopus.com/authid/detail.uri?authorId=57190381334'
                ]
            ],

            [
                'name' => 'Sena Sukmananda Suprapto, S.T, M.T.',
                'nip' => '199209122019031021',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1SNp132xJwGolWVORvh61EyTJSwmI19pY/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Fisika Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Elektro Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Electronics'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Pengukuran Spesifikasi dari Linqstat (Pressure-Resistive Sensor) (2017)',
                    'Perancangan Eyesight Tracker untuk Optimazing Athlete Training (2018)',
                    'Perancangan Humanoid Robot untuk KRTI (2019)',
                    'Ekstraksi Terjemahan Murratal Al-Qur\'an menggunakan Fundamental Frequency Estimation (2019)',
                    'Low-cost Digital Payment Vending Machine, PT. Interaktif Internasional (2021-2022)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017 – Sekarang: Lecturer, Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Thorikul Huda, S.T., M.T.',
                'nip' => '198805152018031001',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1BhFvopaiM3T2pZ2C-icWvRjT0YjnDwCS/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Elektro Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Control System'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Unmanned Aerial Vehicle (UAV) (2011)',
                    'Design of Radial Basis Function Network and State-Dependent LQT for Path Planning and Tracking of Autonomous Underwater Vehicle (AUV) to Intercept A Moving Target (2015)',
                    'Desain and Implementation Brushless DC Motor 500Watt (2017)',
                    'Desain and Implementation Surface Unmanned Vehicle (SUV) (2017)',
                    'Desain and Implementation Bionic Arm using open source (3D Printer) (2019)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2016 – Sekarang: Dosen Teknik Elektro, Institut Teknologi Kalimantan',
                    '2013 – 2016: PT Damar Putera Perkasa',
                    '2013: PT Simentari Abdhi Bina',
                    '2010 – 2013: PT Sari Alun',
                    '2009 – 2010: PT Maxxima Innovative Engineering'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Vicky Andria Kusuma, S.ST., M.T.',
                'nip' => '100118153',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Elektronika',
                'image_url' => 'https://drive.google.com/file/d/1ed8X3EQFW2YwJmkmZuG4S65yO72KexS3/view?usp=sharing',

                'education_history' => [
                    'S1 Elektro Industri Politeknik Elektronika Negeri Surabaya (PENS)',
                    'S2 Power Sistem Tenaga Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Power System Analysis'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Rancang Bangun Vending Machine dengan Verifikasi Pembayaran Otomatis Berbasis Quick Response Code Indonesian Standard (QRIS) sebagai Inovasi di Bidang Smart Economy, QRIS Id (2021 - Sekarang)',
                    'Power to the People: An Integrated Approach for Governance Innovation Through Local Energy Initiatives for Urban Coastal Communities in Indonesia. Case studies Semarang and Balikpapan (2022 - Sekarang)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2017 – Sekarang: Dosen Teknik Elektro, Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Nisa Rizqiya Fadhliana, S.Kom., M.T',
                'nip' => '198804102019032000',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Teknik Informatika',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1hTIJwPOMOsrUuS6bLEjtXcCNF_6gXojz/view?usp=sharing',

                'education_history' => [
                    'S1 Ilmu Komputer, Universitas Mulawarman',
                    'S2 Jaringan Cerdas Multimedia (Game Technology), Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Human Computer Interaction'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Pengembangan Prototipe Smart Quail Coop Berbasis Microcontroller untuk Mengurangi Potensi Stress Pada Puyuh'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Lecturer on Politeknik Pertanian Negeri Samarinda (Dept. Software Engineering)',
                    'Lecturer on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Boby Mugi Pratama, S.Si, M.Han.',
                'nip' => '199408082022031007',
                'type' => 'Dosen',
                'structural_position' => 'Kepala Laboratorium Sistem Cerdas',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1MOUxBfaFNTE6nt_OhPYo-bxJZuTFIdCa/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika, Universitas Brawijaya',
                    'S2 Teknologi Penginderaan, Universitas Pertahanan'
                ],

                'expertise' => [
                    'Remote Sensing',
                    'Machine Learning'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Deep learning-based object detection and geographic coordinate estimation system for GeoTiff imagery',
                    'Sistem Sensor Berbasis Radio Frequency Identification (RFID) Untuk Pelacakan Dan Monitoring Kualitas Produk Pangan Secara Non-Invasif',
                    'Purwarupa Kapal Tanpa Awak Dengan Sistem Penghindar Rintangan Pada Siang Hari Berbasis Deteksi Saliensi Citra RGB',
                    'Prototipe Smart Relay Box Untuk Automatic Switching Pada Georesistivity Meter Naniura Nrd-300'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Physics Laboratory Staff on Institut Teknologi Kalimantan',
                    'Lecturer of Informatics on Institut Teknologi Kalimantan',
                    'Secretary of Quality Assurance Center on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Bima Prihasto, Ph.D.',
                'nip' => '199104232025061007',
                'type' => 'Dosen',
                'structural_position' => 'Koordinator Program Studi Magister Manajemen Teknologi',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1RkYf8JWlY83AoNQDpYfcxr4_ndxy9CSa/view?usp=sharing',

                'education_history' => [
                    'S1 Mathematics, Institut Teknologi Sepuluh Nopember, Indonesia',
                    'S2 Mathematics, Institut Teknologi Sepuluh Nopember, Indonesia',
                    'S3 Computer Science and Information Engineering, National Central University, Taiwan'
                ],

                'expertise' => [
                    'Machine Learning & Deep Learning',
                    'Audio and Speech Processing',
                    'Computer Vision',
                    'Data Science'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Real-time Voice Cloning using Long Short-term Memory for Stroke Patients with Symptoms of Speech Difficulty. 2021',
                    'Non-parallel Voice Conversion, Deep Learning Media System Laborator, National Central University, Taiwan, 2022',
                    'Biometrics system via Iris, Face recognition, Speech synthesis, Voice conversion. 2017-2023',
                    'Spoofing-aware speaker verification systems, 2022-2023',
                    'Optimization of Speech Synthesis Using Gated Recurrent Network and Generative Adversarial Network, 2020-2021'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2015 - Sekarang : Lecturer, Department of Informatics, Institut Teknologi Kalimantan, Indonesia',
                    '2022 - 2023 : Research Assistant, Academia Sinica, Taiwan',
                    '2012-2014 : Assistant Lecturer, Department of Mathematics, Institut Teknologi Sepuluh Nopember Surabaya, Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => [
                    'https://www.linkedin.com/in/bima-prihasto-ph-d-575075a6/',
                    'https://scholar.google.com/citations?user=AAhL8J8AAAAJ&hl=en',
                    'https://www.scopus.com/authid/detail.uri?authorId=57190864340'
                ]
            ],

            [
                'name' => 'Aninditya Anggari Nuryono, S.T., M.Eng.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1I741T4zMxns5IcMCpDHnu3y2Qn0oU3hY/view?usp=sharing',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Ariyadi, S.ST., M.T.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1jHUeFcmsNKYvCTsD-JOphdcL-IVUfTxO/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika, Politeknik Elektronika Negeri Surabaya',
                    'S2 Jaringan Cerdas Multimedia, Institut Teknologi Sepuluh Nopember',
                    'S3 Computational Medicine Laboratory, Kumoh National Institute of Technology, South Korea'
                ],

                'expertise' => [
                    'Artificial Intelligence',
                    'Adaptive Agents',
                    'Game Technology',
                    'Immersive Environment'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'sentrAI: Visual Assistive for Visually Impaired People based on Object-to-Audio using Transfer Learning (2020-2021)',
                    'Pengembangan Prototipe Smart Quail Coop Berbasis Microcontroller Untuk Mengurangi Potensi Stress Pada Puyuh (Smart Quail Coop Development using Microcontroller for Stress Monitoring on Quail) (2020-2021)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2022-Sekarang: Faculty Secretary, School of Mathematics and Information Technology Institut Teknologi Kalimantan, Indonesia',
                    '2015-Sekarang: Lecturer, Department of Mathematics and Information Technology Institut Teknologi Kalimantan, Indonesia',
                    '2019-2022: Head of Informatics Department Institut Teknologi Kalimantan, Indonesia',
                    '2010: Data Entry Jawa Post Institute Pro Otonom, Samarinda, Indonesia',
                    '2009: IT Support PT. Trakindo Utama, Samarinda, Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Bowo Nugroho, S.Kom., M.Eng.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/10rmJdaMZZREWFMjUZTuf3kz6--9HK0rd/view?usp=sharing',

                'education_history' => [
                    'S1 Informatics Engineering, STMIK AMIKOM',
                    'S2 Electrical Engineering, Universitas Gadjah Mada'
                ],

                'expertise' => [
                    'Software Enginering',
                    'Computer Vision'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Prototipe Big Data Cluster Berbasis Mikrokontroler Untuk Edukasi'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Java Programmer at PT Gameloft Indonesia',
                    'Lecturer of Informatics on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Darmansyah, S.Si., M.Ti.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1FkzJmHos28S2udFL_ePVd7tIl8bihdYo/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika, Universitas Hasanuddin',
                    'S2 Ilmu Komputer, Universitas Bina Nusantara'
                ],

                'expertise' => [
                    'Data Mining'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Data Mining Performance of Toddler Nutrition Classification Based on Family Nutrition Awareness and Human Development Index'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Head Master of SMK Bina Prestasi Balikpapan',
                    'IT Support on STMIK Borneo International',
                    'Lecturer on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Muchammad Chandra Cahyo Utomo, M.Kom.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1nIUsmwEz1kxhOGPgOnfYutw3rZldso8y/view?usp=sharing',

                'education_history' => [
                    'S1 Ilmu Komputer, Universitas Brawijaya',
                    'S2 Ilmu Komputer, Universitas Brawijaya'
                ],

                'expertise' => [
                    'Fuzzy Inference System',
                    'Fuzzy Neural Networks',
                    'Evolution Strategies'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Comparison and Develop A Quiz Platform for College'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Lecturer on Universitas Nahdlatul Ulama Sunan Giri Bojonegoro',
                    'Lecturer on Institut Teknologi Kalimantan',
                    'Elearning Center Coordinator on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Nur Fajri Azhar, S.Kom., M.Kom.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1b7uXxyYuPNkQoDP7azWtIT0lQRdoDzSV/view?usp=sharing',

                'education_history' => [
                    'S1 Ilmu Komputer, Universitas Muhammadiyah Malang',
                    'S2 Teknik Informatika, Institut Teknologi Sepuluh Nopember'
                ],

                'expertise' => [
                    'Software Engineering',
                    'Pemrograman Web'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Pembuatan Sistem Informasi Capaian Gotong Royong Masyarakat Kecamatan Balikpapan Utara (2020-2021)',
                    'Evolusi Sistem Informasi Penerimaan Mahasiswa Baru Jalur Mandiri (SUMMIT ITK) Institut Teknologi Kalimantan (2020-2021)',
                    'Pengembangan Smart Service Village System (SSVS) Dalam Mendukung Smart Governance Menggunakan Metode Personal Extreme Programming (2020-2021)',
                    'Optimasi Speech Synthesis Menggunakan Gated Recurrent Network Dan Generative Adversarial Network Untuk Penggunaan Bahasa Indonesia Berbasis Web (2019-2020)',
                    'Otomatisasi Diagnosa Penyakit Padi Berbasis Smartphone Menggunakan Metode Convolutional Neural Network (2019-2020)',
                    'Evolusi Sistem Informasi Penelitian Dan Pengabdian Masyarakat (SIMPAS LPPM) Institut Teknologi Kalimantan (2019-2020)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Wakil Kepala ICT Universitas Balikpapan',
                    'Kepala ICT Universitas Balikpapan',
                    'Lecturer on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Ramadhan Paninggalih S.Si., M.Si., M.Sc.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1XuXGFyOpf1_Iq0QbnLM2zbW7irG085Q_/view?usp=sharing',

                'education_history' => [
                    'S1 Matematika, Universitas Brawijaya',
                    'S2 Ilmu Komputer Kanazawa & Ilmu Komputer Institut Teknologi Bandung'
                ],

                'expertise' => [
                    'Applied Science',
                    'Data Science'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Microcontroller Based Big Data Cluster Prototype For Education'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Lecturer of Informatics on Institut Teknologi Kalimantan'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Riska Kurniyanto Abdullah, S.T., M.Kom.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1DWpNdSZN5v8KAZSmjgNCwWglVICYbXOo/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro, Institut Teknologi Sepuluh Nopember',
                    'S2 Informatika, Universitas AMIKOM Yogyakarta'
                ],

                'expertise' => [
                    'Internet of Things',
                    'Python Backend',
                    'DevOps',
                    'Software Engineering'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Prototipe Big Data Cluster Berbasis Mikrokontroler Untuk Edukasi (Microcontroller Based Big Data Cluster Prototype For Education) (2021)',
                    'iPorang - Pengembangan Artificial Intelligence of Things (AIoT) untuk pemantauan nutrisi tanaman porang (iPorang - Development of Artificial Intelligence of Things (AIoT) for monitoring porang plant nutrition) (2021)',
                    'sentrAI: Visual Asistif untuk Tunanetra berbasis Object-to-Audio dengan metode Transfer Learning (Visual Assistive for the Blind, Object-to-Audio-based with Transfer Learning method). (2021)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2014-2019: Dosen Teknik Elektro - Universitas Ichsan Gorontalo'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Gusti Ahmad Fanshuri Alfarisy, S.Kom., M.Kom.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1IYJmIMzSXqBcq6etz4Ej4HDuVAp0sQgf/view?usp=sharing',

                'education_history' => [
                    'S1 Ilmu Komputer, Universitas Brawijaya',
                    'S2 Ilmu Komputer, Universitas Brawijaya',
                    'S3 Computer Science, Universiti Brunei Darussalam'
                ],

                'expertise' => [
                    'Optimasi',
                    'Jaringan Syaraf Tiruan',
                    'Kecerdasan Web',
                    'Sistem Cerdas'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Course Schedule Optimization using Modified Genetic Algorithms (2019-2020)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    'Developer',
                    'GEMSS Solution Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Rizal Kusuma Putra, M.T.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1aZkM_glhPDVaEGscNRlbLGB5Naf0XAJD/view?usp=sharing',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Rizky Amelia, S.Si., M.Han.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/18TC7r-65uAP4tPKkz5iRjV-nOJpupCTh/view?usp=sharing',

                'education_history' => [
                    'S1 Fisika, Institut Pertanian Bogor',
                    'S2 Teknologi Penginderaan, Universitas Pertahanan'
                ],

                'expertise' => [
                    'Remote Sensing',
                    'Machine Learning',
                    'Internet of Thing'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Improving The Implementation of Google Earth Engine (GEE) based of Multiresolution Satellite Image for Identification of Sea Surface Objects on Sunda Straits to Support National Defense',
                    'Flood-prone Area Modelling with Pairwase Comparison Method in South Sumatra',
                    'Pembuatan Nanokomposit Karbon-Mn02, Limbah Baterai untuk Aplikasi Elektroda Superkapasitor'
                ],

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Syamsul Mujahidin, S.Kom., M.Eng',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1mnY_ZsF7ml9mq2dEQ81jSUw3BeWbZGqv/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Informatika, Universitas Islam Indonesia',
                    'S2 Teknik Elektro dan Teknologi Informasi, Universitas Gadjah Mada',
                    'S3 Graduate School of Innovation and Practice for Smart Society, Hiroshima University, Japan'
                ],

                'expertise' => [
                    'Image Processing',
                    'Computer Vission'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Automation of Rice Disease Diagnosis based on Smartphone using Convolutional Neural Network',
                    'Visual Assistive for the Blind People based on Object-to-Audio using Transfer Learning'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2021: Anggota APTIKOM'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Tegar Palyus Fiqar, S.T., M.Kom.',
                'nip' => '',
                'type' => 'Dosen',
                'structural_position' => '',
                'functional_position' => 'Dosen Program Studi Teknik Informatika',
                'image_url' => 'https://drive.google.com/file/d/1IjZm8AoQeDjhRZS9F5y-m7gibJwB6LSS/view?usp=sharing',

                'education_history' => [
                    'S1 Teknik Elektro, Institut Teknologi Sepuluh Nopember',
                    'S2 Teknik Informatika, Institut Teknologi Sepuluh Nopember',
                    'S3 Graduate School of Innovation and Practice for Smart Society, Hiroshima University, Japan'
                ],

                'expertise' => [
                    'Image Processing',
                    'Computer Vision',
                    'Embedded System',
                    'Data Security'
                ],

                'competency_certification' => null,

                'research_history' => [
                    'Pengembangan Metode Adaptif Payload Audio Data Hiding Berbasis Lagrange Intepolasi Polinomial dan Newton’s Divided-Difference Interpolasi Polinomial (2019)',
                    'Perancangan Arsitektur Sistem dan Teknologi Informasi untuk Organisasi Perangkat Daerah (OPD) Pemerintah Kota Balikpapan menggunakan TOGAF (The Open Group Architecture Framework) (2019)',
                    'Rancang Bangun Sistem Informasi Pencatatan, Pelaporan serta Monitoring Bulan imunisasi Anak Sekolah (BIAS) pada Dinas Kesehatan (2020)'
                ],

                'community_service_history' => null,

                'work_experience' => [
                    '2013: Apps Developer, PT Niltava Teknologi Indonesia, Surabaya, Indonesia',
                    '2011: Internship, Pusat Robotika Institut Teknologi Sepuluh Nopember (ITS), Surabaya, Indonesia'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Desy Ridho Rahayu, S.Si.',
                'nip' => '199112212019032018',
                'type' => 'Tendik',
                'structural_position' => 'Kepala Subbagian Umum Fakultas Sains dan Teknologi Informasi ITK',
                'functional_position' => '',
                'image_url' => 'https://drive.google.com/file/d/1A9ciaHc8maTIRrEg-N4L0CGCbyH9m2Hv/view?usp=sharing',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Mufida Fatma Ayuningtyas, A.Md',
                'nip' => '199906012025212044',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Akademik dan Kemahasiswaan',
                'image_url' => 'https://drive.google.com/file/d/1c3E1LjgY-MafE1vrm7iIV30pG4y8cdJD/view?usp=drive_link',

                'education_history' => [
                    'D-III'
                ],

                'expertise' => null,

                'competency_certification' => [
                    'Sertifikat Pelayanan Prima'
                ],

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    'Pada Tahun 2022-2024 Staff Kemahasiswaan dan Alumni'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Elvi Yuningsih, S.M.',
                'nip' => '',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Akademik dan Kemahasiswaan',
                'image_url' => 'https://drive.google.com/file/d/1HMy17Pzhv_LU8NpbScuzXq2mH1rQPxVJ/view?usp=drive_link',

                'education_history' => [
                    'S1 Manajemen'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Aldian Putri Dwiyhana, S.Sos.',
                'nip' => '198711272021212001',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Perencanaan dan Keuangan',
                'image_url' => '',

                'education_history' => [
                    'S1 Administrasi Negara FISIP UNMUL'
                ],

                'expertise' => null,

                'competency_certification' => [
                    'Kewajiban Perpajakan Bagi Instansi Pemerintah Serta Pedoman Pengelolaan Perpajakan Bagi Bendahara Pemerintah'
                ],

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    '2016-2017 tendik Teknik Perkapalan, 2017-2019 Tendik Teknik Perkapalan & Teknik Kelautan, 2019-2024 Tendik JSTPK, 2025-Sekarang Tendik FSTI'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Dwitami Sekarini, S.Pd',
                'nip' => '',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Perencanaan dan Keuangan',
                'image_url' => '',

                'education_history' => null,

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Reza Nouryan Rachman, S.Kom',
                'nip' => '199711122025211037',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Umum dan Kepegawaian',
                'image_url' => 'https://drive.google.com/file/d/1dHrpUUM4BrvyG8LAH-uJe3MBH9Ur9nOS/view',

                'education_history' => [
                    'Universitas Islam Indonesia - S1 Informatika (2016-2020)'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    'Staff Tendik Pusat Pengembangan Pendidikan ITK (2022-2024)'
                ],

                'awards' => null,

                'academic_profiles' => null,
            ],

            [
                'name' => 'Luh Appucha Pandu Liyanty, S.Ikom',
                'nip' => '199708142025212041',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Akademik dan Kemahasiswaan Program Magister',
                'image_url' => 'https://drive.google.com/file/d/1efL42bm-RzF6hmpR39lr6XdqGx1mzFEL/view',

                'education_history' => [
                    'S1 Ilmu Komunikasi (S.Ikom)'
                ],

                'expertise' => null,

                'competency_certification' => [
                    'Sertifikasi BNSP-Digital Markerting'
                ],

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => [
                    'Staff Humas ITK'
                ],

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Yuda Fitria Hanifah, S.E',
                'nip' => '',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Akademik dan Kemahasiswaan',
                'image_url' => 'https://drive.google.com/file/d/1S0ir5erpP_TCE6q6k92y4bN6Ig3IR1kd/view?usp=sharing',

                'education_history' => [
                    'S1 Ekonomi'
                ],

                'expertise' => null,

                'competency_certification' => null,

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

            [
                'name' => 'Hanna Novita, S.Tr.Ak',
                'nip' => '',
                'type' => 'Tendik',
                'structural_position' => '',
                'functional_position' => 'Tenaga Kependidikan Perencanaan dan Keuangan',
                'image_url' => 'https://drive.google.com/file/d/1NazPIJDkn4bMbeJ_pSRK65gb2srjQTjd/view?usp=sharing',

                'education_history' => [
                    'D4 Akuntansi Perpajakan'
                ],

                'expertise' => null,

                'competency_certification' => [
                    'Sertifikat BNSP_Digital Marketing & Operator Komputer Muda'
                ],

                'research_history' => null,

                'community_service_history' => null,

                'work_experience' => null,

                'awards' => null,

                'academic_profiles' => null
            ],

        ];

        foreach ($dataCivitas as $data) {
            Staff::create($data);
        }
    }
}
