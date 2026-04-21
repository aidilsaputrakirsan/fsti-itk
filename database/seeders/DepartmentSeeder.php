<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Sains dan Analitika Data',
            'Teknik Elektro, Informatika, dan Bisnis'
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['name' => $dept],
                ['slug' => Str::slug($dept)]
            );
        }
    }
}