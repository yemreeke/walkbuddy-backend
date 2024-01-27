<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->delete();
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
        $products = [
            [
                "name" => "Trendyol",
                "description" => "20 TL kupon 2000 coin",
                "coin" => 2000,
                "image_url" => "https://logowik.com/content/uploads/images/trendyolcom2977.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Trendyol",
                "description" => "30 TL kupon 3000 coin",
                "coin" => 3000,
                "image_url" => "https://logowik.com/content/uploads/images/trendyolcom2977.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Trendyol",
                "description" => "100 TL kupon 10000 coin",
                "coin" => 10000,
                "image_url" => "https://logowik.com/content/uploads/images/trendyolcom2977.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ]
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}