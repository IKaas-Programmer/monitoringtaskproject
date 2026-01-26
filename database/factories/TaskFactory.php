<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'completed']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'completed_at' => null, // Biarkan null secara default kecuali statusnya 'completed'
            'user_id' => \App\Models\User::first()?->id ?? \App\Models\User::factory(),
            // 'project_id' akan otomatis terisi jika dipanggil lewat factory Project
        ];
    }
}