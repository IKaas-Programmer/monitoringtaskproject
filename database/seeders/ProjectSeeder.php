<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \App\Models\Project::create([
            'name' => 'Website Redesign',
            'description' => 'Redesign the corporate website to improve user experience and update branding.',
            'deadline' => now()->addMonths(3),
            'status' => 'on_progress',
            'user_id' => 1, // Assuming user with ID 1 exists
        ]);

        \App\Models\Project::create([
            'name' => 'Mobile App Monitoring',
            'description' => 'Aplikasi internal untuk tracking tugas',
            'deadline' => now()->addMonth(),
            'status' => 'planned',
            'user_id' => 1,
        ]);
    }
}