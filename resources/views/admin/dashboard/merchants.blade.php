@extends('admin.layouts.app')
@section('content')




<div class="mb-6">
    <input type="text" id="searchInput"
           placeholder="ابحث عن تاجر..."
           class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300">
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($merchants as $merchant)
        @php
            $extra = $merchant->additional_data;
        @endphp

        <a href="{{ route('merchant.dashboard.m.overview', ['merchant' => $merchant->id]) }}"
            target="_blank" rel="noopener noreferrer"
            class="merchant-card block rounded-xl shadow-lg overflow-hidden bg-white 
           hover:shadow-xl hover:-translate-y-1 hover:scale-105 hover:bg-slate-50 
           transition transform duration-300
           ">

            {{-- صورة الغلاف --}}
            <div class="h-32 bg-gray-200">
                @if(!empty($extra['banner']))
                    <img src="{{ asset('storage/' . $extra['banner']) }}" 
                         alt="Banner" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                        Banner ?? NULL
                    </div>
                @endif
            </div>

            <div class="p-4">
                {{-- صورة البروفايل --}}
                <div class="flex items-center gap-3 mb-3">
                    @if(!empty($extra['profile_picture']))
                        <img src="{{ asset('storage/' . $extra['profile_picture']) }}" 
                             alt="Profile" class="w-12 h-12 rounded-full object-cover">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-xs text-gray-600">
                            ?? NULL
                        </div>
                    @endif

                    <div>
                        <h2 class="text-lg font-bold text-slate-800">
                            {{ $merchant->business_name ?? '?? NULL' }}
                        </h2>
                        <p class="text-sm text-slate-500">
                            {{ $merchant->business_type ?? '?? NULL' }}
                        </p>
                    </div>
                </div>

                {{-- معلومات إضافية --}}
                <p class="text-sm text-slate-700">
                    <strong>الاسم:</strong> {{ $merchant->f_name ?? '?? NULL' }} {{ $merchant->l_name ?? '' }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong>الهاتف:</strong> {{ $merchant->phone ?? '?? NULL' }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong>الإيميل:</strong> {{ $merchant->email ?? '?? NULL' }}
                </p>

                {{-- وقت الإنشاء --}}
                <p class="text-xs text-slate-500 mt-2">
                    <strong>تاريخ الإنشاء:</strong> {{ $merchant->created_at ?? '?? NULL' }}
                </p>
            </div>
        </a>
    @endforeach
</div>

{{-- الباجينيشن --}}
<div class="mt-8 flex justify-center">
    {{ $merchants->links('pagination::tailwind') }}
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".merchant-card");

        searchInput.addEventListener("keyup", function () {
            const query = this.value.toLowerCase();
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                card.style.display = text.includes(query) ? "" : "none";
            });
        });
    });
</script>

@endsection