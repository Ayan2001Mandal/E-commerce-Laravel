<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total orders
        $totalOrders = Order::count();

        // Total revenue (sum of all order items price * quantity)
        $totalRevenue = Order::with('items')->get()
            ->flatMap->items
            ->sum(fn ($item) => $item->price * $item->quantity);

        // Total registered users
        $totalUsers = User::count();

        // Pending orders
        $pendingOrders = Order::where('status', 'pending')->count();

        // Recent orders for table
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'pendingOrders',
            'orders'
        ));
    }
}

