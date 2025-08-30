<div class="mb-6 font-sans">
    <label class="block text-2xl font-extrabold mb-6 text-indigo-600">🦸‍♂️ الشخصيات الكرتونية</label>

    <div class="flex space-x-6 overflow-x-auto pb-4">
        @foreach ($cartoons as $index => $cartoon)
            <div class="flex-shrink-0 w-72 bg-gradient-to-br from-indigo-100 via-indigo-200 to-indigo-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                @if ($cartoonEditingIndex === $index)
                    <input 
                        type="text" 
                        wire:model.lazy="cartoons.{{ $index }}.name" 
                        placeholder="اسم الشخصية" 
                        class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 font-semibold text-lg text-indigo-700"
                    />
                    <textarea 
                        wire:model.lazy="cartoons.{{ $index }}.description" 
                        placeholder="وصف الشخصية" 
                        rows="3"
                        class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm resize-none"
                    ></textarea>

                    <label class="block mb-2 font-semibold text-indigo-600">صورة الشخصية</label>
                    <input 
                        type="file" 
                        wire:model="cartoons.{{ $index }}.image" 
                        accept="image/*"
                        class="mb-3 w-full text-sm text-indigo-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer"
                    />

                    <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                        <button wire:click="saveCartoon({{ $index }})" class="text-indigo-600 hover:text-indigo-800 transition text-xl" title="حفظ">
                            <i class="ri-save-line"></i>
                        </button>
                        <button wire:click="removeCartoon({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @else
                    <div class="h-40 rounded-lg overflow-hidden mb-4 bg-indigo-50 flex items-center justify-center">
                        @if (!empty($cartoon['image']) && !is_object($cartoon['image']))
                            <img src="{{ asset('storage/' . $cartoon['image']) }}" alt="صورة الشخصية" class="object-cover w-full h-full" />
                        @elseif(is_object($cartoon['image']))
                            <img src="{{ $cartoon['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                        @else
                            <i class="ri-user-3-line text-6xl text-indigo-400"></i>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-indigo-700 mb-1 truncate">{{ $cartoon['name'] ?: 'بدون اسم' }}</h3>
                    <p class="text-sm text-indigo-600 mb-2 h-16 overflow-hidden">{{ $cartoon['description'] ?: 'لا يوجد وصف' }}</p>

                    <div class="flex justify-between items-center">
                        <button wire:click="editCartoon({{ $index }})" class="text-indigo-600 hover:text-indigo-800 transition text-xl" title="تعديل">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button wire:click="removeCartoon({{ $index }})" class="text-red-600 hover:text-red-800 transition text-xl" title="حذف">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="flex justify-between items-center mt-6">
        <button type="button" wire:click="addCartoon" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition">
            + أضف شخصية كرتونية جديدة
        </button>

        <button type="button" wire:click="saveCartoons" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">
            حفظ كل الشخصيات
        </button>
    </div>
</div>