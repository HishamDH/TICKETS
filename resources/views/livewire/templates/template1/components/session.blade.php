<div class="mb-6" dir="rtl" x-data="{ openIndex: null }">
    <label class="block text-base font-semibold mb-3 text-gray-700">الجلسات</label>

    <div class="overflow-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full min-w-max table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">المتحدث</th>
                    <th class="border px-3 py-2">التاريخ</th>
                    <th class="border px-3 py-2">الوقت</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">More</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($sessions as $index => $session)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-2 py-1">{{ $session['speaker'] }}</td>
                        <td class="border px-2 py-1">{{ $session['date'] }}</td>
                        <td class="border px-2 py-1">{{ $session['time'] }}</td>
                        <td class="border px-2 py-1">{{ $session['location'] }}</td>
                        <td class="border px-2 py-1 max-w-xs">
                            <div class="max-h-20 overflow-y-auto break-words">
                              {{ $session['description'] }}
                            </div>
                        </td>
                        <td class="border px-2 py-1">
                            <button @click="openIndex = {{ $index }}" class="text-blue-600 font-semibold hover:text-blue-800">
                                More
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- مودال Alpine --}}
    @foreach ($sessions as $index => $session)
        <div x-show="openIndex === {{ $index }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 mx-4 relative">
                <button @click="openIndex = null" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                <h3 class="text-lg font-semibold mb-3">{{ $session['speaker'] }}</h3>
                <p class="text-sm text-gray-700 mb-1">التاريخ: {{ $session['date'] }}</p>
                <p class="text-sm text-gray-700 mb-1">الوقت: {{ $session['time'] }}</p>
                <p class="text-sm text-gray-700 mb-1">المكان: {{ $session['location'] }}</p>
                <p class="text-gray-700 mt-2 overflow-auto break-words">{{ $session['description'] }}</p>
            </div>
        </div>
    @endforeach
</div>
