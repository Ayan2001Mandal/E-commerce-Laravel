<x-app-layout>
    <!-- for alerts -->
        @if (session('success'))
        <div class="fixed top-5 right-5 z-50">
            <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-slide-in">
                ✅ {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-5 right-5 z-50">
            <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-slide-in">
                ❌ {{ session('error') }}
            </div>
        </div>
    @endif

    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
            <div class="flex gap-4">
                <a href="{{ route('admin.addProduct') }}" class="text-indigo-600 hover:underline">Add Product</a>
                <a href="{{ route('admin.viewProduct') }}" class="text-indigo-600 hover:underline">View Product</a>
                <a href="{{ route('admin.order') }}" class="text-indigo-600 hover:underline">Orders</a>
            </div>
        </div>
    </x-slot>

   <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"
        class="bg-gradient-to-br from-white to-gray-50 m-10 p-10 rounded-3xl shadow-xl max-w-xl mx-auto border border-gray-200 hover:shadow-2xl transition duration-300">
        @csrf
        <!-- Header -->
        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 flex items-center gap-2">
            <span class="text-indigo-600">➕</span> Add New Product
        </h2>

        <!-- Name -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
            <div class="relative">
                <input type="text" name="name" id="name" required
                    placeholder="Enter Product Name..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl 
                            focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                            placeholder-gray-400 shadow-sm">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">📝</span>
            </div>
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
            <div class="relative">
                <select name="category" id="category" required
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl 
                            focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                            placeholder-gray-400 shadow-sm">
                    <option value="" disabled selected>Select Category</option>
                    <option value="electronics">Electronics</option>
                    <option value="phone">Phone</option>
                    <option value="laptop">Laptop</option>
                    <option value="clothing">Tshirt</option>
                    <option value="clothing">Pant</option>
                    <option value="shoes">Shoes</option>
                    <option value="home_appliances">Home Appliances</option>
                </select>
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">📦</span>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <div class="relative">
                <textarea name="description" id="description" rows="4" placeholder="Add details about your product..."
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl 
                                focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                placeholder-gray-400 shadow-sm"></textarea>
                <span class="absolute top-3 left-3 text-gray-400">💬</span>
            </div>
        </div>
        <!-- Price -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price ($)</label>
            <div class="relative">
                <input type="number" name="price" id="price" step="0.01" required
                    placeholder="Enter Product Price..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl 
                            focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                            placeholder-gray-400 shadow-sm">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">₹</span>
            </div>
        </div>  

        <!-- Quantity -->
        <div class="mb-6">
            <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
            <div class="relative">
                <input type="number" name="quantity" id="quantity" required
                    placeholder="Enter Product Quantity..."
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl 
                            focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                            placeholder-gray-400 shadow-sm">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">📦</span>
            </div>
        </div>

        <!-- image uplode -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
            <div class="relative">
                <input type="file" name="image" id="image" accept="image/*" required
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl 
                            focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                            placeholder-gray-400 shadow-sm">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">🖼️</span>
            </div>
        </div>


        

        <!-- Submit Button -->
        <button type="submit"
                class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 
                    bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-base 
                    font-semibold rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700 
                    transform hover:scale-[1.02] transition duration-300 ease-out">
            💾 Save Product
        </button>
</form>
</x-app-layout>
<script>
    // Auto-dismiss alerts after some time 
    setTimeout(() => {
        let alertBox = document.querySelector('.fixed.top-5.right-5');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);
</script>
