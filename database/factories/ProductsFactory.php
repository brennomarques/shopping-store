<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [
            'Arroz Tio Jorge',
            'Feijão Carioca',
            'Óleo de Soja',
            'Café da Roça',
            'Açúcar Cristal',
            'Farinha de Trigo',
            'Macarrão Espaguete',
            'Leite ninha',
            'Biscoito Recheado',
            'Sabonete Avon'
        ];

        return [
            'barcode' => $this->faker->unique()->isbn13,
            'name' => $this->faker->randomElement($names),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'qty_stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
