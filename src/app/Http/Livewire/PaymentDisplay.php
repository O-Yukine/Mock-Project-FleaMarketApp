<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentDisplay extends Component
{
    public $text = '';

    protected $listeners = ['paymentUpdated' => 'updateText'];

    public function updateText($text)
    {
        $this->text = $text;
    }

    public function render()
    {
        return view('livewire.payment-display');
    }
}
