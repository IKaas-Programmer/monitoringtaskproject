<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $projects = \App\Models\Project::all();

        foreach ($projects as $project) {
            \App\Models\Task::create([
                'project_id' => $project->id,
                'user_id' => 1, // Assuming user with ID 1 exists
                'title' => 'Initial Task for ' . $project->name,
                'description' => 'This is the first task for the project: ' . $project->name,
                'priority' => 'high',
                'status' => 'completed',
                'due_date' => now()->addWeeks(2),
                'completed_at' => now(),
            ]);

            \App\Models\Task::create([
                'project_id' => $project->id,
                'user_id' => 1,
                'title' => 'Slicing UI Dashboard',
                'description' => 'Konversi desain Figma ke Tailwind',
                'priority' => 'medium',
                'status' => 'in_progress',
                'due_date' => now()->addMonths(1),
            ]);
        }
    }
}