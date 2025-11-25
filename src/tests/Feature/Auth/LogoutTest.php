<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;


    public function test_loginuser_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->assertAuthenticated();

        $response = $this->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/login');
    }
}
