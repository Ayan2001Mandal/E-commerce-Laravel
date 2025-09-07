<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Show cart
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('user.cart.index', compact('cartItems'));
    }

    // Add product to cart
    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => 1]
        );

        if (!$cart->wasRecentlyCreated) {
            $cart->increment('quantity');
        }

        return back()->with('success', '✅ Product added to cart');
    }

    // Remove item from cart
    public function remove($id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $cart->delete();

        return back()->with('success', '🗑️ Item removed from cart');
    }
}
