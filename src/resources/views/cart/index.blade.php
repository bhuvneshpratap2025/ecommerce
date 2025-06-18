@extends('layouts.custom')

@section('title', 'Cart')

@section('content')

    @php
        use Illuminate\Support\Arr;
        $colors = ['#aa9c9c', '#a3e49d', '#e4db9d', '#e8d7d7', '#79cae9'];
    @endphp
    @if(session('cart') && count(session('cart')) > 0)
       <h1>Your Cart</h1>
        @php
            $randomColor = Arr::random($colors);
        @endphp
        <div class="product-list">
            @foreach ($cart as $id => $details)
             <div class="product-card">
                <div class="product-image" style="background-color: {{ $randomColor }}"></div>
                <div class="product-title">{{ $details['name'] }}</div>
                <div class="product-price">${{ $details['price'] }}</div>
                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-add" type="submit">Remove</button>
                </form>
                </div>
               
            @endforeach
         </div>
    @else
        <p>Your cart is empty</p>
    @endif
@endsection
