<div>
    <div class="space-y-6">
        <!-- العنوان -->
        <div>
            <h1 class="text-3xl font-bold text-slate-800">تجربتي</h1>
            <p class="text-slate-500 mt-1">استعرض تجاربك السابقة وشاركها مع الآخرين.</p>
        </div>

        <!-- العناصر -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($offerings as $offering)
                @php
                    $hasRated = $ratings->contains('offering_id', $offering->id);
                @endphp
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                    <div class="relative">
                        <img src="{{ Storage::url($offering->image) ?? 'https://via.placeholder.com/400x200' }}" alt="{{ $offering->title }}" class="w-full h-40 object-cover rounded-t-lg">
                        <div class="absolute inset-0 bg-black/40 rounded-t-lg"></div>
                        <div class="absolute bottom-2 right-2 text-white">
                            <h3 class="font-bold">{{ $offering->name }}</h3>
                            <p class="text-sm">{{ $offering->type ?? '' }}</p>
                        </div>
                    </div>
                    <div class="p-4 flex gap-2">
                        @if (!$hasRated)
                            <button
                                wire:click="openModal({{ $offering->id }})"
                                class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                                إضافة مراجعة
                            </button>
                        @else
                            <div class="text-green-600 font-semibold">تمت المراجعة ✅</div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-slate-500 col-span-full text-center">لا توجد تجارب سابقة حتى الآن.</p>
            @endforelse
        </div>
    </div>

    <!-- المودال -->
    @if($visible)
    <div
        wire:click.self="closeModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
            @livewire('ratings', ['id' => $selectID], key('ratings-modal'))
        </div>
    </div>
    @endif
</div>
