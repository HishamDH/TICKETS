<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">مزايا العرض (Offer Features)</label>

    <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-700 font-medium">
                    <th class="border border-gray-300 px-3 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach($Offerfeatures as $index => $feature)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border border-gray-300 px-2 py-1">{{ $feature['name'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ Str::limit($feature['description'], 50) }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-center">
                            @if(!empty($feature['image']))
                                <img src="{{ asset('storage/' . $feature['image']) }}" alt="صورة الميزة" class="mx-auto w-24 h-16 object-cover rounded" />
                            @endif
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                            <button wire:click="$set('OfferfeaturesEditingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeOfferFeature({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex gap-3">
        <button wire:click="addOfferFeature" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + إضافة ميزة جديدة
        </button>
        <button wire:click="saveOfferFeatures" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            حفظ المزايا
        </button>
    </div>

    {{-- مودال تعديل ميزة العرض --}}
    @if($OfferfeaturesEditingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 mx-4 relative overflow-auto max-h-[90vh]">
                <h3 class="text-lg font-semibold mb-4">تعديل ميزة العرض</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">الاسم</label>
                        <input type="text" wire:model.lazy="Offerfeatures.{{ $OfferfeaturesEditingIndex }}.name" placeholder="اسم الميزة" class="w-full p-2 border rounded" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">الوصف</label>
                        <textarea wire:model.lazy="Offerfeatures.{{ $OfferfeaturesEditingIndex }}.description" placeholder="وصف الميزة" rows="3" class="w-full p-2 border rounded"></textarea>
                    </div>
                    <div class="md:col-span-2 text-center">
                        <label class="block mb-1 font-medium">الصورة</label>
                        <input type="file" wire:model="Offerfeatures.{{ $OfferfeaturesEditingIndex }}.image" class="mx-auto" />
                        @if (isset($Offerfeatures[$OfferfeaturesEditingIndex]['image']) && is_object($Offerfeatures[$OfferfeaturesEditingIndex]['image']))
                            <img src="{{ $Offerfeatures[$OfferfeaturesEditingIndex]['image']->temporaryUrl() }}" class="mx-auto mt-2 w-24 h-16 object-contain rounded" />
                        @elseif (!empty($Offerfeatures[$OfferfeaturesEditingIndex]['image']) && is_string($Offerfeatures[$OfferfeaturesEditingIndex]['image']))
                            <img src="{{ asset('storage/' . $Offerfeatures[$OfferfeaturesEditingIndex]['image']) }}" class="mx-auto mt-2 w-24 h-16 object-contain rounded" />
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('OfferfeaturesEditingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveOfferFeature({{ $OfferfeaturesEditingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>
