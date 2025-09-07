<x-app-layout>
    <x-slot name="header">
        <x-user-header title="🛒 Your Cart" />
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">
        @forelse($cartItems as $item)
            <div class="flex items-center justify-between border-b py-3">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $item->product->name }}</h3>
                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="font-semibold text-indigo-600">₹{{ $item->product->price * $item->quantity }}</span>
                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700">Remove</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600">Your cart is empty</p>
        @endforelse

        @if($cartItems->count())
            <div class="mt-6 flex justify-end">
                <a href="{{ route('orders.checkout') }}"
                   class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                   Proceed to Checkout
                </a>
            </div>
        @endif
    </div>

</x-app-layout>
