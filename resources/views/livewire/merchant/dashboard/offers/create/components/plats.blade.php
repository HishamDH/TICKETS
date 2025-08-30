<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">الأطباق في المطاعم</label>

    <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-3 py-2 text-right">اسم الطبق</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">السعر</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">السعرات الحرارية</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plats as $index => $plat)
                    <tr>
                        <td class="border border-gray-300 px-2 py-1">{{ $plat['name'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ Str::limit($plat['description'], 50) }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-center">
                            @if(!empty($plat['image']))
                                <img src="{{ is_string($plat['image']) ? asset('storage/' . $plat['image']) : $plat['image']->temporaryUrl() }}" alt="صورة الطبق" class="mx-auto w-24 h-16 object-cover rounded" />
                            @endif
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center">{{ $plat['price'] }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-center">{{ $plat['calories'] ?? '-' }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                            <button wire:click="$set('platsEditingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removePlat({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- مودال التعديل الكبير --}}
    @if($platsEditingIndex !== null)
        @php
            $plat = $plats[$platsEditingIndex];
        @endphp
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" dir="rtl">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-6 mx-4 relative overflow-auto max-h-[90vh]">
                <h3 class="text-lg font-semibold mb-4 text-right text-blue-700">تعديل الطبق</h3>
                
                <div class="mb-4 text-right">
                    <label class="block mb-1 font-semibold">اسم الطبق</label>
                    <input type="text" wire:model.lazy="plats.{{ $platsEditingIndex }}.name" class="w-full p-2 border rounded" placeholder="اسم الطبق" />
                </div>

                <div class="mb-4 text-right">
                    <label class="block mb-1 font-semibold">وصف الطبق</label>
                    <textarea wire:model.lazy="plats.{{ $platsEditingIndex }}.description" class="w-full p-2 border rounded" rows="4" placeholder="وصف الطبق"></textarea>
                </div>

                <div class="mb-4 text-right">
                    <label class="block mb-1 font-semibold">مسببات الحساسية</label>
                    <textarea wire:model.lazy="plats.{{ $platsEditingIndex }}.allergens" class="w-full p-2 border rounded resize-none" rows="3" placeholder="مسببات الحساسية"></textarea>
                </div>

                <div class="mb-4 text-center">
                    @if(isset($plat['image']) && $plat['image'])
                        <img src="{{ is_string($plat['image']) ? asset('storage/'.$plat['image']) : $plat['image']->temporaryUrl() }}" class="mx-auto w-48 h-32 object-cover rounded mb-2" alt="صورة الطبق">
                    @endif
                    <input type="file" wire:model="plats.{{ $platsEditingIndex }}.image" class="mx-auto" />
                </div>

                <div class="mb-4 text-right flex gap-4">
                    <div class="flex-1">
                        <label class="block mb-1 font-semibold">السعر</label>
                        <input type="number" wire:model.lazy="plats.{{ $platsEditingIndex }}.price" class="w-full p-2 border rounded text-center" placeholder="السعر" />
                    </div>

                    <div class="flex-1">
                        <label class="block mb-1 font-semibold">السعرات الحرارية</label>
                        <input type="number" wire:model.lazy="plats.{{ $platsEditingIndex }}.calories" class="w-full p-2 border rounded text-center" placeholder="السعرات الحرارية" />
                    </div>
                </div>

                <div class="text-center mt-6 flex justify-center gap-6">
                    <button wire:click="savePlat({{ $platsEditingIndex }})" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">حفظ</button>
                    <button wire:click="$set('platsEditingIndex', null)" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">إلغاء</button>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-4 flex gap-3 justify-center">
        <button wire:click="addPlat" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + إضافة طبق جديد
        </button>
        <button wire:click="savePlats" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            حفظ الأطباق
        </button>
    </div>
</div>
