<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">الخدمات المتوفرة</label>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($services as $index => $service)
            <div class="border rounded-lg shadow-sm bg-white overflow-hidden flex flex-col" x-data="{ open: false }">
                {{-- الصورة --}}
                <div class="h-32 bg-gray-100">
                    <img src="{{ is_string($service['image']) ? asset('storage/'.$service['image']) : 'https://via.placeholder.com/300x200' }}" 
                         class="w-full h-full object-cover" alt="صورة الخدمة">
                </div>

                {{-- البيانات --}}
                <div class="p-3 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-sm">{{ $service['title'] }}</h3>
                        <p class="text-xs text-gray-500">{{ $service['time'] }} | {{ $service['location'] }}</p>
                        <p class="text-xs text-gray-700 line-clamp-3 mt-1">{{ $service['description'] }}</p>
                    </div>

                    {{-- فاصل وزر More --}}
                    <div class="border-t border-dashed border-gray-300 mt-2"></div>
                    <div class="text-center mt-1">
                        <button @click="open = true" class="text-blue-600 font-semibold text-sm hover:text-blue-800">More</button>
                    </div>
                </div>

                {{-- مودال Alpine --}}
                <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-5 relative">
                        <button @click="open = false" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                        <h3 class="text-lg font-semibold mb-3">{{ $service['title'] }}</h3>
                        @if (!empty($service['image']))
                            <img src="{{ is_string($service['image']) ? asset('storage/'.$service['image']) : 'https://via.placeholder.com/300x200' }}" 
                                 class="w-full h-40 object-cover rounded mb-3" alt="صورة الخدمة">
                        @endif
                        <p class="text-gray-700 mb-2 overflow-auto break-words">{{ $service['description'] }}</p>
                        <p class="text-xs text-gray-500 mb-1">الوقت: {{ $service['time'] }}</p>
                        <p class="text-xs text-gray-500 mb-1">الموقع: {{ $service['location'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
