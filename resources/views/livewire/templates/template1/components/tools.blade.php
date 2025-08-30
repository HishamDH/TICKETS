<div class="mb-6" dir="rtl" x-data="{ openIndex: null }">
    <label class="block text-base font-semibold mb-3 text-gray-700 text-lg">الأدوات المتاحة</label>

    <div class="flex flex-wrap justify-center gap-4">
        @foreach ($availableTools as $index => $tool)
            <div class="bg-white border rounded-lg shadow p-4 w-60 relative flex flex-col items-center">
                {{-- صورة الأداة --}}
                <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                    @if(!empty($tool['image']))
                        <img src="{{ asset('storage/' . $tool['image']) }}" class="object-cover w-full h-full" alt="صورة الأداة">
                    @else
                        <span class="text-gray-400">لا صورة</span>
                    @endif
                </div>

                {{-- بيانات الأداة --}}
                <div class="space-y-1 text-center text-gray-800 text-sm">
                    <p class="font-semibold">{{ $tool['name'] }}</p>
                    <p>التصنيف: {{ $tool['category'] }}</p>
                    <p>موديل: {{ $tool['model'] }}</p>
                    <p>التوفر: {{ $tool['availability'] }}</p>
                    <p class="text-xs text-gray-600 truncate">المميزات: {{ Str::limit($tool['features'], 50) }}</p>
                    <p class="text-xs text-gray-600 truncate">الوصف: {{ Str::limit($tool['description'], 50) }}</p>
                </div>

                {{-- زر عرض التفاصيل في مودال --}}
                <button @click="openIndex = {{ $index }}" class="mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                    عرض التفاصيل
                </button>
            </div>

            {{-- مودال Alpine.js لكل أداة --}}
            <div x-show="openIndex === {{ $index }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-auto">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mx-auto max-h-[90vh] overflow-auto" dir="rtl">
                    <button @click="openIndex = null" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                    <h3 class="text-lg font-semibold mb-2 text-center">{{ $tool['name'] }}</h3>
                    <p class="text-gray-700 mb-1 text-right">التصنيف: {{ $tool['category'] }}</p>
                    <p class="text-gray-700 mb-1 text-right">موديل: {{ $tool['model'] }}</p>
                    <p class="text-gray-700 mb-1 text-right">التوفر: {{ $tool['availability'] }}</p>
                    <p class="text-gray-700 mb-2 text-right overflow-auto break-words">المميزات: {{ $tool['features'] }}</p>
                    <p class="text-gray-700 mb-2 text-right overflow-auto break-words">الوصف: {{ $tool['description'] }}</p>
                    @if(!empty($tool['image']))
                        <img src="{{ asset('storage/' . $tool['image']) }}" class="mx-auto mt-2 h-32 object-contain rounded" />
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
