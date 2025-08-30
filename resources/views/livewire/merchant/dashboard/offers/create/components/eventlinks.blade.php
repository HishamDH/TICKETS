<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">روابط الفعالية</label>

    <div class="overflow-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full min-w-max table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2 whitespace-nowrap">المنصة</th>
                    <th class="border px-3 py-2 whitespace-nowrap">الرابط</th>
                    <th class="border px-3 py-2 whitespace-nowrap">الوصف</th>
                    <th class="border px-3 py-2 whitespace-nowrap">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($links as $index => $link)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-2 py-1 whitespace-nowrap">{{ $link['platform'] }}</td>
                        <td class="border px-2 py-1 whitespace-nowrap">
                            <a href="{{ $link['url'] }}" target="_blank" class="text-blue-500 underline break-all">{{ $link['url'] }}</a>
                        </td>
                        {{-- <td class="border px-2 py-1 break-words max-w-xs">
                            
                        </td> --}}
                        <td class="border px-2 py-1 max-w-xs">
                            <div class="max-h-20 overflow-y-auto break-words">
                                {{ $link['description'] }}
                            </div>
                          </td>
                        <td class="border px-2 py-1 flex justify-center gap-2 items-center whitespace-nowrap">
                            <button wire:click="$set('linksEditingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeLink({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex items-center mt-4 gap-3">
        <button type="button" wire:click="addLink" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + أضف رابط
        </button>

        <button type="button" wire:click="saveLinks" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
            حفظ كل الروابط
        </button>
    </div>

    {{-- مودال التعديل --}}
    @if($linksEditingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 mx-4 relative overflow-auto max-h-[90vh]">
                <h3 class="text-lg font-semibold mb-4">تعديل رابط الفعالية</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">المنصة</label>
                        <input type="text" wire:model.lazy="links.{{ $linksEditingIndex }}.platform" placeholder="اسم المنصة" class="w-full p-2 border rounded" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">الرابط</label>
                        <input type="text" wire:model.lazy="links.{{ $linksEditingIndex }}.url" placeholder="الرابط" class="w-full p-2 border rounded" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">الوصف</label>
                        <textarea wire:model.lazy="links.{{ $linksEditingIndex }}.description" placeholder="وصف الرابط" rows="4" class="w-full p-2 border rounded resize-y overflow-auto max-h-40"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('linksEditingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveLink({{ $linksEditingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>
