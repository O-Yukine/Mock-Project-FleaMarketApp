<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Payment extends Component

{
    public $paymentMethod = '';
    public $text = '';

    public function updatedPaymentMethod($value)
    {
        $this->text = match ($value) {
            'convenience' => 'コンビニ払い',
            'credit' => 'カード支払い',
            default => ''
        };

        $this->emit('paymentUpdated', $this->text);
    }


    public function render()
    {
        return view('livewire.payment');
    }
}
