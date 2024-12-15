<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        // Insert multiple products into the products table
        foreach (range(1, 20) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'sku' => $faker->unique()->word,
                'category_id' => rand(1, 10), // Assuming 10 categories exist
                'supplier_id' => rand(1, 10), // Assuming 10 suppliers exist
                'quantity' => rand(1, 100),
                'price' => $faker->randomFloat(2, 10, 500),
                'cost' => $faker->randomFloat(2, 5, 300),
                'description' => $faker->sentence,
            ]);
        }
    }
}
