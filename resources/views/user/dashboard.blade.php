<x-app-layout>
    <x-slot name="header">
        <x-user-header title="🛍️ Shop Dashboard" />
    </x-slot>


    <!-- ✅ Image Slider -->
    <div class="w-full max-w-6xl mx-auto mt-6 overflow-hidden rounded-xl shadow-lg relative">
        <div class="flex transition-transform duration-500" id="slider">
            <img src="{{ asset('images/slide1.jpg') }}" class="w-full" />
            <img src="{{ asset('images/slide2.jpg') }}" class="w-full" />
            <img src="{{ asset('images/slide3.jpg') }}" class="w-full" />
        </div>
    </div>

    <!-- ✅ Categories -->
    <div class="max-w-6xl mx-auto mt-10">
        <h3 class="text-xl font-semibold mb-4">Categories</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $cat)
                <a href="{{ route('products.category', $cat) }}"
                   class="bg-white rounded-xl shadow hover:shadow-lg p-6 flex flex-col items-center transition">
                    <div class="w-16 h-16 bg-indigo-100 flex items-center justify-center rounded-full text-indigo-600 text-2xl font-bold">
                        {{ strtoupper(substr($cat,0,1)) }}
                    </div>
                    <span class="mt-4 font-semibold text-gray-700">{{ ucfirst($cat) }}</span>
                </a>
            @endforeach
        </div>
    </div>


    <!-- Slider Script -->
    <script>
        let index = 0;
        const slides = document.getElementById('slider');
        setInterval(() => {
            index = (index + 1) % 3;
            slides.style.transform = `translateX(-${index * 100}%)`;
        }, 3000);
    </script>
</x-app-layout>
