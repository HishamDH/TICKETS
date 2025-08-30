<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">البورتفوليو</label>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-h-[400px] overflow-y-auto pr-1">
        @foreach ($Portfolio as $index => $item)
            <div class="border rounded-md p-4 shadow-sm bg-white relative">
                @if ($portfolioEditingIndex === $index)
                    <div class="space-y-2">
                        <input type="text" wire:model.lazy="Portfolio.{{ $index }}.title" placeholder="العنوان" class="w-full p-2 border rounded text-sm" />
                        <textarea wire:model.lazy="Portfolio.{{ $index }}.description" placeholder="الوصف" class="w-full p-2 border rounded text-sm"></textarea>
                        <input type="url" wire:model.lazy="Portfolio.{{ $index }}.link" placeholder="الرابط" class="w-full p-2 border rounded text-sm" />
                        <input type="date" wire:model.lazy="Portfolio.{{ $index }}.date" class="w-full p-2 border rounded text-sm" />
                        <input type="text" wire:model.lazy="Portfolio.{{ $index }}.tools" placeholder="الأدوات مفصولة بفواصل" class="w-full p-2 border rounded text-sm" />
                        <input type="file" wire:model="Portfolio.{{ $index }}.image" class="w-full p-2 border rounded text-sm" />
                        
                        <div class="flex justify-end gap-2 mt-2">
                            <button wire:click="savePortfolioRow({{ $index }})" class="text-green-600 hover:text-green-800">
                                حفظ
                            </button>
                            <button wire:click="removePortfolio({{ $index }})" class="text-red-600 hover:text-red-800">
                                حذف
                            </button>
                        </div>
                    </div>
                @else
                    <div class="space-y-1">
                        <h3 class="font-semibold text-sm text-gray-800">{{ $item['title'] }}</h3>
                        <p class="text-xs text-gray-500">{{ $item['date'] }}</p>
                        <p class="text-sm text-gray-600 line-clamp-3">{{ $item['description'] }}</p>
                        <p class="text-xs text-gray-500">الأدوات: {{ $item['tools'] }}</p>
                        <a href="{{ $item['link'] }}" target="_blank" class="text-blue-600 underline text-sm">رابط المشروع</a>

                        @if (!empty($item['image']))
                            <img src="{{ asset('storage/' . $item['image']) }}" class="mt-2 w-full h-28 object-cover rounded" alt="صورة المشروع">
                        @endif
                    </div>

                    <div class="absolute top-2 left-2 flex gap-2">
                        <button wire:click="editPortfolioRow({{ $index }})" class="text-blue-600 hover:text-blue-800">
                            تعديل
                        </button>
                        <button wire:click="removePortfolio({{ $index }})" class="text-red-600 hover:text-red-800">
                            حذف
                        </button>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="flex items-center mt-4 gap-3">
        <button wire:click="addPortfolio" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + أضف مشروع جديد
        </button>

        <button wire:click="savePortfolio" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            حفظ البورتفوليو
        </button>
    </div>
</div>