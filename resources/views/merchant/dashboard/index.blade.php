@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])
@section('content')
    <div class="flex-1 p-8" bis_skin_checked="1">

        <div bis_skin_checked="1" style="opacity: 1; transform: none;">
            <div class="space-y-8" bis_skin_checked="1">
                <h2 class="text-3xl font-bold text-slate-800">نظرة عامة</h2>
                {{-- @livewire('under-review') --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" bis_skin_checked="1">
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">إجمالي المبيعات (اليوم)</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white from-green-400 to-emerald-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                    <polyline points="16 7 22 7 22 13"></polyline>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">{{$todayPayments}} ريال</p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">الحجوزات النشطة</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white from-blue-400 to-sky-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                    <path d="M13 5v2"></path>
                                    <path d="M13 17v2"></path>
                                    <path d="M13 11v2"></path>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900"> {{$activeReservationsCount}} </p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">الرصيد المتاح</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white bg-orange-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                                    <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">{{$wallet}} ريال</p>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg card-hover" bis_skin_checked="1">
                        <div class="space-y-1.5 p-6 flex flex-row items-center justify-between pb-2" bis_skin_checked="1">
                            <h3 class="tracking-tight text-sm font-medium text-slate-500">أكثر الفعاليات حجزاً</h3>
                            <div class="w-8 h-8 flex items-center justify-center rounded-lg text-white from-amber-400 to-orange-500" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path>
                                    <path d="M5 3v4"></path>
                                    <path d="M19 17v4"></path>
                                    <path d="M3 5h4"></path>
                                    <path d="M17 19h4"></path>
                                </svg></div>
                        </div>
                        <div class="p-6 pt-0" bis_skin_checked="1">
                            <p class="text-3xl font-bold text-slate-900">{{$topOfferName ?? "لايوجد"}}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                    <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                        <h3 class="text-xl font-semibold leading-none tracking-tight">الإشعارات الجديدة</h3>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <div class="p-6 pt-0 space-y-4">
                            @forelse ($notification as $note)
                                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-semibold text-slate-700">
                                            {{ $note->subject }}
                                        </h3>
                                        <span class="text-xs text-slate-400">
                                            {{ $note->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-slate-600 text-sm mb-2">
                                        {{ $note->message }}
                                    </p>
                                    @php
                                        $data = json_decode($note->additional_data, true);
                                    @endphp
                        
                                    @if(isset($data['from']) && isset($data['to']))
                                        <div class="text-xs text-slate-500">
                                            من: <span class="font-medium">{{ $data['from'] }}</span> |
                                            إلى: <span class="font-medium">{{ $data['to'] }}</span>
                                        </div>
                                    @endif
                        
                                    <div class="mt-2 text-xs">
                                        النوع:
                                        <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                            {{ $note->type }}
                                        </span>
                        
                                        @if(!$note->is_read)
                                            <span class="ml-2 inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-600">
                                                غير مقروء
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500">لا توجد إشعارات جديدة حالياً.</p>
                            @endforelse
                        
                            <div class="mt-4">
                                {{ $notification->links() }} 
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
