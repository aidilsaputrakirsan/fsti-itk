<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database aplikasi.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Default Admin User untuk testing
        User::factory()->create([
            'name' => 'Admin FSTI',
            'email' => 'admin@fsti.itk.ac.id',
            'password' => bcrypt('admin123'), // Password: admin123
            'is_superadmin' => true,
        ]);

        $this->call([
            PostSeeder::class,
            AchievementSeeder::class,
            ProfileSeeder::class,
        ]);
    }
}
