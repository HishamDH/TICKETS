<div class="mb-6 font-sans" dir="rtl">
    <label class="block text-2xl font-extrabold mb-6 text-gray-800">ورش العمل</label>

    <div class="flex flex-wrap gap-4">
        @foreach($workshops as $index => $workshop)
            <div x-data="{ open: false }" class="flex-shrink-0 w-72 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer p-4">
                
                <!-- الصورة -->
                <div class="h-40 rounded-lg overflow-hidden mb-4 bg-gray-50 flex items-center justify-center">
                    @if(!empty($workshop['image']))
                        <img src="{{ asset('storage/' . $workshop['image']) }}" alt="صورة الورشة" class="object-cover w-full h-full" />
                    @else
                        <i class="ri-tools-line text-6xl text-gray-400"></i>
                    @endif
                </div>

                <!-- العنوان والوصف المختصر -->
                <h3 class="text-xl font-bold text-gray-800 mb-1 truncate">{{ $workshop['title'] ?? 'NULL' }}</h3>
                <p class="text-sm text-gray-600 mb-2 h-16 overflow-hidden">{{ $workshop['description'] ?? 'NULL' }}</p>

                <!-- زر فتح المودال -->
                <button @click="open = true" class="text-gray-700 hover:text-gray-900 text-sm font-semibold transition">عرض التفاصيل</button>

                <!-- مودال التفاصيل -->
                <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl overflow-auto max-h-[90vh]">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        
                        <!-- صورة الورشة -->
                        <div class="h-48 w-full rounded-lg overflow-hidden mb-4 bg-gray-50 flex items-center justify-center">
                            @if(!empty($workshop['image']))
                                <img src="{{ asset('storage/' . $workshop['image']) }}" alt="صورة الورشة" class="object-cover w-full h-full rounded" />
                            @else
                                <i class="ri-tools-line text-6xl text-gray-400"></i>
                            @endif
                        </div>

                        <h3 class="font-bold text-lg mb-2">{{ $workshop['title'] ?? 'NULL' }}</h3>
                        <p class="text-gray-700 mt-2 overflow-auto break-words"><strong>الوصف:</strong> {{ $workshop['description'] ?? 'NULL' }}</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>
