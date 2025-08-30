@extends('customer.layouts.app')
@section('content')



<div bis_skin_checked="1" style="opacity: 1; transform: none;">

    <div class="space-y-6" bis_skin_checked="1">
        <div bis_skin_checked="1">
            <h1 class="text-3xl font-bold text-slate-800">مرحباً بكِ، {{$user->f_name}}!</h1>
            <p class="text-slate-500 mt-1">نظرة سريعة على حسابك ونشاطك.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white shadow-lg bg-gradient-to-tr from-orange-500 to-indigo-600 text-white" bis_skin_checked="1">
            <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                <h3 class="text-xl font-semibold leading-none tracking-tight flex justify-between items-center"><span>حجزك القادم</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                        <line x1="16" x2="16" y1="2" y2="6"></line>
                        <line x1="8" x2="8" y1="2" y2="6"></line>
                        <line x1="3" x2="21" y1="10" y2="10"></line>
                    </svg></h3>
            </div>
            @if ($nearestReservation && $nearestReservation->additional_data)
            @php
                $data = json_decode($nearestReservation->additional_data);
            @endphp
        
            <div class="p-6 pt-0">
                <p class="text-2xl font-bold">
                    {{ $nearestReservation->offering->name ?? "--" }}
                </p>
        
                <p class="text-indigo-200">
                    {{ $data->selected_date ?? "---" }} / {{ $data->selected_time ?? "--" }}
                </p>
        
                <button class="inline-flex items-center justify-center rounded-md text-sm text-gray-900 font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gray-100 text-gray-100-foreground hover:bg-gray-100/80 h-10 px-4 py-2 mt-4">
                    عرض التذكرة
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                </button>
            </div>
        @else
            <div class="p-6 pt-0">
                <p class="text-gray-400">لا توجد حجز قريب</p>
            </div>
        @endif
        
        </div>
        <div class="grid md:grid-cols-2 gap-6" bis_skin_checked="1">
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                    <h3 class="text-xl font-semibold leading-none tracking-tight flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket">
                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                            <path d="M13 5v2"></path>
                            <path d="M13 17v2"></path>
                            <path d="M13 11v2"></path>
                        </svg> حجوزاتك النشطة</h3>
                </div>
                <div class="p-6 pt-0" bis_skin_checked="1">
                    <p class="text-3xl font-bold">{{$futureCount ?? "-"}}</p>
                    <p class="text-slate-500">لديك {{$futureCount ?? "-"}} حجوزات قادمة هذا الشهر.</p>
                </div>
            </div>
            {{-- <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                    <h3 class="text-xl font-semibold leading-none tracking-tight flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg> نقاط المكافآت</h3>
                </div>
                <div class="p-6 pt-0" bis_skin_checked="1">
                    <p class="text-3xl font-bold">-,-- نقطة</p>
                    <p class="text-slate-500">يمكنك استبدالها بخصومات رائعة!</p>
                </div>
            </div> --}}
        </div>
        <div class="rounded-2xl border text-slate-900 shadow-lg border-amber-500 bg-amber-50" bis_skin_checked="1">
            <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                <h3 class="text-xl font-semibold leading-none tracking-tight flex items-center gap-2 text-amber-800"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" x2="12" y1="8" y2="12"></line>
                        <line x1="12" x2="12.01" y1="16" y2="16"></line>
                    </svg> تنبيهات هامة</h3>
            </div>
            <div class="p-6 pt-0 text-amber-700" bis_skin_checked="1">
                <p>تم تحديث توقيت حجز "-- --" ليبدأ في الساعة -:-- مساءً بدلاً من --:- مساءً بناءً على طلبك.</p>
            </div>
        </div>
    </div>
</div>

@endsection
