<?php

namespace Tests\Feature\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_loginUser_can_comment()
    {
        $seller = User::factory()->create();
        $user = User::factory()->create();

        $product = Product::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($user);

        $this->assertDatabaseMissing('comments', [
            'user_id' => $user->id
        ]);

        $this->post('/item/' . $product->id . '/comment', [
            'comment' => 'とても素敵です！',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'とても素敵です！',

        ]);
    }
}
