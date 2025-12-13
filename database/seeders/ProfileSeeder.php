<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StaticPage;
use App\Models\Staff;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Static Pages (Visi Misi & Bagan)
        StaticPage::create([
            'key' => 'visi',
            'title' => 'Visi Fakultas',
            'content' => 'Pada tahun 2029, Fakultas Sains dan Teknologi Informasi (FSTI) ITK akan menjadi pusat keunggulan akademik dan inovasi, menghasilkan lulusan yang kompeten, adaptif, berdaya saing global, dan karya-karya dalam bidang sains dan teknologi informasi yang berdampak bagi kemajuan Kalimantan dan Indonesia.',
        ]);

        StaticPage::create([
            'key' => 'misi',
            'title' => 'Misi Fakultas',
            'content' => json_encode([
                [
                    'title' => 'Pendidikan Berkualitas',
                    'description' => 'Menyelenggarakan pendidikan tinggi yang berkualitas dan relevan dengan kebutuhan industri serta masyarakat di bidang sains dan teknologi informasi.'
                ],
                [
                    'title' => 'Penelitian Inovatif',
                    'description' => 'Melaksanakan penelitian dan pengembangan ilmu pengetahuan dan teknologi terapan yang inovatif dan berwawasan lingkungan.'
                ],
                [
                    'title' => 'Pengabdian Masyarakat',
                    'description' => 'Menyelenggarakan pengabdian kepada masyarakat yang berbasis pada hasil penelitian dan pengembangan ilmu pengetahuan dan teknologi terapan.'
                ],
                [
                    'title' => 'Kerjasama Strategis',
                    'description' => 'Membangun jejaring kerjasama yang kokoh dengan berbagai pihak, baik di tingkat nasional maupun internasional, untuk mendukung pelaksanaan tridharma perguruan tinggi.'
                ]
            ]),
        ]);

        StaticPage::create([
            'key' => 'bagan-organisasi',
            'title' => 'Bagan Organisasi FSTI',
            'image_path' => '/images/bagan-organisasi.webp',
        ]);

        // 2. Staff - Pimpinan Fakultas
        $pimpinan = [
            [
                'name' => 'Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D.',
                'position' => 'Dekan Fakultas Sains dan Teknologi Informasi',
                'image_path' => '/images/pimpinan-fakultas/dekan.png',
                'category' => 'Pimpinan Fakultas',
                'sort_order' => 1
            ],
            [
                'name' => 'Irma Fitria, S.Si., M.Si.',
                'position' => 'Wakil Dekan I (Akademik dan Kemahasiswaan)',
                'image_path' => '/images/pimpinan-fakultas/wd1.png',
                'category' => 'Pimpinan Fakultas',
                'sort_order' => 2
            ],
            [
                'name' => 'Yun Tonce Kusuma Priyanto, S.T., M.T.',
                'position' => 'Wakil Dekan II (Umum dan Keuangan)',
                'image_path' => '/images/pimpinan-fakultas/wd2.png',
                'category' => 'Pimpinan Fakultas',
                'sort_order' => 3
            ],
            [
                'name' => 'Desy Ridho Rahayu, S.Si',
                'position' => 'Kepala Sub Bagian Umum',
                'image_path' => '/images/pimpinan-fakultas/kasubbag.png',
                'category' => 'Pimpinan Fakultas',
                'sort_order' => 4
            ],
        ];

        foreach ($pimpinan as $p) {
            Staff::create($p);
        }

        // 3. Staff - Dosen
        $dosen = [
            ['name' => 'Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D.', 'prodi' => 'Teknik Elektro', 'jurusan' => 'Teknik Elektro, Informatika, dan Bisnis', 'image_path' => '/images/dosen/dosen-1.png', 'nip' => '198001012005011001', 'email' => 'adi.marindra@itk.ac.id'],
            ['name' => 'Irma Fitria, S.Si., M.Si.', 'prodi' => 'Sistem Informasi', 'jurusan' => 'Teknik Elektro, Informatika, dan Bisnis', 'image_path' => '/images/dosen/dosen-2.png', 'nip' => '198202022006022002', 'email' => 'irma.fitria@itk.ac.id'],
            ['name' => 'Febrian Dedi Sastrawan, S.Si., M.Sc', 'prodi' => 'Fisika', 'jurusan' => 'Sains dan Analitika Data', 'image_path' => '/images/dosen/dosen-1.png', 'nip' => '198503032008031003', 'email' => 'febrian.ds@itk.ac.id'],
            ['name' => 'Kartika Nugraheni, S.Si., M.Si.', 'prodi' => 'Matematika', 'jurusan' => 'Sains dan Analitika Data', 'image_path' => '/images/dosen/dosen-2.png', 'nip' => '198804042010042004', 'email' => 'kartika.n@itk.ac.id'],
            ['name' => 'Nisa Rizqiya Fadhliana, S.Kom., M.T', 'prodi' => 'Informatika', 'jurusan' => 'Teknik Elektro, Informatika, dan Bisnis', 'image_path' => '/images/dosen/dosen-1.png', 'nip' => '199005052012051005', 'email' => 'nisa.rf@itk.ac.id'],
            ['name' => 'Yun Tonce Kusuma Priyanto, S.T., M.T.', 'prodi' => 'Informatika', 'jurusan' => 'Teknik Elektro, Informatika, dan Bisnis', 'image_path' => '/images/dosen/dosen-2.png', 'nip' => '199106062014061006', 'email' => 'yun.tonce@itk.ac.id'],
            ['name' => 'Desy Ridho Rahayu, S.Si', 'prodi' => 'Fisika', 'jurusan' => 'Sains dan Analitika Data', 'image_path' => '/images/dosen/dosen-1.png', 'nip' => '199207072015072007', 'email' => 'desy.rr@itk.ac.id'],
            ['name' => 'Muhammad Azka, S.Si., M.Sc', 'prodi' => 'Ilmu Aktuaria', 'jurusan' => 'Sains dan Analitika Data', 'image_path' => '/images/dosen/dosen-2.png', 'nip' => '199308082016081008', 'email' => 'azka.m@itk.ac.id'],
            ['name' => 'Deli Yansyah, S.E., M.Acc., Ak., CA', 'prodi' => 'Bisnis Digital', 'jurusan' => 'Teknik Elektro, Informatika, dan Bisnis', 'image_path' => '/images/dosen/dosen-1.png', 'nip' => '199409092018092009', 'email' => 'deli.y@itk.ac.id'],
        ];

        foreach ($dosen as $index => $d) {
            $d['category'] = 'Dosen';
            $d['sort_order'] = $index + 1;
            Staff::create($d);
        }
    }
}
