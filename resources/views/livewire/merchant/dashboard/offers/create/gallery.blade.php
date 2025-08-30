<div class="space-y-6">

    {{-- صورة أساسية --}}
    <div>
        <label class="block text-sm font-medium mb-1">الصورة الأساسية <span class="text-red-500" style="font-weight: bold;">*</span></label>
        <input type="file" wire:model="image" class="mb-2">

        @if ($offering->image)
            <img src="{{ Storage::url($offering->image) ?? null}}" class="h-32 rounded-lg shadow">
        @endif

        @error('image') <p class="text-red-500 text-sm">{{ $message ?? null }}</p> @enderror
    </div>

    {{-- صور الجالري --}}
    <div>
        <label class="block text-sm font-medium mb-1">صور المعرض (Gallery)</label>
        <input type="file" wire:model="gallery1" multiple class="mb-2">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            @foreach ($gallery as $index => $imagePath)
            @php
                $url = is_array($imagePath) ? Storage::url($imagePath['path'] ?? '') : Storage::url($imagePath);
            @endphp
            <div class="relative group">
                <img src="{{ $url }}" class="w-full h-28 object-cover rounded-md shadow">
                <button wire:click="removeGalleryImage({{ $index }})" type="button"
                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs hidden group-hover:flex items-center justify-center">
                    ✕
                </button>
            </div>
        @endforeach

        </div>
    </div>

</div>
