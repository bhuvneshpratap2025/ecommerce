@extends('layouts.custom')

@section('title', 'Wishlist')

@section('content')

    @php
        use Illuminate\Support\Arr;
        $colors = ['#aa9c9c', '#a3e49d', '#e4db9d', '#e8d7d7', '#79cae9'];
    @endphp
     @if(session('success'))
        <div style="color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif
    @if($wishlist->count())
       <h1>Your Wishlist</h1>
        @php
            $randomColor = Arr::random($colors);
        @endphp
        
        <div class="product-list">
            @foreach ($wishlist as $id => $details)
             
             <div class="product-card">
                <div class="product-image" style="background-color: {{ $randomColor }}"></div>
                <div class="product-title">{{  $details->product->name }}</div>
                <div class="product-price">${{  $details->product->price }}</div>
                <div class="buttoncontainer" style="display: flex;justify-content: space-between;">
                    <form action="{{ route('wishlist.destroy', $details->product_id) }}" method="POST" style="display:inline;">
                    @csrf
                     @method('DELETE')
                    <button class="btn-add" type="submit">Remove</button>
                    </form>
                    <form action="{{ route('wishlist.wishlisttocart', $details->product_id) }}" method="POST">
                    @csrf
                     <input type="hidden" name="product_id" value="{{ $details->product_id }}">
                    <button class="btn-add" type="submit">Add to Cart</button>
                </form>
                </div>
                
                </div>
               
            @endforeach
         </div>
    @else
        <p>Your wishlist is empty</p>
    @endif
@endsection
