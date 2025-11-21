<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class MylistTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_likedItem_is_showing()
    {
        $user = User::factory()->create();

        $likedItem = Product::factory()->create([
            'name' => 'ショルダーバッグ'
        ]);

        $user->likes()->attach($likedItem->id);

        $unlikedItem =  Product::factory()->create([
            'name' => '腕時計'
        ]);

        $this->actingAs($user);
        $responce = $this->get('/?tab=mylist');

        $responce->assertSee($likedItem->name);
        $responce->assertDontSee($unlikedItem->name);
    }

    public function test_purchased_item_shows_sold_tag_in_mylist()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $buyer = User::factory()->create();
        $buyer->likes()->attach($product->id);

        Purchase::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'payment_method' => 'card',
            'post_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => null
        ]);


        $this->actingAs($buyer);
        $response = $this->get('/?tab=mylist');
        $response->assertSee('sold');
    }

    public function test_guest_cannot_see_mylist()
    {
        $seller = User::factory()->create();
        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'name' => 'テスト商品'
        ]);

        $buyer = User::factory()->create();
        $buyer->likes()->attach($product->id);

        $response = $this->get('/?tab=mylist');
        $response->assertDontSee($product->name);
    }
}
