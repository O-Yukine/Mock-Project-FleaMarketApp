<?php

namespace Tests\Feature\Like;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_item()
    {
        $seller = User::factory()->create();
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/item/' . $product->id);
        $response->assertSee('data-like-count="0"', false);

        $this->assertDatabaseMissing('user_product_like', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        $this->post('/item/' . $product->id . '/like');

        $response = $this->get('/item/' . $product->id);
        $response->assertSee('data-like-count="1"', false);

        $this->assertDatabaseHas('user_product_like', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_button_image_changes_on_like_and_unlike()
    {

        $seller = User::factory()->create();
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);
        $product->likedBy()->attach($user->id);


        $this->actingAs($user);
        $response = $this->get('/item/' . $product->id);

        $response->assertSee('images/hart_like.png');
        $response->assertDontSee('images/hart_unlike.png');

        $this->post('/item/' . $product->id . '/like');

        $response = $this->get('/item/' . $product->id);

        $response->assertSee('images/hart_unlike.png');
        $response->assertDontSee('images/hart_like.png');
    }

    public function test_user_can_unlike_item()
    {

        $seller = User::factory()->create();
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $product->likedBy()->attach($user->id);

        $this->actingAs($user);

        $response = $this->get('/item/' . $product->id);
        $response->assertSee('data-like-count="1"', false);

        $this->assertDatabaseHas('user_product_like', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        $this->post('/item/' . $product->id . '/like');


        $response = $this->get('/item/' . $product->id);
        $response->assertSee('data-like-count="0"', false);

        $this->assertDatabaseMissing('user_product_like', [
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);
    }
}
