<?php

namespace Database\Factories;

use App\Models\ProductCategories;
use App\Models\ProductColors;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    protected $model = Products::class;

    public function definition()
    {
        return [
            'product_category_id' => ProductCategories::factory(),
            'name' => $this->faker->words(4, true),
            'description' => $this->faker->paragraph(),
            'product_color_id' => ProductColors::factory(),
         ];
    }
}
