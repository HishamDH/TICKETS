<div class="mb-6" dir="rtl" x-data="{ openIndex: null }">
    <label class="block text-lg font-semibold mb-3 text-gray-700 text-center">الدورات & الورش التدريبية</label>

    <div class="flex flex-wrap justify-center gap-4">
        @foreach ($trainingWorkshops as $index => $workshop)
            <div class="bg-white border rounded-lg shadow p-4 w-72 flex flex-col items-center">
                {{-- صورة الورشة --}}
                <div class="w-full h-40 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                    @if(!empty($workshop['image']))
                        <img src="{{ asset('storage/' . $workshop['image']) }}" class="object-cover w-full h-full" alt="صورة الورشة">
                    @else
                        <span class="text-gray-400">لا صورة</span>
                    @endif
                </div>

                {{-- بيانات الورشة --}}
                <div class="space-y-1 text-center text-gray-800 text-sm">
                    <p class="font-semibold text-base">{{ $workshop['title'] }}</p>
                    <p>المدة: {{ $workshop['duration'] }}</p>
                    <p>المكان: {{ $workshop['location'] }}</p>
                    <p>المدرب: {{ $workshop['instructor'] }}</p>
                    <p>الشهادة: {{ $workshop['certificate'] ? 'نعم' : 'لا' }}</p>
                    <p class="text-xs text-gray-600 truncate">الوصف: {{ Str::limit($workshop['description'], 50) }}</p>
                </div>

                {{-- زر عرض التفاصيل --}}
                <button @click="openIndex = {{ $index }}" class="mt-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition">
                    عرض التفاصيل
                </button>
            </div>

            {{-- مودال Alpine.js --}}
            <div x-show="openIndex === {{ $index }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-auto">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mx-auto max-h-[90vh] overflow-auto" dir="rtl">
                    <button @click="openIndex = null" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                    <h3 class="text-lg font-semibold mb-2 text-center">{{ $workshop['title'] }}</h3>
                    <p class="text-gray-700 mb-1 text-right">المدة: {{ $workshop['duration'] }}</p>
                    <p class="text-gray-700 mb-1 text-right">المكان: {{ $workshop['location'] }}</p>
                    <p class="text-gray-700 mb-1 text-right">المدرب: {{ $workshop['instructor'] }}</p>
                    <p class="text-gray-700 mb-1 text-right">الشهادة: {{ $workshop['certificate'] ? 'نعم' : 'لا' }}</p>
                    <p class="text-gray-700 mb-2 text-right overflow-auto break-words">الوصف: {{ $workshop['description'] }}</p>
                    @if(!empty($workshop['image']))
                        <img src="{{ asset('storage/' . $workshop['image']) }}" class="mx-auto mt-2 h-40 object-contain rounded" />
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
