<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = Category::all();

        foreach ($categories as $category) {
            $productCount = rand(22, 120);
            for ($i = 0; $i < $productCount; $i++) {
                Product::create([
                    'name' => $faker->word,
                    'description' => $faker->sentence,
                    'quantity' => $faker->numberBetween(10, 100),
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
