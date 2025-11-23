<div>
    <select wire:model="paymentMethod" id="payment-method">
        <option value="">選択してください</option>
        <option value="convenience">コンビニ払い</option>
        <option value="credit">カード支払い</option>
    </select>

    <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">


</div>
