<div class="mb-6" dir="rtl">
    <label class="block text-base font-semibold mb-3 text-gray-700">الأجهزة المدعومة التي تقوم بتصليحها</label>

    <div class="overflow-x-auto max-h-72 border border-gray-300 rounded bg-white">
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
                    <tr>
                        @if($supportedDevicesEditingIndex === $index)
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="supportedDevices.{{ $index }}.device_name" placeholder="اسم الجهاز" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                <input type="text" wire:model.lazy="supportedDevices.{{ $index }}.model" placeholder="موديل الجهاز" class="w-full p-1 border rounded" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1 max-w-xs">
                                <textarea wire:model.lazy="supportedDevices.{{ $index }}.description" placeholder="وصف الجهاز (اختياري)" class="w-full p-1 border rounded resize-y max-h-24 overflow-y-auto"></textarea>
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center">
                                @if(isset($device['image']) && $device['image'])
                                    <img src="{{ is_string($device['image']) ? asset('storage/'.$device['image']) : $device['image']->temporaryUrl() }}" class="mx-auto w-24 h-16 object-cover rounded" alt="صورة الجهاز">
                                @endif
                                <input type="file" wire:model="supportedDevices.{{ $index }}.image" class="mt-1" />
                            </td>
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="saveSupportedDevice({{ $index }})" class="text-green-600 hover:text-green-800 mr-2" title="حفظ">
                                    <i class="ri-save-line text-lg"></i>
                                </button>
                                <button wire:click="removeSupportedDevice({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </td>
                        @else
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
                            <td class="border border-gray-300 px-2 py-1 text-center whitespace-nowrap">
                                <button wire:click="editSupportedDevice({{ $index }})" class="text-blue-600 hover:text-blue-800 mr-2" title="تعديل">
                                    <i class="ri-edit-line text-lg"></i>
                                </button>
                                <button wire:click="removeSupportedDevice({{ $index }})" class="text-red-600 hover:text-red-800" title="حذف">
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
        <button wire:click="addSupportedDevice" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + إضافة جهاز مدعوم
        </button>
        <button wire:click="saveSupportedDevices" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            حفظ الأجهزة
        </button>
    </div>

    {{-- مودال تعديل جهاز --}}
    @if($supportedDevicesEditingIndex !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-auto">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 mx-auto max-h-[90vh] overflow-auto" dir="rtl">
                <h3 class="text-lg font-semibold mb-4 text-right">تعديل جهاز مدعوم</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-right">
                    <div>
                        <label class="block mb-1 font-medium">اسم الجهاز</label>
                        <input type="text" wire:model.lazy="supportedDevices.{{ $supportedDevicesEditingIndex }}.device_name" class="w-full p-2 border rounded" />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">موديل الجهاز</label>
                        <input type="text" wire:model.lazy="supportedDevices.{{ $supportedDevicesEditingIndex }}.model" class="w-full p-2 border rounded" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1 font-medium">الوصف</label>
                        <textarea wire:model.lazy="supportedDevices.{{ $supportedDevicesEditingIndex }}.description" rows="4" class="w-full p-2 border rounded resize-y max-h-32 overflow-y-auto"></textarea>
                    </div>

                    <div class="md:col-span-2 text-center">
                        <label class="block mb-1 font-medium">الصورة</label>
                        <input type="file" wire:model="supportedDevices.{{ $supportedDevicesEditingIndex }}.image" accept="image/*" class="mx-auto" />
                        @if (isset($supportedDevices[$supportedDevicesEditingIndex]['image']) && is_object($supportedDevices[$supportedDevicesEditingIndex]['image']))
                            <img src="{{ $supportedDevices[$supportedDevicesEditingIndex]['image']->temporaryUrl() }}" class="mx-auto mt-2 h-24 object-contain rounded" />
                        @elseif (!empty($supportedDevices[$supportedDevicesEditingIndex]['image']) && is_string($supportedDevices[$supportedDevicesEditingIndex]['image']))
                            <img src="{{ asset('storage/' . $supportedDevices[$supportedDevicesEditingIndex]['image']) }}" class="mx-auto mt-2 h-24 object-contain rounded" />
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('supportedDevicesEditingIndex', null)" class="px-4 py-2 border rounded hover:bg-gray-100">إلغاء</button>
                    <button wire:click="saveSupportedDevice({{ $supportedDevicesEditingIndex }})" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ التعديل</button>
                </div>
            </div>
        </div>
    @endif
</div>
