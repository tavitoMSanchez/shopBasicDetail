<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lexify('producto ???'),
            'description' => $this->faker->text(50),
            'price' => $this->faker->randomFloat(null, 600.01, 10.99),
            'levy' => $this->faker->randomFloat(null, 50.01, 10.99),
           
        ];
    }
}
