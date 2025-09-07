<x-app-layout>
    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data"
          class="bg-gradient-to-br from-white to-gray-50 m-10 p-10 rounded-3xl shadow-xl max-w-xl mx-auto border border-gray-200 hover:shadow-2xl transition duration-300">
        @csrf
        @method('PUT')

        <h2 class="text-3xl font-extrabold text-gray-800 mb-8 flex items-center gap-2">
            ✏️ Edit Product
        </h2>

        <!-- Name -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ $product->name }}" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Category -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
            <select name="category" id="category"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
                <option value="{{ $product->category }}" selected>{{ ucfirst($product->category) }}</option>
                <option value="electronics">Electronics</option>
                <option value="phone">Phone</option>
                <option value="laptop">Laptop</option>
                <option value="clothing">Tshirt</option>
                <option value="clothing">Pant</option>
                <option value="shoes">Shoes</option>
                <option value="home_appliances">Home Appliances</option>
            </select>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">{{ $product->description }}</textarea>
        </div>

        <!-- Price -->
        <div class="mb-6">
            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price</label>
            <input type="number" name="price" id="price" value="{{ $product->price }}" step="0.01"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Quantity -->
        <div class="mb-6">
            <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Image -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500">
            @if($product->image)
                <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" class="w-32 mt-2 rounded-lg shadow">
            @endif
        </div>

        <!-- Save Button -->
        <button type="submit"
                class="w-full inline-flex justify-center items-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700">
            💾 Update Product
        </button>
    </form>
</x-app-layout>
