<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Meat', 'description' => 'Meat products'],
            ['name' => 'Vegetables', 'description' => 'Vegetable products'],
            ['name' => 'Fruits', 'description' => 'Fruit products'],
            ['name' => 'Grains', 'description' => 'Grain products'],
            ['name' => 'Dairy', 'description' => 'Dairy products'],
            ['name' => 'Beverages', 'description' => 'Beverage products'],
            ['name' => 'Snacks', 'description' => 'Snack products'],
            ['name' => 'Bakery', 'description' => 'Bakery products'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
