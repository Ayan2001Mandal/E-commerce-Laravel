<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Show all orders
    public function index()
    {
        $orders = Order::with('user', 'items.product', 'address')->latest()->get();
        return view('admin.order', compact('orders'));
    }

    // Update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,accepted,shipped,delivered',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', '✅ Order status updated successfully!');
    }
}
