<x-app-layout>
    <x-slot name="header">
        <x-user-header title="💳 Checkout" />
    </x-slot>

    <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8 mt-10">
        <!-- Left: Order Summary -->
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4">🛒 Order Summary</h3>

            @php $total = 0; @endphp

            @foreach($cartItems as $item)
                @php
                    $quantity = $item['quantity'] ?? $item->quantity;
                    $product = $item['product'] ?? $item->product;
                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;
                @endphp

                <div class="flex justify-between items-center border-b py-2">
                    <div>
                        <p class="font-medium">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $quantity }}</p>
                    </div>
                    <p class="font-semibold">₹{{ $subtotal }}</p>
                </div>
            @endforeach

            <div class="flex justify-between mt-4 text-lg font-semibold">
                <span>Total</span>
                <span>₹{{ $total }}</span>
            </div>
        </div>

        <!-- Right: Address Selection -->
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-xl font-semibold mb-4">📍 Select Address</h3>

            @forelse($addresses as $addr)
                <div class="flex justify-between items-start border p-3 rounded-lg mb-2 hover:bg-gray-50">

                    <!-- Checkout Form for this address -->
                    <form method="POST" action="{{ route('orders.place') }}" class="flex-1">
                        @csrf
                        @if(isset($buyNow) && $buyNow)
                            <input type="hidden" name="buy_now" value="1">
                            <input type="hidden" name="product_id" value="{{ $cartItems->first()['product']->id }}">
                        @endif

                        <label class="cursor-pointer">
                            <input type="radio" name="address_id" value="{{ $addr->id }}" class="mr-2">
                            <span class="font-medium">{{ $addr->full_name }}</span>, 
                            {{ $addr->address_line }}, {{ $addr->city }} - {{ $addr->pincode }}
                            <br>
                            <span class="text-sm text-gray-500">📞 {{ $addr->phone }}</span>
                        </label>

                        <button type="submit"
                            class="mt-2 w-full bg-green-500 text-white py-1 rounded hover:bg-green-600 transition text-sm">
                            ✅ Place Order (COD)
                        </button>
                    </form>

                    <!-- Delete Address Button (separate form) -->
                    <form method="POST" action="{{ route('address.destroy', $addr->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="ml-3 mt-2 bg-green-500 text-white px-2 py-1 rounded hover:bg-red-600 transition text-sm">
                            Remove
                        </button>
                    </form>

                </div>
            @empty
                <p class="text-gray-500 mb-3">⚠️ No saved addresses. Please add one below.</p>
            @endforelse

            <hr class="my-5">

            <!-- Add New Address -->
            <h4 class="text-lg font-semibold mb-3">➕ Add New Address</h4>
            <form method="POST" action="{{ route('address.store') }}" class="grid gap-3">
                @csrf
                <input name="full_name" placeholder="Full Name" class="border p-2 rounded" required>
                <input name="phone" placeholder="Phone" class="border p-2 rounded" required>
                <input name="address_line" placeholder="Address" class="border p-2 rounded" required>
                <input name="city" placeholder="City" class="border p-2 rounded" required>
                <input name="state" placeholder="State" class="border p-2 rounded" required>
                <input name="pincode" placeholder="Pincode" class="border p-2 rounded" required>
                <button type="submit"
                    class="bg-indigo-500 text-white py-2 rounded hover:bg-indigo-600 transition">
                    💾 Save Address
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
