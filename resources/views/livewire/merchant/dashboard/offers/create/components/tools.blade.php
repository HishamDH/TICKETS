<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">الأدوات المتاحة</label>

    <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-700 font-medium">
                    <th class="border border-gray-300 px-3 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">التصنيف</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الموديل</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">التوفر</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">المميزات</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-800">
                @foreach ($availableTools as $index => $tool)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border border-gray-300 px-2 py-1">{{ $tool['name'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ $tool['category'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ $tool['model'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ $tool['availability'] }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ Str::limit($tool['features'], 50) }}</td>
                        <td class="border border-gray-300 px-2 py-1">{{ Str::limit($tool['description'], 50) }}</td>
                        <td class="border border-gray-300 px-2 py-1 text-center">
                            @if (!empty($tool['image']))
                                <img src="{{ asset('storage/' . $tool['image']) }}" class="mx-auto w-16 h-16 object-cover rounded" alt="صورة الأداة">
                            @endif
                        </td>
                        <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                            <button wire:click="$set('availableToolsEditingIndex', {{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                <i class="ri-edit-line text-lg"></i>
                            </button>
                            <button wire:click="removeAvailableTool({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex gap-3">
        <button wire:click="addAvailableTool" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + أضف أداة جديدة
        </button>
        <button wire:click="saveAvailableTools" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            حفظ الأدوات
        </button>
    </div>

    {{-- مودال تعديل الأداة --}}
    @if($availableToolsEditingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 mx-4 relative overflow-auto max-h-[90vh]">
                <h3 class="text-lg font-semibold mb-4">تعديل الأداة</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-medium">الاسم</label>
                        <input type="text" wire:model.lazy="availableTools.{{ $availableToolsEditingIndex }}.name" class="w-full p-2 border rounded" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">التصنيف</label>
                        <input type="text" wire:model.lazy="availableTools.{{ $availableToolsEditingIndex }}.category" class="w-full p-2 border rounded" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">الموديل</label>
                        <input type="text" wire:model.lazy="availableTools.{{ $availableToolsEditingIndex }}.model" class="w-full p-2 border rounded" />
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">التوفر</label>
                        <input type="text" wire:model.lazy="availableTools.{{ $availableToolsEditingIndex }}.availability" class="w-full p-2 border rounded" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">المميزات</label>
                        <textarea wire:model.lazy="availableTools.{{ $availableToolsEditingIndex }}.features" rows="3" class="w-full p-2 border rounded"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">الوصف</label>
                        <textarea wire:model.lazy="availableTools.{{ $availableToolsEditingIndex }}.description" rows="3" class="w-full p-2 border rounded"></textarea>
                    </div>
                    <div class="md:col-span-2 text-center">
                        <label class="block mb-1 font-medium">الصورة</label>
                        <input type="file" wire:model="availableTools.{{ $availableToolsEditingIndex }}.image" class="mx-auto" />
                        @if (isset($availableTools[$availableToolsEditingIndex]['image']) && is_object($availableTools[$availableToolsEditingIndex]['image']))
                            <img src="{{ $availableTools[$availableToolsEditingIndex]['image']->temporaryUrl() }}" class="mx-auto mt-2 w-24 h-24 object-contain rounded" />
                        @elseif (!empty($availableTools[$availableToolsEditingIndex]['image']) && is_string($availableTools[$availableToolsEditingIndex]['image']))
                            <img src="{{ asset('storage/' . $availableTools[$availableToolsEditingIndex]['image']) }}" class="mx-auto mt-2 w-24 h-24 object-contain rounded" />
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('availableToolsEditingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveAvailableTool({{ $availableToolsEditingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>
