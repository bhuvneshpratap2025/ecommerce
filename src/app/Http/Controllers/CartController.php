<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (auth()->check()) {
            $wishlist = auth()->user()->wishlistItems()->with('product')->get();
        }else{
            $wishlist = collect(); // always returns a Collection
        }
        return view('cart.index', compact(['cart','wishlist']));
    }

    public function add(Product $product)
    {
        $cart = session()->get('cart', []);
        // If product already in cart, increase quantity
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed from cart!');
    }
}
