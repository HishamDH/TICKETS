<div class="mb-6 font-sans" dir="rtl">
    <label class="block text-2xl font-extrabold mb-4 text-gray-800">مزايا العرض</label>

    <div class="flex flex-wrap gap-4">
        @foreach($Offerfeatures as $feature)
            <div x-data="{ open: false }" class="flex-shrink-0 w-72 bg-white border border-gray-200 rounded-xl shadow-sm p-4 cursor-pointer hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800 truncate">{{ $feature['name'] ?? 'NULL' }}</h3>
                
                <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ $feature['description'] ?? 'NULL' }}</p>

                <div class="mt-2 h-32 w-full bg-gray-50 rounded flex items-center justify-center overflow-hidden">
                    @if(!empty($feature['image']))
                        <img src="{{ asset('storage/' . $feature['image']) }}" alt="صورة الميزة" class="object-cover w-full h-full rounded" />
                    @else
                        NULL
                    @endif
                </div>

                <button @click="open = true" class="mt-2 text-gray-700 hover:text-gray-900 text-sm font-semibold transition">More</button>

                <!-- مودال التفاصيل -->
                <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl overflow-auto max-h-[90vh]">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        <h3 class="font-bold text-lg mb-4">{{ $feature['name'] ?? 'NULL' }}</h3>
                        <p class="text-gray-700 mb-4 overflow-auto break-words">{{ $feature['description'] ?? 'NULL' }}</p>
                        @if(!empty($feature['image']))
                            <img src="{{ asset('storage/' . $feature['image']) }}" class="mx-auto w-48 h-32 object-cover rounded" alt="صورة الميزة" />
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
