<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Checkout page
    public function checkout()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $addresses = Address::where('user_id', auth()->id())->get();

        return view('user.checkout.checkout', compact('cartItems', 'addresses'));
    }

    // Place order
    public function placeOrder(Request $request)
{
    $request->validate([
        'address_id' => 'required|exists:addresses,id'
    ]);

    if ($request->has('buy_now')) {
        $product = \App\Models\Product::findOrFail($request->product_id);

        DB::transaction(function () use ($product, $request) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $request->address_id,
                'status' => 'pending',
                'payment_method' => 'COD',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        });

        return redirect()->route('orders.history')->with('success', '✅ Product purchased successfully!');
    }

    // 🔹 Normal Cart Checkout
    $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', '⚠️ Cart is empty');
    }

    DB::transaction(function () use ($cartItems, $request) {
        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $request->address_id,
            'status' => 'pending',
            'payment_method' => 'COD',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();
    });

    return redirect()->route('orders.history')->with('success', '✅ Order placed successfully!');
}


    // Order history
    public function history()
    {
        $orders = Order::with('items.product', 'address')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.orders.history', compact('orders'));
    }
    //buy now
    public function buyNow($id)
    {
        $product = \App\Models\Product::findOrFail($id);

        // get addresses of logged in user
        $addresses = \App\Models\Address::where('user_id', auth()->id())->get();

        // instead of cartItems, we pass single product
        $buyNowItem = [
            'product' => $product,
            'quantity' => 1
        ];

        return view('user.checkout.checkout', [
            'cartItems' => collect([$buyNowItem]), // mimic cart
            'addresses' => $addresses,
            'buyNow' => true, // flag to know this is Buy Now
        ]);
    }

}
