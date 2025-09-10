<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    protected $model = Products::class;

    public function definition()
    {
        return [
            'name' => fake()->firstName(),
            'description' => fake()->paragraph(),
            'product_category_id' => fake()->randomElement([1,2,3]),
            'product_color_id' => fake()->randomElement([1,2,3]),
        ];
    }
}
