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

        $this->call([
            PostSeeder::class,
            AchievementSeeder::class,
            PpidSeeder::class,
            IntegrityZoneSeeder::class,
            SurveyCategorySeeder::class,
            InternalServiceSeeder::class,
            ContactSeeder::class,
            FacultyProfileSeeder::class,
            StudyProgramSeeder::class,
            StaffSeeder::class,
            StudentActivitySeeder::class,
            AgendaSeeder::class,
            ScholarshipSeeder::class,
            PartnerSeeder::class,
            AnnouncementSeeder::class,
            ResearchSeeder::class,
            AlumniSeeder::class,
            CommunityServiceSeeder::class,
            DepartmentSeeder::class,
            InternalServiceSeeder::class,
        ]);
    }
}
