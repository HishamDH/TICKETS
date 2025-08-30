<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">المنتجات</label>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $index => $product)
            <div class="border rounded-lg shadow-lg bg-white overflow-hidden flex flex-col" x-data="{ open: false }">
                {{-- الصورة --}}
                <div class="h-48 bg-gray-100">
                    <img src="{{ is_string($product['image']) ? asset('storage/'.$product['image']) : 'https://via.placeholder.com/400x300' }}" 
                         class="w-full h-full object-cover" alt="صورة المنتج">
                </div>

                {{-- البيانات --}}
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">{{ $product['name'] }}</h3>
                        <p class="text-xs text-gray-500 mb-1">{{ $product['category'] }} - جناح {{ $product['booth'] }}</p>
                        <p class="text-green-600 font-semibold">{{ $product['price'] }} ر.س</p>
                        <p class="text-xs text-gray-700 line-clamp-3 mt-1">{{ $product['description'] }}</p>
                    </div>

                    {{-- فاصل وزر More --}}
                    <div class="border-t border-dashed border-gray-300 mt-3"></div>
                    <div class="text-center mt-2">
                        <button @click="open = true" class="text-blue-600 font-semibold hover:text-blue-800">More</button>
                    </div>
                </div>

                {{-- مودال Alpine --}}
                <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
                        <button @click="open = false" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                        <h3 class="text-lg font-semibold mb-4">{{ $product['name'] }}</h3>
                        <img src="{{ is_string($product['image']) ? asset('storage/'.$product['image']) : 'https://via.placeholder.com/400x300' }}" 
                             class="w-full h-48 object-cover rounded mb-4" alt="صورة المنتج">
                        <p class="text-gray-700 mb-2 overflow-auto break-words">{{ $product['description'] }}</p>
                        <p class="text-xs text-gray-500 mb-1">التصنيف: {{ $product['category'] }}</p>
                        <p class="text-xs text-gray-500 mb-1">جناح: {{ $product['booth'] }}</p>
                        <p class="text-green-600 font-semibold">السعر: {{ $product['price'] }} ر.س</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>
