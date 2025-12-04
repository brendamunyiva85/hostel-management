<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hostel>
 */
class HostelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company() . ' Hostel',
            'type' => $this->faker->randomElement(['boys', 'girls', 'mixed']),
            'floors' => $this->faker->numberBetween(1, 5),
            'address' => $this->faker->address(),
        ];
    }
}
