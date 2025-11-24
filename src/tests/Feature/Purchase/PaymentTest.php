<?php

namespace Tests\Feature\purchase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Livewire\Livewire;


class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_selected_payment_method_is_reflected_in_display()
    {

        Livewire::test('payment')
            ->set('paymentMethod', 'credit')
            ->assertSet('text', 'カード支払い');

        Livewire::test('payment-display')
            ->emit('paymentUpdated', 'カード支払い')
            ->assertSee('カード支払い');


        Livewire::test('payment')
            ->set('paymentMethod', 'convenience')
            ->assertSet('text', 'コンビニ払い');

        Livewire::test('payment-display')
            ->emit('paymentUpdated', 'コンビニ払い')
            ->assertSee('コンビニ払い');
    }
}
