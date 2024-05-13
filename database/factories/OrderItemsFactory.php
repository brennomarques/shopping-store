<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItems>
 */
class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $uniqueNumbers = $this->uniqueRandomNumber(1, 6, 6);
        return [
            'product_id' => $uniqueNumbers[$this->faker->numberBetween(0, 5)],
            'order_id' => $uniqueNumbers[$this->faker->numberBetween(0, 5)],
            'quantity' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }

    /**
     * Generates an array of unique numbers within a range.
     *
     * @param integer $min
     * @param integer $max
     * @param integer $count
     * @return array<int>
     */
    protected function uniqueRandomNumber(int $min, int $max, int $count): array
    {
        $numbers = range($min, $max);
        shuffle($numbers);

        return array_slice($numbers, 0, $count);
    }
}
