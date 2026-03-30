<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database aplikasi.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        if (!User::where('email', 'admin@fsti.itk.ac.id')->exists()) {
            User::factory()->create([
                'name' => 'Admin FSTI',
                'email' => 'admin@fsti.itk.ac.id',
                'password' => bcrypt('admin123'),
                'is_superadmin' => true,
            ]);
            $this->command->info('Admin user created: admin@fsti.itk.ac.id / admin123');
        } else {
            $this->command->info('Admin user already exists, skipping...');
        }

        // 2. Buat Kategori Dasar Secara Otomatis
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik'],
            ['name' => 'Non Akademik', 'slug' => 'non-akademik'],
            ['name' => 'Kerjasama', 'slug' => 'kerjasama'],
        ];

        foreach ($categories as $cat) {
            PostCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
        $this->command->info('Post Categories seeded successfully.');

        // 3. Jalankan Seeder Lainnya
        $this->call([
            PostSeeder::class,
            AchievementSeeder::class,
            ProfileSeeder::class,
            PpidSeeder::class,
            IntegrityZoneSeeder::class,
            SurveyCategorySeeder::class,
            InternalServiceSeeder::class,
            ContactSeeder::class,
            TentangFakultasSeeder::class,
            StudyProgramSeeder::class,
        ]);
    }
}
