<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_number' => $this->faker->unique()->numerify('0#########'),
            'type' => $this->faker->randomElement(['savings', 'checking', 'investment']),
            'balance' => $this->faker->numberBetween(1000, 50000000),
            'status' => 'active',
        ];
    }
}