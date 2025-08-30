<div class="mb-6 font-sans" dir="rtl">
    <label class="block text-2xl font-extrabold mb-6 text-gray-800">الألعاب</label>

    <div class="flex flex-wrap gap-4">
        @foreach($games as $index => $game)
            <div x-data="{ open: false }" class="flex-shrink-0 w-72 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer p-4">
                
                <!-- الصورة -->
                <div class="h-40 rounded-lg overflow-hidden mb-4 bg-gray-50 flex items-center justify-center">
                    @if(!empty($game['image']))
                        <img src="{{ asset('storage/' . $game['image']) }}" alt="صورة اللعبة" class="object-cover w-full h-full" />
                    @else
                        <i class="ri-gamepad-line text-6xl text-gray-400"></i>
                    @endif
                </div>

                <!-- الاسم والوصف المختصر -->
                <h3 class="text-xl font-bold text-gray-800 mb-1 truncate">{{ $game['name'] ?? 'NULL' }}</h3>
                <p class="text-sm text-gray-600 mb-2 h-16 overflow-hidden">{{ $game['description'] ?? 'NULL' }}</p>

                <!-- زر فتح المودال -->
                <button @click="open = true" class="text-gray-700 hover:text-gray-900 text-sm font-semibold transition">عرض التفاصيل</button>

                <!-- مودال التفاصيل -->
                <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl overflow-auto max-h-[90vh]">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        
                        <!-- صورة اللعبة -->
                        <div class="h-48 w-full rounded-lg overflow-hidden mb-4 bg-gray-50 flex items-center justify-center">
                            @if(!empty($game['image']))
                                <img src="{{ asset('storage/' . $game['image']) }}" alt="صورة اللعبة" class="object-cover w-full h-full rounded" />
                            @else
                                <i class="ri-gamepad-line text-6xl text-gray-400"></i>
                            @endif
                        </div>

                        <h3 class="font-bold text-lg mb-2">{{ $game['name'] ?? 'NULL' }}</h3>
                        <p class="text-gray-700 mb-1"><strong>الفئة العمرية:</strong> {{ $game['age_range'] ?? 'NULL' }}</p>
                        <p class="text-gray-700 mb-1 overflow-auto break-words"><strong>المكان:</strong> {{ $game['location'] ?? 'NULL' }}</p>
                        <p class="text-gray-700 mb-1 overflow-auto break-words"><strong>المشرف:</strong> {{ $game['supervisor'] ?? 'NULL' }}</p>
                        <p class="text-gray-700 mt-2 overflow-auto break-words"><strong>الوصف:</strong> {{ $game['description'] ?? 'NULL' }}</p>
                        <p class="text-gray-700 mt-2 overflow-auto break-words"><strong>قوانين اللعبة:</strong> {{ $game['rules'] ?? 'NULL' }}</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>
