@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($workPLace as $place)
        @php
            $extra = $place->additional_data;
        @endphp

        <a href="{{ route('merchant.dashboard.m.overview', ['merchant' => $place->id]) }}"
            target="_blank" rel="noopener noreferrer"
            class="block rounded-xl shadow-lg overflow-hidden bg-white 
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
                            {{ $place->business_name ?? '?? NULL' }}
                        </h2>
                        <p class="text-sm text-slate-500">
                            {{ $place->business_type ?? '?? NULL' }}
                        </p>
                    </div>
                </div>

                {{-- معلومات إضافية --}}
                <p class="text-sm text-slate-700">
                    <strong>الاسم:</strong> {{ $place->f_name ?? '?? NULL' }} {{ $place->l_name ?? '' }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong>الهاتف:</strong> {{ $place->phone ?? '?? NULL' }}
                </p>
                <p class="text-sm text-slate-700">
                    <strong>الإيميل:</strong> {{ $place->email ?? '?? NULL' }}
                </p>

                {{-- وقت الإنشاء --}}
                <p class="text-xs text-slate-500 mt-2">
                    <strong>تاريخ الإنشاء:</strong> {{ $place->created_at ?? '?? NULL' }}
                </p>
            </div>
        </a>
    @endforeach
</div>

@endsection