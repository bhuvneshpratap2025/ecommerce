<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Http\Controllers\CartController;
class WishlistController extends Controller
{
     public function index()
    {
        $wishlist = auth()->user()->wishlistItems()->with('product')->get();
        return view('wishlist.index', compact('wishlist'));
    }

    public function store(Request $request)
    {
        
        $request->validate(['product_id' => 'required|exists:products,id']);
        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function destroy($productId)
    {   
        auth()->user()->wishlistItems()->where('product_id', $productId)->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
    public function wishlisttocart(Request $request, CartController $cartController)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth()->user();
        $productId = $request->product_id;

        $wishlistItem = $user->wishlistItems()->where('product_id', $productId)->first();
        if ($wishlistItem) {
            $cartController->add($wishlistItem->product);
            $wishlistItem->delete();
        }
        return back()->with('success', 'Added from wishlist.');
    }
}
