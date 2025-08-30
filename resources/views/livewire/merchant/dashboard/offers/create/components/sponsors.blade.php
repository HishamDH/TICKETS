<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">الرعاة</label>

    <div class="overflow-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full min-w-max table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 font-medium">
            <tr>
                <th class="border px-3 py-2">الاسم</th>
                <th class="border px-3 py-2">المستوى</th>
                <th class="border px-3 py-2">الرابط</th>
                <th class="border px-3 py-2">الوصف</th>
                <th class="border px-3 py-2">الشعار</th>
                <th class="border px-3 py-2">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="text-center text-gray-800">
            @foreach ($sponsors as $index => $sponsor)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-2 py-1">{{ $sponsor['name'] }}</td>
                    <td class="border px-2 py-1">{{ $sponsor['level'] }}</td>
                    <td class="border px-2 py-1">
                        <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 hover:underline">الرابط</a>
                    </td>
                    {{-- <td class="border px-2 py-1">{{ }}</td> --}}
                    <td class="border px-2 py-1 max-w-xs">
                        <div class="max-h-20 overflow-y-auto break-words">
                          {{ $sponsor['description']  }}
                        </div>
                      </td>
                    <td class="border px-2 py-1">
                        @if ($sponsor['logo'])
                            <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="w-16 h-16 object-contain mx-auto" />
                        @else
                            <span class="text-gray-400 text-xs">لا يوجد</span>
                        @endif
                    </td>
                    <td class="border px-2 py-1 flex justify-center gap-2 items-center">
                        <button wire:click="$set('sponsorEditingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800" title="تعديل">
                            <i class="ri-edit-line text-lg"></i>
                        </button>
                        <button wire:click="removeSponsor({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="flex items-center mt-4 gap-3">
        <button type="button" wire:click="addSponsor" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + أضف راعٍ
        </button>

        <button type="button" wire:click="saveSponsors" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
            حفظ كل الرعاة
        </button>
    </div>

    {{-- مودال التعديل --}}
    @if($sponsorEditingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 mx-4 relative">
                <h3 class="text-lg font-semibold mb-4">تعديل الراعي</h3>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">الاسم</label>
                        <input type="text" wire:model.lazy="sponsors.{{ $sponsorEditingIndex }}.name" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">المستوى</label>
                        <input type="text" wire:model.lazy="sponsors.{{ $sponsorEditingIndex }}.level" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">الرابط</label>
                        <input type="url" wire:model.lazy="sponsors.{{ $sponsorEditingIndex }}.link" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">الوصف</label>
                        <input type="text" wire:model.lazy="sponsors.{{ $sponsorEditingIndex }}.description" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">الشعار</label>
                        <input type="file" wire:model="sponsors.{{ $sponsorEditingIndex }}.logo" class="w-full" />
                        @if (isset($sponsors[$sponsorEditingIndex]['logo']) && is_object($sponsors[$sponsorEditingIndex]['logo']))
                            <img src="{{ $sponsors[$sponsorEditingIndex]['logo']->temporaryUrl() }}" class="w-24 h-24 object-contain mt-2 mx-auto" />
                        @elseif (!empty($sponsors[$sponsorEditingIndex]['logo']) && is_string($sponsors[$sponsorEditingIndex]['logo']))
                            <img src="{{ asset('storage/' . $sponsors[$sponsorEditingIndex]['logo']) }}" class="w-24 h-24 object-contain mt-2 mx-auto" />
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('sponsorEditingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveSponsorRow({{ $sponsorEditingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>
