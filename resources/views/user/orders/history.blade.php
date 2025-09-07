<x-app-layout>
    <x-slot name="header">
        <x-user-header title="📦 Order History" />
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold">Order #{{ $order->id }}</h3>
                    
                    <!-- Colorful Status Badge -->
                    <span class="px-3 py-1 rounded-lg text-sm font-semibold
                        @if($order->status == 'pending') bg-yellow-200 text-yellow-800 
                        @elseif($order->status == 'accepted') bg-blue-200 text-blue-800
                        @elseif($order->status == 'shipped') bg-purple-200 text-purple-800
                        @elseif($order->status == 'delivered') bg-green-200 text-green-800
                        @else bg-gray-200 text-gray-700
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 mt-1">
                    📍 Delivered to: {{ $order->address->address_line }}, {{ $order->address->city }}
                </p>

                <ul class="mt-3 text-sm text-gray-700">
                    @foreach($order->items as $item)
                        <li class="flex justify-between border-b py-1">
                            <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span>₹{{ $item->price }}</span>
                        </li>
                    @endforeach
                </ul>

                <p class="mt-3 font-semibold text-gray-800">
                    💰 Total: ₹{{ $order->items->sum(fn($i) => $i->price * $i->quantity) }}
                </p>
            </div>
        @empty
            <p class="text-gray-600">No orders found.</p>
        @endforelse
    </div>
</x-app-layout>
