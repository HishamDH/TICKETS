<div class="mb-6 font-sans" dir="rtl">
    <label class="block text-2xl font-extrabold mb-4 text-gray-800">روابط الفعالية</label>

    <div class="flex flex-col gap-3">
        @foreach($links as $link)
            <div x-data="{ open: false }" class="flex justify-between items-center bg-white border border-gray-200 rounded-lg shadow-sm p-3 hover:shadow-md transition cursor-pointer">
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-800 truncate">{{ $link['platform'] ?? 'NULL' }}</h3>
                    <a href="{{ e($link['url']) ?? '#' }}" target="_blank" class="text-blue-500 underline text-sm break-all">{{ $link['url'] ?? 'NULL' }}</a>
                    <p class="text-gray-600 text-sm mt-1 line-clamp-1">{{ $link['description'] ?? 'NULL' }}</p>
                </div>
                <button @click="open = true" class="ml-3 text-gray-700 hover:text-gray-900 text-sm font-semibold transition whitespace-nowrap">عرض التفاصيل</button>

                <!-- مودال التفاصيل -->
                <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                        <h3 class="font-bold text-lg mb-2">{{ $link['platform'] ?? 'NULL' }}</h3>
                        <a href="{{ $link['url'] ?? '#' }}" target="_blank" class="text-blue-500 underline break-all mb-4 block">{{ $link['url'] ?? 'NULL' }}</a>
                        <p class="text-gray-700 overflow-auto break-words">{{ $link['description'] ?? 'NULL' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
