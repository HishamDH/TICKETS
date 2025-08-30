<div class="mb-6 font-sans">
    <label class="block text-2xl font-extrabold mb-6 text-gray-800">الشخصيات الكرتونية</label>

    <div class="flex space-x-6 overflow-x-auto pb-4">
        @foreach ($cartoons as $cartoon)
            <div x-data="{ open: false }" class="flex-shrink-0 w-64 bg-white rounded-2xl shadow-md hover:shadow-xl transition cursor-pointer overflow-hidden">
                
                <!-- صورة الشخصية -->
                <div class="h-40 w-full overflow-hidden relative">
                    @if (!empty($cartoon['image']))
                        <img src="{{ asset('storage/' . $cartoon['image']) }}" alt="صورة الشخصية" class="object-cover w-full h-full transition-transform duration-300 hover:scale-105"/>
                    @else
                        <div class="h-full w-full flex items-center justify-center bg-gray-100">
                            <i class="ri-user-3-line text-6xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <!-- محتوى الكارت -->
                <div class="p-4 space-y-2">
                    <h3 class="text-lg font-bold text-gray-800 truncate">{{ $cartoon['name'] ?? 'بدون اسم' }}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3">{{ $cartoon['description'] ?? 'لا يوجد وصف' }}</p>
                    <button @click="open = true" class="mt-2 text-gray-700 hover:text-gray-900 font-semibold text-sm transition">عرض التفاصيل</button>
                </div>

                <!-- مودال التفاصيل -->
                <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>

                        <!-- صورة داخل المودال -->
                        @if (!empty($cartoon['image']))
                            <div class="h-48 w-full mb-4 overflow-hidden rounded-xl">
                                <img src="{{ asset('storage/' . $cartoon['image']) }}" alt="صورة الشخصية" class="object-cover w-full h-full"/>
                            </div>
                        @endif

                        <h3 class="font-bold text-xl mb-2">{{ $cartoon['name'] ?? 'بدون اسم' }}</h3>
                        <p class="text-gray-700 overflow-auto break-words">{{ $cartoon['description'] ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>
