<div class="mb-6" dir="rtl">
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
                <th class="border px-3 py-2">الإجراءات</th>
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
                                          <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                        <button wire:click="$set('editingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800" title="تعديل">
                            <i class="ri-edit-line text-lg"></i>
                        </button>
                        <button wire:click="removeSession({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="flex items-center mt-4 gap-3">
        <button type="button" wire:click="addSession" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + أضف جلسة
        </button>

        <button type="button" wire:click="saveSessions" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
            حفظ كل الجلسات
        </button>
    </div>

    {{-- مودال التعديل --}}
    @if($editingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 mx-4 relative">
                <h3 class="text-lg font-semibold mb-4">تعديل الجلسة</h3>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">المتحدث</label>
                        <input type="text" wire:model.lazy="sessions.{{ $editingIndex }}.speaker" class="w-full p-2 border rounded" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">التاريخ</label>
                            <input type="date" wire:model.lazy="sessions.{{ $editingIndex }}.date" class="w-full p-2 border rounded" />
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">الوقت</label>
                            <input type="time" wire:model.lazy="sessions.{{ $editingIndex }}.time" class="w-full p-2 border rounded" />
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">المكان</label>
                        <input type="text" wire:model.lazy="sessions.{{ $editingIndex }}.location" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">الوصف</label>
                        <textarea wire:model.lazy="sessions.{{ $editingIndex }}.description" rows="3" class="w-full p-2 border rounded resize-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('editingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveRow({{ $editingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>