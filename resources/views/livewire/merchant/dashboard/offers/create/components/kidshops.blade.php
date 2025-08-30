<div class="mb-6 font-sans">
    <label class="block text-2xl font-extrabold mb-6 text-teal-600">🛠️ ورش العمل</label>

    <div class="flex space-x-6 overflow-x-auto pb-4">
        @foreach ($workshops as $index => $workshop)
            <div class="flex-shrink-0 w-72 bg-gradient-to-br from-teal-100 via-teal-200 to-teal-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                @if ($workshopEditingIndex === $index)
                    <input 
                        type="text" 
                        wire:model.lazy="workshops.{{ $index }}.title" 
                        placeholder="عنوان الورشة" 
                        class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-400 font-semibold text-lg text-teal-700"
                    />
                    <textarea 
                        wire:model.lazy="workshops.{{ $index }}.description" 
                        placeholder="وصف الورشة" 
                        rows="3"
                        class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-400 text-sm resize-none"
                    ></textarea>

                    <label class="block mb-2 font-semibold text-teal-600">صورة الورشة</label>
                    <input 
                        type="file" 
                        wire:model="workshops.{{ $index }}.image" 
                        accept="image/*"
                        class="mb-3 w-full text-sm text-teal-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-100 file:text-teal-700 hover:file:bg-teal-200 cursor-pointer"
                    />

                    <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                        <button wire:click="saveWorkshop({{ $index }})" class="text-teal-600 hover:text-teal-800 transition text-xl" title="حفظ">
                            <i class="ri-save-line"></i>
                        </button>
                        <button wire:click="removeWorkshop({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @else
                    <div class="h-40 rounded-lg overflow-hidden mb-4 bg-teal-50 flex items-center justify-center">
                        @if (!empty($workshop['image']) && !is_object($workshop['image']))
                            <img src="{{ asset('storage/' . $workshop['image']) }}" alt="صورة الورشة" class="object-cover w-full h-full" />
                        @elseif(is_object($workshop['image']))
                            <img src="{{ $workshop['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                        @else
                            <i class="ri-tools-line text-6xl text-teal-400"></i>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-teal-700 mb-1 truncate">{{ $workshop['title'] ?: 'بدون عنوان' }}</h3>
                    <p class="text-sm text-teal-600 mb-2 h-16 overflow-hidden">{{ $workshop['description'] ?: 'لا يوجد وصف' }}</p>

                    <div class="flex justify-between items-center">
                        <button wire:click="editWorkshop({{ $index }})" class="text-teal-600 hover:text-teal-800 transition text-xl" title="تعديل">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button wire:click="removeWorkshop({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="flex justify-between items-center mt-6">
        <button type="button" wire:click="addWorkshop" class="px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition">
            + أضف ورشة جديدة
        </button>

        <button type="button" wire:click="saveWorkshops" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
            حفظ كل الورش
        </button>
    </div>
</div>