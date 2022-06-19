<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentences(3, true),
            'start_date' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+2 months'),
            'is_active' => $this->faker->boolean,
            'client_id' => Client::all()->random()->id,
            'user_id'   => User::all()->random()->id,
        ];
    }
}
