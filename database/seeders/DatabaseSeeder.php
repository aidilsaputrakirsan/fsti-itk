<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database aplikasi.
     */
    public function run(): void
    {
        // Default Admin User untuk testing (skip jika sudah ada)
        if (!User::where('email', 'admin@fsti.itk.ac.id')->exists()) {
            User::factory()->create([
                'name' => 'Admin FSTI',
                'email' => 'admin@fsti.itk.ac.id',
                'password' => bcrypt('admin123'), // Password: admin123
                'is_superadmin' => true,
            ]);
            $this->command->info('Admin user created: admin@fsti.itk.ac.id / admin123');
        } else {
            $this->command->info('Admin user already exists, skipping...');
        }

        $this->call([
            PostSeeder::class,
            AchievementSeeder::class,
            ProfileSeeder::class,
        ]);
    }
}
