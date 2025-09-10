<?php

namespace Database\Factories;

use App\Models\ProductCategories;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategoriesFactory extends Factory
{
    protected $model = ProductCategories::class;

    public function definition()
    {
        return [
            'name'=> fake()->randomElement(['television','mobile','laptop','tablet']),
            'description'=> fake()->text(),
            'external_url'=> fake()->url(),
        ];
    }
}
