
<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">الوجهات السياحية</label>

    <div class="overflow-y-auto max-h-72 border border-gray-300 rounded bg-white">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-3 py-2 text-right">الاسم</th>
                    <th class="border border-gray-300 px-3 py-2 text-right">الوصف</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الصورة</th>
                    <th class="border border-gray-300 px-3 py-2 text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($Destenations as $index => $destination)
                    <tr>
                        @if($DestenationsEditingIndex === $index)
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="Destenations.{{ $index }}.name" placeholder="اسم الوجهة" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <textarea wire:model.lazy="Destenations.{{ $index }}.description" placeholder="وصف الوجهة" class="w-full p-1 border rounded" rows="2"></textarea>
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if(isset($destination['image']) && $destination['image'])
                                    <img src="{{ is_string($destination['image']) ? asset('storage/'.$destination['image']) : $destination['image']->temporaryUrl() }}" class="mx-auto w-24 h-16 object-cover rounded" alt="صورة الوجهة">
                                @endif
                                <input type="file" wire:model="Destenations.{{ $index }}.image" class="mt-1" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="saveDestination({{ $index }})" class="text-green-600 hover:text-green-800 mr-2" title="حفظ">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeDestination({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
                            <td class="border border-gray-300 px-2 py-1">{{ $destination['name'] }}</td>
                            <td class="border border-gray-300 px-2 py-1">{{ Str::limit($destination['description'], 50) }}</td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if(!empty($destination['image']))
                                    <img src="{{ asset('storage/' . $destination['image']) }}" alt="صورة الوجهة" class="mx-auto w-24 h-16 object-cover rounded" />
                                @endif
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="editDestination({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeDestination({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex gap-3">
        <button wire:click="addDestination" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + إضافة وجهة جديدة
        </button>
        <button wire:click="saveDestenations" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            حفظ الوجهات
        </button>
    </div>
</div>
