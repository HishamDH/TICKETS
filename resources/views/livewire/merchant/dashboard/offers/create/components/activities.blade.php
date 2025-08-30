<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">الفعاليات الجانبية</label>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
        @foreach ($activities as $index => $activity)
            <div class="border rounded-md p-4 shadow-sm bg-white relative">
                @if ($activityeditingIndex === $index)
                    {{-- حالة التعديل --}}
                    <div class="space-y-2">
                        <input type="text" wire:model.lazy="activities.{{ $index }}.title" placeholder="عنوان الفعالية" class="w-full p-2 border rounded text-sm">
                        <input type="time" wire:model.lazy="activities.{{ $index }}.time" class="w-full p-2 border rounded text-sm">
                        <input type="text" wire:model.lazy="activities.{{ $index }}.location" placeholder="الموقع" class="w-full p-2 border rounded text-sm">
                        <textarea wire:model.lazy="activities.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                        
                        <input type="file" wire:model="activities.{{ $index }}.image" class="w-full p-1 border rounded text-sm">
                        
                        <div class="flex justify-end gap-2 mt-2">
                            <button wire:click="saveActivityRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                <i class="ri-save-line text-lg"></i>
                            </button>
                            <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
                        </div>
                    </div>
                @else
                    {{-- حالة العرض --}}
                    <div class="space-y-1">
                        <h3 class="font-semibold text-sm text-gray-800">{{ $activity['title'] }}</h3>
                        <p class="text-xs text-gray-500">{{ $activity['time'] }} | {{ $activity['location'] }}</p>
                        <p class="text-sm text-gray-600 line-clamp-3">{{ $activity['description'] }}</p>

                        @if (!empty($activity['image']))
                            <img src="{{ asset('storage/' . $activity['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="Activity Image">
                        @endif
                    </div>

                    <div class="absolute top-2 left-2 flex gap-2">
                        <button wire:click="editActivityRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                            <i class="ri-edit-line text-lg"></i>
                        </button>
                        <button wire:click="removeActivity({{ $index }})" class="text-red-600 hover:text-red-800">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="flex items-center mt-4 gap-3">
        <button type="button" wire:click="addActivity" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + أضف فعالية
        </button>

        <button type="button" wire:click="saveActivities" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
            حفظ الفعاليات
        </button>
    </div>
</div>