@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection
@section('content')
    <div class="order">
        <form class="form" action="/purchase/{{ $product->id }}" method="post">
            @csrf
            <div class="left-content">
                <div class="order-product">
                    <div class="order-image">
                        {{-- <img src="{{ url($product->product_image) }}" alt="{{ $product->name }}"> --}}
                        <img src="{{ asset('storage/product_images/' . $product->product_image) }}" alt="商品画像">
                    </div>
                    <div class="order-information">
                        <h3>{{ $product->name }}</h3>
                        <p>¥{{ $product->price }}</p>
                    </div>
                </div>
                <div class="payment-type">
                    <div class="payment-type__title">
                        <h4>支払い方法</h4>
                    </div>
                    <div class="form__error">
                        @error('payment_method')
                            {{ $message }}
                        @enderror
                    </div>
                    <div class="payment-type__select">
                        <select id="payment-method" name="payment_method">
                            <option value="">選択してください</option>
                            <option value="convenience">コンビニ払い</option>
                            <option value="credit">カード支払い</option>
                        </select>
                    </div>
                </div>
                <div class="shipping-address">
                    <div class="shipping-address__title">
                        <h4>配送先</h4>
                        <a href="/purchase/address/{{ $product->id }}">変更する</a>
                    </div>
                    <div class="shipping-address__contents">
                        <div class="form__error">
                            @error('post_code')
                                {{ $message }}
                            @enderror
                        </div>
                        <p>〒<input type="hidden" name="post_code"
                                value="{{ $shipping_address['post_code'] ?? $user->profile->post_code }}">
                            {{ $shipping_address['post_code'] ?? $user->profile->post_code }}</p>
                        <div class="form__error">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </div>
                        <span><input type="hidden" name="address"
                                value="{{ $shipping_address['address'] ?? $user->profile->address }}">
                            {{ $shipping_address['address'] ?? $user->profile->address }}</span>

                        <span><input type="hidden" name="building"
                                value="{{ $shipping_address['building'] ?? ($user->profile->building ?? '') }}">
                            {{ $shipping_address['building'] ?? ($user->profile->building ?? '') }}</span>
                    </div>
                </div>
            </div>
            <div class="right-content">
                <table class="total-price">
                    <tr>
                        <th>商品代金</th>
                        <td>¥{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td id="payment-info"></td>
                    </tr>
                </table>
                <div class="order__submit">
                    <button class="order__submit-button">
                        購入する</button>
                </div>
        </form>
    </div>
    </div>

    <script>
        document.getElementById('payment-method').addEventListener('change', function() {
            const selected = this.value;
            const infoDiv = document.getElementById('payment-info');

            if (selected === 'convenience') {
                infoDiv.innerHTML = 'コンビニ払い';
            } else if (selected === 'credit') {
                infoDiv.innerHTML = 'カード支払い';
            } else {
                infoDiv.innerHTML = '';
            }
        });
    </script>
@endsection
