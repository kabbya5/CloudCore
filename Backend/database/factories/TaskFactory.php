<?php

namespace Database\Factories;

use App\Models\User;
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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'priority' => $this->faker->randomElement(['low', 'high', 'medium']),
            'status' => $this->faker->randomElement(['pending', 'progress', 'completed']),
            'assigned_to' => User::inRandomOrder()->first()->id,
            'user_id' => User::factory(),
            // 'project_id' => Project::factory(),
        ];
    }
}
