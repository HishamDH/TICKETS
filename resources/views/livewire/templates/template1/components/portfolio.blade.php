<div class="mb-6 font-sans" dir="rtl">
    <label class="block text-2xl font-extrabold mb-4 text-gray-800">البورتفوليو</label>

    <div class="flex flex-wrap gap-4">
        @foreach($Portfolio as $index => $item)
            <div x-data="{ open: false }" class="flex-shrink-0 w-80 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition cursor-pointer overflow-hidden">
                
            <div class="flex">
    <!-- صورة -->
    <div class="w-24 h-24 bg-gray-100 flex-shrink-0">
        <img src="{{ asset('storage/' . $item['image']) }}" alt="صورة المشروع" class="w-full h-full object-cover rounded">
    </div>

    <!-- بيانات -->
    <div class="flex-1 p-4 flex flex-col justify-between">
        <div>
            <h3 class="font-semibold text-gray-800 truncate">{{ $item['title'] ?: 'بدون عنوان' }}</h3>
            <p class="text-xs text-gray-500">{{ $item['date'] ?: 'بدون تاريخ' }}</p>
            <p class="text-gray-600 text-sm line-clamp-3 ">{{ $item['description'] ?: 'لا يوجد وصف' }}</p>
            <p class="text-xs text-gray-500">الأدوات: {{ $item['tools'] ?: 'غير محددة' }}</p>
        </div>
        <div class="border-t border-dashed border-gray-300 mt-2"></div>

        <div class="text-center mt-2">
            <button @click="open = true" class="text-gray-700 hover:text-gray-900 text-sm font-semibold">
                More
            </button>
        </div>
    </div>
</div>

                <!-- مودال التفاصيل -->
                <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl overflow-auto max-h-[90vh]">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        <h3 class="font-bold text-lg mb-2">{{ $item['title'] ?: 'بدون عنوان' }}</h3>
                        <p class="text-xs text-gray-500 mb-1">{{ $item['date'] ?: 'بدون تاريخ' }}</p>
                        <p class="text-gray-700 mb-2 overflow-auto break-words">{{ $item['description'] ?: 'لا يوجد وصف' }}</p>
                        <p class="text-xs text-gray-500 mb-2">الأدوات: {{ $item['tools'] ?: 'غير محددة' }}</p>
                        <a href="{{ $item['link'] }}" target="_blank" class="text-blue-500 underline break-all mb-4 block">رابط المشروع</a>
                        @if(!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-48 object-cover rounded" alt="صورة المشروع">
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
