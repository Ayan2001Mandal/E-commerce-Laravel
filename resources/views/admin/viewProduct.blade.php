<x-app-layout>
    <!-- ✅ Alerts -->
    @if (session('success'))
        <div id="alert-box" class="fixed top-5 right-5 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div id="alert-box" class="fixed top-5 right-5 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- ✅ Page Header -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('View Products') }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.addProduct') }}" class="text-indigo-600 hover:underline">Add Product</a>
                <a href="{{ route('admin.viewProduct') }}" class="text-indigo-600 hover:underline">View Product</a>
                <a href="{{ route('admin.order') }}" class="text-indigo-600 hover:underline">Orders</a>
            </div>
        </div>
    </x-slot>

    <!-- ✅ Product List -->
    <div class="max-w-7xl mx-auto mt-10 mb-10" >
        <div class="flex justify-end gap-3 mb-6">
                <a href="{{ route('admin.addProduct') }}" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700">
                   ➕ Add Product
                </a>
                <a href="{{ route('admin.viewProduct') }}" 
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-200">
                   🔄 Refresh
                </a>
            </div>
        @if($products->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded-lg shadow">
                ⚠️ No products found.
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-5 flex flex-col">
                        <!-- Product Image -->
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-48 object-cover rounded-xl mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-xl flex items-center justify-center text-gray-500">
                                📦 No Image
                            </div>
                        @endif

                        <!-- Product Details -->
                        <h3 class="text-xl font-bold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ ucfirst($product->category) }}</p>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ $product->description }}</p>

                        <div class="flex justify-between items-center mt-auto mb-4">
                            <span class="text-lg font-semibold text-indigo-600">₹{{ $product->price }}</span>
                            <span class="text-sm text-gray-500">Qty: {{ $product->quantity }}</span>
                        </div>

                        <!-- ✅ Action Buttons -->
                        <div class="flex justify-between gap-2">
                            <a href="{{ route('products.edit', $product->id) }}" 
                               class="flex-1 bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 text-center">
                               ✏️ Edit
                            </a>

                            <!-- Delete Button -->
                            <button onclick="openDeleteModal({{ $product->id }})"
                                    class="flex-1 bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ✅ Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">⚠️ Confirm Delete</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this product? This action cannot be undone.</p>
            
            <div class="flex justify-end gap-3">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- ✅ Scripts -->
    <script>
        // Auto-hide alert
        setTimeout(() => {
            const alertBox = document.getElementById('alert-box');
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 3000);

        // Modal logic
        function openDeleteModal(productId) {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            document.getElementById('deleteForm').action = "/admin/products/" + productId;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
