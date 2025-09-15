<?php

namespace Database\Seeders;

use App\Models\ProductCategories;
use App\Models\ProductColors;
use App\Models\Products;
use App\Models\ProductType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ProductColors::factory(10)->create();
        Products::factory()->count(10)->create();
        ProductType::factory()->count(5)->create();
        ProductCategories::all()->each(function ($category) {
            $category->productTypes()->attach(
                ProductType::inRandomOrder()->take(rand(1, 3))->pluck('id')
            );
        });
    }
}
