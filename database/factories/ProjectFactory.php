<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(2),
            'status' => $this->faker->randomElement(['planned', 'in_progress', 'completed']),
            'user_id' => \App\Models\User::first(['id'])?->id ?? \App\Models\User::factory(),
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
        ];
    }
}