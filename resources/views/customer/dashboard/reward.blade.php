@extends('customer.layouts.app')
@section('content')

@livewire('under-review') 
<br>


<div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">المكافآت والنقاط</h1>
            <p class="text-slate-500 mt-1">استبدل نقاطك بمكافآت وجوائز قيمة.</p>
        </div>

        <!-- رصيد النقاط -->
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg text-center">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="font-semibold tracking-tight text-lg text-slate-600">رصيدك الحالي من النقاط</h3>
            </div>
            <div class="p-6 pt-0">
                <p class="text-5xl font-bold text-primary flex items-center justify-center gap-2">
                    --
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="w-10 h-10 text-amber-400">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </p>
            </div>
        </div>

        <!-- مكافآت يمكن استبدالها -->
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-xl font-semibold leading-none tracking-tight">مكافآت يمكن استبدالها</h3>
            </div>
            <div class="p-6 pt-0 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- جائزة 1 -->
                <div class="p-4 border rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <rect x="3" y="8" width="18" height="4" rx="1"></rect>
                            <path d="M12 8v13"></path>
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>
                        </svg>
                        <div>
                            <p class="font-semibold">خصم --%</p>
                            <p class="text-sm text-slate-500">-- نقطة</p>
                        </div>
                    </div>
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium border bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        استبدال
                    </button>
                </div>

                <!-- جائزة 2 -->
                <div class="p-4 border rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                            <path d="M13 5v2"></path>
                            <path d="M13 17v2"></path>
                            <path d="M13 11v2"></path>
                        </svg>
                        <div>
                            <p class="font-semibold">تذكرة فعالية مجانية</p>
                            <p class="text-sm text-slate-500">-- نقطة</p>
                        </div>
                    </div>
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium border bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        استبدال
                    </button>
                </div>

                <!-- جائزة 3 -->
                <div class="p-4 border rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="w-6 h-6 text-primary">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                        <div>
                            <p class="font-semibold">ترقية VIP</p>
                            <p class="text-sm text-slate-500">-- نقطة</p>
                        </div>
                    </div>
                    <button class="inline-flex items-center justify-center rounded-md text-sm font-medium border bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        استبدال
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection