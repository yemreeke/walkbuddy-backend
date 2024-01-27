<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoryAndCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 1');
        DB::table('sub_categories')->delete();
        DB::statement('ALTER TABLE sub_categories AUTO_INCREMENT = 1');

        $categoriesData = [
            [
                'name' => 'Örgü Modelleri',
                'sub_categories' => [
                    'Bere',
                    'Atkı',
                    'Yelek',
                    'Hırka',
                    'Bebek Yeleği',
                    'Patik',
                    'Şal',
                    'Süveter',
                    'Çanta',
                    'Süs',
                    'Anahtarlık',
                    'Kilim',
                    'Battaniye',
                    'Motifler',
                    'Eldiven',
                    'Yatak örtüsü',
                    'Kazak',
                    'Makrome',
                    'Toka Ve Saç Bandı',
                    "Diğer"
                ],
            ],
            [
                'name' => 'Oya Modelleri ',
                'sub_categories' => [
                    'Yazma Oyası',
                    'Tülbent Oyası',
                    'Havlu Oyası',
                    'Masa Örtüsü Oyası',
                    'Tığ işi Oya',
                    'Yastık Kılıfları',
                    "Diğer"
                ],
            ],
            [
                'name' => 'Amigurumi Modelleri',
                'sub_categories' => [
                    'Bebek Figürleri',
                    'Anahtarlık',
                    'Hayvan Figürleri',
                    'Kapı ve Oda Süsleri',
                    'Süs Meyve ve Sebzeler',
                    'Yastıklar',
                    'Çıngıraklar',
                    "Diğer",
                ],
            ],
            [
                'name' => 'Dantel Modelleri',
                'sub_categories' => [
                    'Dantel Masa Örtüleri',
                    'Dantel Mutfak Örtüleri',
                    'Dantel Yatak Örtüleri',
                    'Dantel Yastık Modelleri',
                    'Dantel Havlu Kenarı Modelleri',
                    "Diğer",
                ],
            ],
            [
                'name' => 'Diğer',
                'sub_categories' => [
                    "Diğer",
                ],
            ],
        ];

        foreach ($categoriesData as $categoryData) {
            $category = DB::table('categories')->insertGetId([
                'name' => $categoryData['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach ($categoryData['sub_categories'] as $name) {
                DB::table('sub_categories')->insert([
                    'category_id' => $category,
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


    }
}