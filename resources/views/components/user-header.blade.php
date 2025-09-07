@props(['title' => 'Shop Dashboard'])

<div class="flex justify-between items-center w-full">
    <!-- Page Title -->
    <h2 class="font-semibold text-2xl text-gray-800">
        {{ $title }}
    </h2>

    <!-- Navigation Links -->
    <div class="flex items-center gap-6">
        <!-- Products Link -->
        <a href="{{ route('products.all') }}"
           class="flex items-center {{ request()->routeIs('products.*') ? 'text-indigo-800 font-semibold' : 'text-indigo-600 hover:text-indigo-800' }}">
            <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h18M9 3v18m6-18v18M3 9h18M3 15h18" />
            </svg>
            <span>Products</span>
        </a>

        <!-- Orders Link -->
        <a href="{{ route('orders.history') }}"
           class="flex items-center {{ request()->routeIs('orders.*') ? 'text-indigo-800 font-semibold' : 'text-indigo-600 hover:text-indigo-800' }}">
            <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-2h6v2m-6-8h6m-6 4h6M12 3v1m0 16v1m8-9h1M3 12h1m15.364-6.364l.707.707M4.929 19.071l.707.707M19.071 19.071l-.707.707M4.929 4.929l.707.707" />
            </svg>
            <span>Orders</span>
        </a>

        <!-- Cart Link -->
        <a href="{{ route('cart.index') }}"
           class="relative {{ request()->routeIs('cart.*') ? 'text-indigo-800 font-semibold' : 'text-indigo-600 hover:text-indigo-800' }}">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 6.45A1 1 0 007.6 21h8.8a1 1 0 001-1.55L17 13M7 13h10" />
            </svg>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2">
                {{ \App\Models\Cart::where('user_id', auth()->id())->count() }}
            </span>
        </a>
    </div>
</div>
