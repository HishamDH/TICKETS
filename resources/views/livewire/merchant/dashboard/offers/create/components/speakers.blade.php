<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">المتحدثين</label>

    <div class="flex gap-4 overflow-x-auto py-2 px-1">
        @foreach ($speakers as $index => $speaker)
            <div class="min-w-[250px] max-w-[250px] bg-white border rounded-lg shadow-sm p-3 relative">
                
                {{-- صورة المتحدث --}}
                <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                    @if(is_string($speaker['image']) && $speaker['image'] !== '')
                        <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                    @else
                        <span class="text-gray-400">لا صورة</span>
                    @endif
                </div>

                {{-- بيانات المتحدث --}}
                @if ($SpeakereditingIndex === $index)
                    <div class="space-y-2">
                        <input type="text" wire:model.lazy="speakers.{{ $index }}.name" placeholder="الاسم" class="w-full p-1 border rounded text-sm" />
                        <input type="text" wire:model.lazy="speakers.{{ $index }}.title" placeholder="الوظيفة/اللقب" class="w-full p-1 border rounded text-sm" />
                        <input type="text" wire:model.lazy="speakers.{{ $index }}.cv" placeholder="رابط السيرة الذاتية" class="w-full p-1 border rounded text-sm" />
                        <textarea wire:model.lazy="speakers.{{ $index }}.shortDescreption" placeholder="نبذة قصيرة" class="w-full p-1 border rounded text-sm"></textarea>
                        <input type="file" wire:model="speakers.{{ $index }}.image" class="w-full text-sm" />
                    </div>

                    <div class="flex justify-between mt-2 text-sm">
                        <button wire:click="saveSpeaker({{ $index }})" class="text-green-600 hover:text-green-800"><i class="ri-save-line text-lg"></i></button>
                        <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                    </div>
                @else
                    <div class="space-y-1 text-sm text-gray-800">
                        <p><strong>{{ $speaker['name'] }}</strong></p>
                        <p>{{ $speaker['title'] }}</p>
                        <p class="text-xs text-gray-600">{{ $speaker['shortDescreption'] }}</p>
                    </div>

                    <div class="flex justify-between mt-2 text-sm">
                        <button wire:click="editSpeaker({{ $index }})" class="text-blue-600 hover:text-blue-800"><i class="ri-edit-line text-lg"></i></button>
                        <button wire:click="removeSpeaker({{ $index }})" class="text-red-600 hover:text-red-800"><i class="ri-delete-bin-line text-lg"></i></button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- زر الإضافة والحفظ --}}
    <div class="flex items-center mt-4 gap-3">
        <button type="button" wire:click="addSpeaker" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
            + أضف متحدث
        </button>

        <button type="button" wire:click="saveSpeakers" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
            حفظ كل المتحدثين
        </button>
    </div>
</div>