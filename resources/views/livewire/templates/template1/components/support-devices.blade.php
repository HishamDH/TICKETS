<div class="mb-6" dir="rtl" x-data="{ openIndex: null }">
    <label class="block text-base font-semibold mb-3 text-gray-700 text-lg">الأجهزة المدعومة</label>

    <div class="overflow-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-700 font-medium">
                    <th class="border border-gray-300 px-3 py-2 text-right">اسم الجهاز</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">موديل الجهاز</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supportedDevices as $index => $device)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border border-gray-300 px-2 py-1">{{ $device['device_name'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ $device['model'] }}</td>
                        <td class="border border-gray-300 px-2 py-1 max-w-xs">
                            <div class="max-h-16 overflow-y-auto break-words px-1">
                                {{ Str::limit($device['description'], 50) }}
                            </div>
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center">
                            @if(!empty($device['image']))
                                <img src="{{ asset('storage/' . $device['image']) }}" alt="صورة الجهاز" class="mx-auto w-24 h-16 object-cover rounded" />
                            @endif
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center">
                            <button @click="openIndex = {{ $index }}" class="text-blue-600 hover:text-blue-800" title="عرض المزيد">
                                <i class="ri-more-2-line"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- مودال Alpine.js للعرض --}}
                    <div x-show="openIndex === {{ $index }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-auto">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mx-auto max-h-[90vh] overflow-auto" dir="rtl">
                            <button @click="openIndex = null" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                            <h3 class="text-lg font-semibold mb-2 text-right">{{ $device['device_name'] }}</h3>
                            <p class="text-gray-700 mb-1">موديل: {{ $device['model'] }}</p>
                            <p class="text-gray-700 mb-2 overflow-auto break-words">{{ $device['description'] }}</p>
                            @if(!empty($device['image']))
                                <img src="{{ asset('storage/' . $device['image']) }}" class="mx-auto mt-2 h-32 object-contain rounded" />
                            @endif
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
