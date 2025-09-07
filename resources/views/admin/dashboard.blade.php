<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🛠 Admin Dashboard
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.addProduct') }}" class="text-indigo-600 hover:underline">Add Product</a>
                <a href="{{ route('admin.viewProduct') }}" class="text-indigo-600 hover:underline">View Product</a>
                <a href="{{ route('admin.order') }}" class="text-indigo-600 hover:underline">Orders</a>
            </div>
        </div>
    </x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 shadow rounded-xl p-6 text-center text-white">
            <h3 class="text-lg font-semibold">Total Orders</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalOrders }}</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 shadow rounded-xl p-6 text-center text-white">
            <h3 class="text-lg font-semibold">Revenue</h3>
            <p class="text-3xl font-bold mt-2">₹{{ $totalRevenue }}</p>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 shadow rounded-xl p-6 text-center text-white">
            <h3 class="text-lg font-semibold">Users</h3>
            <p class="text-3xl font-bold mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 shadow rounded-xl p-6 text-center text-white">
            <h3 class="text-lg font-semibold">Pending Orders</h3>
            <p class="text-3xl font-bold mt-2">{{ $pendingOrders }}</p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white shadow rounded-xl p-6 mt-6">
        <h3 class="text-lg font-semibold mb-4">📦 Recent Orders</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 text-left">Order ID</th>
                        <th class="py-3 px-4 text-left">Customer</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Total</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">#{{ $order->id }}</td>
                            <td class="py-3 px-4">{{ $order->user->name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'accepted') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold">₹{{ $order->items->sum(fn($i) => $i->price * $i->quantity) }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.order', $order->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-800 font-medium">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
