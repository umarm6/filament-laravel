<?php

namespace Database\Factories;

use App\Models\ProductColors;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductColorsFactory extends Factory
{
    protected $model = ProductColors::class;

    public function definition()
    {
        return [
            'name' => fake()->colorName(),
            'hex_code' => fake()->hexColor(),
        ];
    }
}
