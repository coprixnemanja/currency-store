<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(20),
            'signature' => fake()->unique()->currencyCode(),
            'rate' => $this->faker->randomFloat(8, 0, 100),
            'surcharge' => $this->faker->randomFloat(2, 0, 100),
            'send_order_email' => $this->faker->boolean(),
            'discount' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
