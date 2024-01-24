<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurrencyOrder>
 */
class CurrencyOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'currency_id' =>Currency::factory(),
            'rate' => $this->faker->randomFloat(8, 0, 100),
            'surcharge_percentage' => $this->faker->randomFloat(2, 0, 100),
            'surcharge_amount' => $this->faker->randomFloat(2, 0, 100),
            'amount_purchased'=> rand(20,1000),
            'amount_usd' => $this->faker->randomFloat(2, 0, 100),
            'discount_percentage' => $this->faker->randomFloat(2, 0, 100),
            'discount_amount' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
