<div dir="rtl" class="max-w-6xl mx-auto p-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">

    @foreach($work_in as $merchant)
        @php
            $extra = $merchant->additional_data;
        @endphp
<a href="{{route("merchant.dashboard.m.overview",$merchant)}}">
        <div class="bg-white shadow-lg rounded-xl p-6 flex flex-col gap-4 border border-slate-100 transition-all duration-300 hover:shadow-xl hover:border-orange-300">
            
            <div class="flex justify-center">
                @if(!empty($extra['profile_picture']))
                    <img src="{{ asset('storage/' . $extra['profile_picture']) }}" alt="الصورة الشخصية" class="w-24 h-24 rounded-full object-cover shadow-md border border-slate-200">
                @else
                    <i class="ri-user-3-line text-7xl text-slate-300"></i>
                @endif
            </div>

            <h3 class="text-lg font-bold text-orange-500 text-center">
                {{ $merchant->f_name }} {{ $merchant->l_name }}
            </h3>

            <div class="text-sm text-gray-700 flex flex-col gap-1">
                <p class="flex items-center">
                    <i class="ri-mail-line ml-2 text-orange-400"></i>
                    {{ $merchant->email }}
                </p>
                <p class="flex items-center">
                    <i class="ri-phone-line ml-2 text-orange-400"></i>
                    {{ $merchant->phone }}
                </p>
            </div>

            {{-- النشاط التجاري --}}
            <div class="text-sm text-gray-700 flex flex-col gap-1 mt-2">
                <p class="flex items-center">
                    <i class="ri-store-2-line ml-2 text-orange-400"></i>
                    {{ $merchant->business_name }}
                </p>
                <p class="flex items-center">
                    <i class="ri-briefcase-line ml-2 text-orange-400"></i>
                    {{ $merchant->business_type }}
                    @if(!empty($extra['other_business_type']))
                        ({{ $extra['other_business_type'] }})
                    @endif
                </p>
            </div>

            {{-- الحالة --}}
            <div class="mt-2 flex items-center gap-2 text-sm">
                <i class="ri-shield-check-line text-orange-400"></i>
                <span class="@if($merchant->status == 'active') text-green-600 @else text-red-600 @endif font-semibold">
                    {{ ucfirst($merchant->status) }}
                </span>
            </div>

        </div>
</a>
    @endforeach

</div>
