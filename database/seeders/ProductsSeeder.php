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
                "description" => "25 TL kupon 2500 coin",
                "coin" => 2500,
                "image_url" => "https://logowik.com/content/uploads/images/trendyolcom2977.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Trendyol",
                "description" => "50 TL kupon 5000 coin",
                "coin" => 5000,
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
            ],
            [
                "name" => "Hepsiburada",
                "description" => "100 TL kupon 9500 coin",
                "coin" => 9500,
                "image_url" => "https://www.teknotalk.com/wp-content/uploads/2021/12/hepsiburada-logo.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Hepsiburada",
                "description" => "250 TL kupon 22000 coin",
                "coin" => 22000,
                "image_url" => "https://www.teknotalk.com/wp-content/uploads/2021/12/hepsiburada-logo.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Hepsiburada",
                "description" => "50 TL kupon 4500 coin",
                "coin" => 4500,
                "image_url" => "https://www.teknotalk.com/wp-content/uploads/2021/12/hepsiburada-logo.jpg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Amazon",
                "description" => "100 TL kupon 9000 coin",
                "coin" => 9000,
                "image_url" => "https://m.media-amazon.com/images/G/41/gc/designs/livepreview/amazon_dkblue_noto_email_v2016_tr-main._CB436417590_.png",
                "created_at" => now(),
                "updated_at" => now(),
            ],

            [
                "name" => "Amazon",
                "description" => "250 TL kupon 21000 coin",
                "coin" => 21000,
                "image_url" => "https://m.media-amazon.com/images/G/41/gc/designs/livepreview/amazon_dkblue_noto_email_v2016_tr-main._CB436417590_.png",
                "created_at" => now(),
                "updated_at" => now(),
            ],



        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}