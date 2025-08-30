<div class="mb-6">
    <label class="block text-base font-semibold mb-3 text-gray-700">المنتجات</label>

<div class="flex overflow-x-auto gap-4 pb-2">
    @foreach ($products as $index => $product)
        <div class="flex-shrink-0 w-64 border rounded-lg shadow-sm bg-white">
            @if ($productsEditingIndex === $index)
                {{-- حالة التعديل --}}
                <div class="p-3 flex flex-col gap-2">
                    <input type="text" wire:model.lazy="products.{{ $index }}.name" placeholder="اسم المنتج" class="p-2 border rounded text-sm">
                    <input type="file" wire:model.lazy="products.{{ $index }}.image" class="p-2 border rounded text-sm">
                    <input type="text" wire:model.lazy="products.{{ $index }}.price" placeholder="السعر" class="p-2 border rounded text-sm">
                    <input type="text" wire:model.lazy="products.{{ $index }}.category" placeholder="التصنيف" class="p-2 border rounded text-sm">
                    <input type="text" wire:model.lazy="products.{{ $index }}.booth" placeholder="رقم الجناح" class="p-2 border rounded text-sm">
                    <input type="text" wire:model.lazy="products.{{ $index }}.link" placeholder="رابط المنتج" class="p-2 border rounded text-sm">
                    <textarea wire:model.lazy="products.{{ $index }}.description" placeholder="الوصف" class="p-2 border rounded text-sm"></textarea>
                    
                    <div class="flex justify-between mt-2">
                        <button wire:click="saveProduct({{ $index }})" class="text-green-600 hover:text-green-800">
                            <i class="ri-save-line text-lg"></i>
                        </button>
                        <button wire:click="removeProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </div>
                </div>
            @else
                {{-- حالة العرض --}}
                <img src="{{ is_string($product['image']) ? asset('storage/'.$product['image']) : 'https://via.placeholder.com/300x200' }}" class="w-full h-40 object-cover rounded-t-lg">
                <div class="p-3">
                    <h3 class="font-bold text-sm">{{ $product['name'] }}</h3>
                    <p class="text-xs text-gray-600 mb-1">{{ $product['category'] }} - جناح {{ $product['booth'] }}</p>
                    <p class="text-green-600 font-semibold">{{ $product['price'] }} ر.س</p>
                    <p class="text-xs text-gray-700 line-clamp-3">{{ $product['description'] }}</p>
                    
                    <div class="flex justify-between mt-2">
                        <button wire:click="editProduct({{ $index }})" class="text-blue-600 hover:text-blue-800">
                            <i class="ri-edit-line text-lg"></i>
                        </button>
                        <button wire:click="removeProduct({{ $index }})" class="text-red-600 hover:text-red-800">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>

<div class="flex items-center mt-4 gap-3">
    <button type="button" wire:click="addProduct" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
        + أضف منتج
    </button>

    <button type="button" wire:click="saveProducts" class="px-5 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition">
        حفظ كل المنتجات
    </button>
</div>
</div>