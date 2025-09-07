<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📦 Manage Orders
            </h2>
            <div>
             <div class="flex gap-4">
                <a href="{{ route('admin.addProduct') }}" class="text-indigo-600 hover:underline">Add Product</a>
                <a href="{{ route('admin.viewProduct') }}" class="text-indigo-600 hover:underline">View Product</a>
                <a href="{{ route('admin.order') }}" class="text-indigo-600 hover:underline">Orders</a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 space-y-6">
        @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">🛒 Order #{{ $order->id }}</h3>
                    <span class="px-3 py-1 rounded-lg text-sm 
                        @if($order->status == 'pending') bg-yellow-200 text-yellow-800 
                        @elseif($order->status == 'accepted') bg-blue-200 text-blue-800
                        @elseif($order->status == 'shipped') bg-purple-200 text-purple-800
                        @elseif($order->status == 'delivered') bg-green-200 text-green-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- User & Address -->
                <p class="mt-2 text-gray-600">👤 {{ $order->user->name }} ({{ $order->user->email }})</p>
                <p class="text-gray-600">📞 {{ $order->address->phone ?? 'N/A' }}</p>
                <p class="text-gray-600">📍 {{ $order->address->address_line }}, {{ $order->address->city }}</p>

                <!-- Products -->
                <div class="mt-4 border-t pt-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between mb-2">
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span>₹{{ $item->price * $item->quantity }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Total -->
                <p class="mt-2 font-bold text-gray-800">
                    💰 Total: ₹{{ $order->items->sum(fn($i) => $i->price * $i->quantity) }}
                </p>

                <!-- Update Status -->
                <form method="POST" action="{{ route('admin.order.updateStatus', $order->id) }}" class="mt-4 flex gap-2">
                    @csrf
                    <select name="status" class="border rounded-lg p-4 w-40">
                        <option value="pending" @selected($order->status=='pending')>Pending</option>
                        <option value="accepted" @selected($order->status=='accepted')>Accepted</option>
                        <option value="shipped" @selected($order->status=='shipped')>Shipped</option>
                        <option value="delivered" @selected($order->status=='delivered')>Delivered</option>
                    </select>
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600">
                        Update
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>

