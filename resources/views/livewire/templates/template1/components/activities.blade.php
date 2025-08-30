<div class="mb-6">
    <label class="block text-lg font-bold mb-4 text-gray-800">الفعاليات الجانبية</label>

    @if(!empty($activities) && count($activities) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($activities as $activity)
                <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-md hover:shadow-xl transition cursor-pointer overflow-hidden">
                    @if(!empty($activity['image']))
                        <div class="h-28 w-full overflow-hidden">
                            <img src="{{ asset('storage/' . ($activity['image'] ?? '')) }}" alt="Activity Image" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-28 w-full bg-gradient-to-r from-purple-500 to-indigo-500"></div>
                    @endif
                    <div class="p-4" @click="open = true">
                        <h3 class="font-semibold text-lg text-gray-800">{{ $activity['title'] ?? 'NULL' }}</h3>
                        <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                            <span class="ri-time-line"></span> {{ $activity['time'] ?? 'NULL' }} | 
                            <span class="ri-map-pin-line"></span> {{ $activity['location'] ?? 'NULL' }}
                        </p>
                        <p class="text-gray-600 text-sm line-clamp-2 mt-2">{{ $activity['description'] ?? 'NULL' }}</p>
                    </div>

                    <!-- مودال صغير أنيق -->
                    <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                        <div class="bg-white rounded-xl w-full max-w-md p-6 relative shadow-lg">
                            <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                            <h3 class="font-bold text-xl mb-2">{{ $activity['title'] ?? 'NULL' }}</h3>
                            <p class="text-gray-500 text-sm mb-4">
                                <span class="ri-time-line"></span> {{ $activity['time'] ?? 'NULL' }} | 
                                <span class="ri-map-pin-line"></span> {{ $activity['location'] ?? 'NULL' }}
                            </p>
                            <p class="text-gray-700 overflow-auto break-words">{{ $activity['description'] ?? 'NULL' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-sm">لا توجد فعاليات لعرضها حالياً.</p>
    @endif
</div>
