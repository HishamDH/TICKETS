<div class="mb-6" dir="rtl">
    <label class="block text-lg font-semibold mb-3 text-gray-700">الدورات & الورش التدريبية</label>

    <div class="overflow-x-auto max-h-[450px] border border-gray-300 rounded bg-white">
        <table class="w-full text-sm border border-gray-200 rounded overflow-hidden shadow-sm table-auto">
            <thead class="bg-gray-100 text-gray-700 font-medium">
                <tr>
                    <th class="border px-3 py-2">العنوان</th>
                    <th class="border px-3 py-2">الوصف</th>
                    <th class="border px-3 py-2">المدة</th>
                    <th class="border px-3 py-2">المكان</th>
                    <th class="border px-3 py-2">المدرب</th>
                    <th class="border px-3 py-2">الشهادة</th>
                    <th class="border px-3 py-2">الصورة</th>
                    <th class="border px-3 py-2">الإجراءات</th>
                </tr>
            </thead>

            <tbody class="text-center text-gray-800">
                @foreach ($trainingWorkshops as $index => $w)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-2 py-1">{{ $w['title'] }}</td>
                        <td class="border px-2 py-1 max-w-xs">
                            <div class="max-h-20 overflow-y-auto break-words px-1">
                                {{ $w['description'] }}
                            </div>
                        </td>
                        <td class="border px-2 py-1">{{ $w['duration'] }}</td>
                        <td class="border px-2 py-1">{{ $w['location'] }}</td>
                        <td class="border px-2 py-1">{{ $w['instructor'] }}</td>
                        <td class="border px-2 py-1">{{ $w['certificate'] ? 'نعم' : 'لا' }}</td>
                        <td class="border px-2 py-1">
                            @if (!empty($w['image']) && !is_object($w['image']))
                                <img src="{{ asset('storage/' . $w['image']) }}" class="h-16 object-cover mx-auto" />
                            @else
                                <span class="text-gray-400 text-xs">لا صورة</span>
                            @endif
                        </td>
                        <td class="border px-2 py-1 flex justify-center gap-2 items-center whitespace-nowrap">
                            <button wire:click="$set('trainingWorkshopsEditingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800" title="تعديل">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeTrainingWorkshop({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex items-center mt-4 gap-3">
        <button type="button" wire:click="addTrainingWorkshop" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + أضف ورشة / دورة
        </button>

        <button type="button" wire:click="saveTrainingWorkshops" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
            حفظ كل الورش والدورات
        </button>
    </div>

    {{-- مودال تعديل ورشة / دورة --}}
    @if($trainingWorkshopsEditingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-auto">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 mx-auto max-h-[90vh] overflow-auto">
                <h3 class="text-lg font-semibold mb-4 text-right">تعديل ورشة / دورة</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-right" dir="rtl">
                    <div>
                        <label class="block mb-1 font-medium">العنوان</label>
                        <input type="text" wire:model.lazy="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.title" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">المدة</label>
                        <input type="text" wire:model.lazy="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.duration" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">المكان</label>
                        <input type="text" wire:model.lazy="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.location" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">المدرب</label>
                        <input type="text" wire:model.lazy="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.instructor" class="w-full p-2 border rounded" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">الوصف</label>
                        <textarea wire:model.lazy="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.description" rows="4" class="w-full p-2 border rounded resize-y"></textarea>
                    </div>

                    <div class="md:col-span-2 flex items-center gap-3">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" wire:model.lazy="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.certificate" class="form-checkbox h-5 w-5" />
                            <span>يوجد شهادة</span>
                        </label>
                    </div>

                    <div class="md:col-span-2 text-center">
                        <label class="block mb-1 font-medium">الصورة</label>
                        <input type="file" wire:model="trainingWorkshops.{{ $trainingWorkshopsEditingIndex }}.image" accept="image/*" class="mx-auto" />
                        @if (isset($trainingWorkshops[$trainingWorkshopsEditingIndex]['image']) && is_object($trainingWorkshops[$trainingWorkshopsEditingIndex]['image']))
                            <img src="{{ $trainingWorkshops[$trainingWorkshopsEditingIndex]['image']->temporaryUrl() }}" class="mx-auto mt-2 h-24 object-contain rounded" />
                        @elseif (!empty($trainingWorkshops[$trainingWorkshopsEditingIndex]['image']) && is_string($trainingWorkshops[$trainingWorkshopsEditingIndex]['image']))
                            <img src="{{ asset('storage/' . $trainingWorkshops[$trainingWorkshopsEditingIndex]['image']) }}" class="mx-auto mt-2 h-24 object-contain rounded" />
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('trainingWorkshopsEditingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveTrainingWorkshop({{ $trainingWorkshopsEditingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>
