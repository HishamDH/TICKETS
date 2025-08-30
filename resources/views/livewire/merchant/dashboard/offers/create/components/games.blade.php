 
        <div class="mb-6 font-sans">
            <label class="block text-2xl font-extrabold mb-6 text-pink-600">🎲 الألعاب</label>
        
            <div class="flex space-x-6 overflow-x-auto pb-4">
                @foreach ($games as $index => $game)
                    <div class="flex-shrink-0 w-72 bg-gradient-to-br from-pink-100 via-pink-200 to-pink-300 rounded-xl shadow-lg p-5 relative text-gray-800">
                        @if ($gamesEditingIndex === $index)
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.name" 
                                placeholder="اسم اللعبة" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 font-semibold text-lg text-pink-700"
                            />
                            <textarea 
                                wire:model.lazy="games.{{ $index }}.description" 
                                placeholder="وصف اللعبة" 
                                rows="3"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none"
                            ></textarea>
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.age_range" 
                                placeholder="الفئة العمرية" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.location" 
                                placeholder="المكان" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <input 
                                type="text" 
                                wire:model.lazy="games.{{ $index }}.supervisor" 
                                placeholder="المشرف" 
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm"
                            />
                            <textarea 
                                wire:model.lazy="games.{{ $index }}.rules" 
                                placeholder="قوانين اللعبة" 
                                rows="2"
                                class="w-full mb-3 px-3 py-2 rounded-lg border-2 border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400 text-sm resize-none"
                            ></textarea>
        
                            <label class="block mb-2 font-semibold text-pink-600">صورة اللعبة</label>
                            <input 
                                type="file" 
                                wire:model="games.{{ $index }}.image" 
                                accept="image/*"
                                class="mb-3 w-full text-sm text-pink-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-100 file:text-pink-700 hover:file:bg-pink-200 cursor-pointer"
                            />
        
                            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                                <button 
                                    wire:click="saveGame({{ $index }})" 
                                    class="text-pink-600 hover:text-pink-800 transition text-xl" 
                                    title="حفظ"
                                >
                                    <i class="ri-save-line"></i>
                                </button>
                                <button 
                                    wire:click="removeGame({{ $index }})" 
                                    class="text-red-600 hover:text-red-800 transition text-xl" 
                                    title="حذف"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
        
                        @else
                            <div class="h-40 rounded-lg overflow-hidden mb-4 bg-pink-50 flex items-center justify-center">
                                @if (!empty($game['image']) && !is_object($game['image']))
                                    <img src="{{ asset('storage/' . $game['image']) }}" alt="صورة اللعبة" class="object-cover w-full h-full" />
                                @elseif(is_object($game['image']))
                                    <img src="{{ $game['image']->temporaryUrl() }}" alt="صورة مؤقتة" class="object-cover w-full h-full" />
                                @else
                                    <i class="ri-gamepad-line text-6xl text-pink-400"></i>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-pink-700 mb-1 truncate">{{ $game['name'] ?: 'بدون اسم' }}</h3>
                            <p class="text-sm text-pink-600 mb-1">الفئة العمرية: <span class="font-semibold">{{ $game['age_range'] ?: 'غير محددة' }}</span></p>
                            <p class="text-sm text-gray-700 mb-2 h-12 overflow-hidden">{{ $game['description'] ?: 'لا يوجد وصف' }}</p>
                            <p class="text-xs text-gray-500 mb-1">المكان: {{ $game['location'] ?: 'غير محدد' }}</p>
                            <p class="text-xs text-gray-500 mb-3">المشرف: {{ $game['supervisor'] ?: 'غير محدد' }}</p>
        
                            <div class="flex justify-between items-center">
                                <button 
                                    wire:click="editGame({{ $index }})" 
                                    class="text-pink-600 hover:text-pink-800 transition text-xl" 
                                    title="تعديل"
                                >
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button 
                                    wire:click="removeGame({{ $index }})" 
                                    class="text-red-600 hover:text-red-800 transition text-xl" 
                                    title="حذف"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        
            <div class="flex justify-between items-center mt-6">
                <button 
                    type="button" 
                    wire:click="addGame" 
                    class="px-5 py-2 bg-pink-600 hover:bg-pink-700 text-white rounded-lg font-semibold transition"
                >
                    + أضف لعبة جديدة
                </button>
        
                <button 
                    type="button" 
                    wire:click="saveGames" 
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition"
                >
                    حفظ كل الألعاب
                </button>
            </div>
        </div>