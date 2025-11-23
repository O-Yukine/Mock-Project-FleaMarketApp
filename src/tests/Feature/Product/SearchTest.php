<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_search_items_without_fullName()
    {

        $product1 = Product::factory()->create([
            'name' => 'ショルダーバッグ',
        ]);

        $product2 = Product::factory()->create([
            'name' => 'ハンドバッグ',
        ]);

        $product3 = Product::factory()->create([
            'name' => '腕時計',
        ]);

        $response = $this->get('/?keyword=バッグ');
        $response->assertSee($product1->name);
        $response->assertSee($product2->name);
        $response->assertDontSee($product3->name);
    }

    public function test_search_results_are_preserved_when_switching_tabs()

    {
        $user = User::factory()->create();

        $product1 = Product::factory()->create([
            'name' => 'ショルダーバッグ',
        ]);
        $product2 = Product::factory()->create([
            'name' => 'ハンドバッグ',
        ]);
        $product3 = Product::factory()->create([
            'name' => '腕時計',
        ]);

        $user->likes()->attach([$product1->id, $product2->id, $product3->id]);

        $this->actingAs($user);

        $response = $this->get('/?tab=recommended&keyword=バッグ');
        $response->assertSee($product1->name);
        $response->assertSee($product2->name);
        $response->assertDontSee($product3->name);

        $response = $this->get('/?tab=mylist');
        $response->assertSee($product1->name);
        $response->assertSee($product2->name);
        $response->assertDontSee($product3->name);
    }
}
