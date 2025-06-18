@extends('layouts.custom')

@section('title', 'Cart')

@section('content')
  <h1 style="text-align:center; margin-bottom: 30px;">Product List</h1>
    <div class="product-list">
        @php
            use Illuminate\Support\Arr;
            $colors = ['#aa9c9c', '#a3e49d', '#e4db9d', '#e8d7d7', '#79cae9'];
        @endphp
        @forelse ($products as $product)
        @php
            $randomColor = Arr::random($colors);
        @endphp
        <div class="product-card">
        <div class="product-image" style="background-color: {{ $randomColor }}"></div>
        <div class="product-title">{{ $product->name }}</div>
        <div class="product-price">${{ number_format($product->price, 2) }}</div>
        <div class="actionbutton">
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button class="btn-add" type="submit">Add to Cart</button>
            </form>
            <form action="{{ route('wishlist.store', $product->id) }}" method="POST">
                @csrf
                 <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn-add" title="Add to wishlist" type="submit"><span class="heart-icon">❤️</span></button>
            </form>
        </div>
        </div>
        @empty
            <div class="product-card">
                No products found.
            </div>
        @endforelse
     
    </div>
       {{ $products->links() }}
@endsection
