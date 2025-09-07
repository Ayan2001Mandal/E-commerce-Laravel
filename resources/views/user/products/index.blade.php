<x-app-layout>
    <x-slot name="header">
        <x-user-header title="📦 All Products" />
    </x-slot>

    <!-- Search form -->
    <form action="{{ route('products.search') }}" method="GET" class="mt-6 mb-6 flex items-center justify-center gap-2">
        <div class="relative w-1/2 md:w-1/3">
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="🔍 Search products..."
                   class="border border-gray-300 rounded-full pl-10 pr-4 py-2 w-full
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35M15 11a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>

        <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700">
            Search
        </button>

        @if(request('q'))
            <a href="{{ route('products.all') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300">
                Clear
            </a>
        @endif
    </form>

    @if(isset($searchQuery))
        <p class="mb-4 text-gray-600">
            Showing results for: <strong>{{ $searchQuery }}</strong>
        </p>
    @endif

    <!-- Product Grid -->
    <div class="max-w-6xl mx-auto mt-8 grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($products as $product)
            <div class="bg-white rounded-xl shadow hover:shadow-xl transition p-4 flex flex-col">
                <img src="{{ asset('images/' . $product->image) }}"
                     class="h-40 object-cover rounded-lg mb-3">
                <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ Str::limit($product->description, 60) }}</p>

                <div class="flex justify-between items-center mt-auto">
                    <span class="text-indigo-600 font-semibold text-lg">₹{{ $product->price }}</span>
                </div>

                <div class="flex gap-2 mt-3">
                    <!-- Add to Cart -->
                    <a href="{{ route('cart.add', $product->id) }}"
                       class="flex-1 text-center bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                        Add to Cart
                    </a>

                    <a href="{{ route('user.buyNow', $product->id) }}" 
                        class="flex-1 text-center bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Buy Now
                    </a>



                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
