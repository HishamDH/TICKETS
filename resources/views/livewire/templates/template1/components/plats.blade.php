<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">الأطباق في المطاعم</label>

    <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300 text-sm text-right">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-3">اسم الطبق</th>
                    <th class="border border-gray-300 px-4 py-3">الوصف</th>
                    <th class="border border-gray-300 px-4 py-3">السعر</th>
                    <th class="border border-gray-300 px-4 py-3">السعرات الحرارية</th>
                    <th class="border border-gray-300 px-4 py-3">More</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plats as $index => $plat)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border border-gray-300 px-4 py-3">{{ $plat['name'] }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ Str::limit($plat['description'], 50) }}</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">{{ $plat['price'] }}</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">{{ $plat['calories'] ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-3 text-center">
                        <div x-data="{ open: false }">
                            <span @click="open = true" class="text-blue-600 cursor-pointer hover:underline">More</span>

                            <!-- مودال الصورة -->
                            <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                                <div class="bg-white rounded-2xl w-full max-w-md p-6 relative shadow-xl">
                                    <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
                                    <h3 class="font-bold text-lg mb-4">{{ $plat['name'] }}</h3>
                                    <p class="text-gray-700 mb-4 break-words max-h-40 overflow-y-auto">
                                        {{ $plat['description'] }}
                                    </p>
                                    @if(!empty($plat['image']))
                                    <img src="{{ is_string($plat['image']) ? asset('storage/'.$plat['image']) : $plat['image']->temporaryUrl() }}" class="mx-auto w-48 h-32 object-cover rounded" alt="صورة الطبق">
                                    @else
                                    <p class="text-gray-500 text-center">لا توجد صورة</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>