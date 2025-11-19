<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::inRandomOrder()->take(5)->pluck('id')->toArray();

        $products = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'product_image' => 'clock.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'content' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition_id' => 1,
                'categories' => [1, 5],
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'product_image' => 'harddisk.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'content' => '高速で信頼性の高いハードディスク',
                'condition_id' => 2,
                'categories' => [3],
            ],

            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'product_image' => 'onion.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'content' => '新鮮な玉ねぎ3束のセット',
                'condition_id' => 3,
                'categories' => [10],
            ],

            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'product_image' => 'shoes.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'content' => 'クラシックなデザインの革靴',
                'condition_id' => 4,
                'categories' => [1, 5],
            ],

            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'product_image' => 'laptop.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'content' => '高性能なノートパソコン',
                'condition_id' => 1,
                'categories' => [2],

            ],

            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'product_image' => 'mic.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'content' => '高音質のレコーディング用マイク',
                'condition_id' => 2,
                'categories' => [2],
            ],

            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'product_image' => 'bag.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'content' => 'おしゃれなショルダーバッグ',
                'condition_id' => 3,
                'categories' => [1, 4, 12],
            ],

            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'product_image' => 'tumbler.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'content' => '使いやすいタンブラー',
                'condition_id' => 4,
                'categories' => [10],
            ],

            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'product_image' => 'coffee_grinder.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'content' => '手動のコーヒーミル',
                'condition_id' => 1,
                'categories' => [10],
            ],

            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'product_image' => 'makeup_set.jpg',
                // 'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'content' => '便利なメイクアップセット',
                'condition_id' => 3,
                'categories' => [1, 4, 6],
            ],
        ];

        foreach ($products as $item) {

            $userId = $userIds[array_rand($userIds)];

            $product = Product::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'brand' => $item['brand'],
                'product_image' => $item['product_image'],
                'content' => $item['content'],
                'condition_id' => $item['condition_id'],
                'user_id' => $userId,
            ]);

            $product->categories()->attach($item['categories']);
        };
    }
}
