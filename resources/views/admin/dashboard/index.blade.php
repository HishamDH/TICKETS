@extends('admin.layouts.app')
@section('content')

 @livewire('overview')  
{{-- <br>
<div bis_skin_checked="1" style="opacity: 1; transform: none;">
    <div class="space-y-8" bis_skin_checked="1">
        <div bis_skin_checked="1">
            <h1 class="text-3xl font-bold text-slate-800">نظرة عامة</h1>
            <p class="text-slate-500 mt-1">مرحباً بعودتك! إليك آخر المستجدات في المنصة.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" bis_skin_checked="1">
            <div bis_skin_checked="1">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg overflow-hidden cursor-pointer" bis_skin_checked="1">
                    <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2" bis_skin_checked="1">
                        <h3 class="tracking-tight text-sm font-medium text-slate-600">إجمالي الحجوزات (الشهر)</h3>
                        <div class="p-2 rounded-md bg-orange-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-orange-500">
                                <path d="M2 16V4a2 2 0 0 1 2-2h11"></path>
                                <path d="M5 14H4a2 2 0 1 0 0 4h1"></path>
                                <path d="M22 18H11a2 2 0 1 0 0 4h11V6H11a2 2 0 0 0-2 2v12"></path>
                            </svg></div>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <div class="text-3xl font-bold text-slate-800" bis_skin_checked="1">1,280</div>
                    </div>
                </div>
            </div>
            <div bis_skin_checked="1">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg overflow-hidden cursor-pointer" bis_skin_checked="1">
                    <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2" bis_skin_checked="1">
                        <h3 class="tracking-tight text-sm font-medium text-slate-600">إجمالي الإيرادات (الشهر)</h3>
                        <div class="p-2 rounded-md bg-emerald-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-emerald-500">
                                <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                                <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                                <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
                            </svg></div>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <div class="text-3xl font-bold text-slate-800" bis_skin_checked="1">95,430 ريال</div>
                    </div>
                </div>
            </div>
            <div bis_skin_checked="1" style="box-shadow: rgba(0, 0, 0, 0.08) 0px 0px 0px; transform: none;">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg overflow-hidden cursor-pointer" bis_skin_checked="1">
                    <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2" bis_skin_checked="1">
                        <h3 class="tracking-tight text-sm font-medium text-slate-600">تجار جدد (الشهر)</h3>
                        <div class="p-2 rounded-md bg-amber-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-500">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg></div>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <div class="text-3xl font-bold text-slate-800" bis_skin_checked="1">12</div>
                    </div>
                </div>
            </div>
            <div bis_skin_checked="1">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg overflow-hidden cursor-pointer" bis_skin_checked="1">
                    <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2" bis_skin_checked="1">
                        <h3 class="tracking-tight text-sm font-medium text-slate-600">طلبات سحب معلقة</h3>
                        <div class="p-2 rounded-md bg-red-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-red-500">
                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                <polyline points="16 7 22 7 22 13"></polyline>
                            </svg></div>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <div class="text-3xl font-bold text-slate-800" bis_skin_checked="1">8</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" bis_skin_checked="1">
            <div class="lg:col-span-2" bis_skin_checked="1">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
                    <div class="space-y-1.5 p-6 flex flex-row items-center justify-between" bis_skin_checked="1">
                        <div bis_skin_checked="1">
                            <h3 class="text-xl font-semibold leading-none tracking-tight">نظرة على الإيرادات</h3>
                            <p class="text-sm text-slate-500">آخر 6 أشهر</p>
                        </div><button class="inline-flex items-center justify-center text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 ml-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>تصدير التقرير</button>
                    </div>
                    <div class="p-6 pt-0" bis_skin_checked="1">
                        <div class="h-80 w-full" bis_skin_checked="1">
                            <div class="recharts-responsive-container" bis_skin_checked="1" style="width: 100%; height: 100%; min-width: 0px;">
                                <div class="recharts-wrapper" bis_skin_checked="1" style="position: relative; cursor: default; width: 100%; height: 100%; max-height: 320px; max-width: 409px;"><svg class="recharts-surface" width="409" height="320" viewBox="0 0 409 320" style="width: 100%; height: 100%;">
                                        <title></title>
                                        <desc></desc>
                                        <defs>
                                            <clipPath id="recharts8-clip">
                                                <rect x="50" y="5" height="280" width="339"></rect>
                                            </clipPath>
                                        </defs>
                                        <g class="recharts-cartesian-grid">
                                            <g class="recharts-cartesian-grid-horizontal">
                                                <line stroke-dasharray="3 3" stroke="#ccc" fill="none" x="50" y="5" width="339" height="280" x1="50" y1="285" x2="389" y2="285"></line>
                                                <line stroke-dasharray="3 3" stroke="#ccc" fill="none" x="50" y="5" width="339" height="280" x1="50" y1="215" x2="389" y2="215"></line>
                                                <line stroke-dasharray="3 3" stroke="#ccc" fill="none" x="50" y="5" width="339" height="280" x1="50" y1="145" x2="389" y2="145"></line>
                                                <line stroke-dasharray="3 3" stroke="#ccc" fill="none" x="50" y="5" width="339" height="280" x1="50" y1="75" x2="389" y2="75"></line>
                                                <line stroke-dasharray="3 3" stroke="#ccc" fill="none" x="50" y="5" width="339" height="280" x1="50" y1="5" x2="389" y2="5"></line>
                                            </g>
                                        </g>
                                        <g class="recharts-layer recharts-cartesian-axis recharts-xAxis xAxis">
                                            <g class="recharts-cartesian-axis-ticks">
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="bottom" width="339" height="30" stroke="none" font-size="12" x="78.25" y="293" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="middle" fill="#888888">
                                                        <tspan x="78.25" dy="0.71em">يناير</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="bottom" width="339" height="30" stroke="none" font-size="12" x="134.75" y="293" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="middle" fill="#888888">
                                                        <tspan x="134.75" dy="0.71em">فبراير</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="bottom" width="339" height="30" stroke="none" font-size="12" x="191.25" y="293" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="middle" fill="#888888">
                                                        <tspan x="191.25" dy="0.71em">مارس</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="bottom" width="339" height="30" stroke="none" font-size="12" x="247.75" y="293" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="middle" fill="#888888">
                                                        <tspan x="247.75" dy="0.71em">أبريل</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="bottom" width="339" height="30" stroke="none" font-size="12" x="304.25" y="293" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="middle" fill="#888888">
                                                        <tspan x="304.25" dy="0.71em">مايو</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="bottom" width="339" height="30" stroke="none" font-size="12" x="360.75" y="293" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="middle" fill="#888888">
                                                        <tspan x="360.75" dy="0.71em">يونيو</tspan>
                                                    </text></g>
                                            </g>
                                        </g>
                                        <g class="recharts-layer recharts-cartesian-axis recharts-yAxis yAxis">
                                            <g class="recharts-cartesian-axis-ticks">
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="left" width="60" height="280" stroke="none" font-size="12" x="42" y="285" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="end" fill="#888888">
                                                        <tspan x="42" dy="0.355em">0 ألف</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="left" width="60" height="280" stroke="none" font-size="12" x="42" y="215" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="end" fill="#888888">
                                                        <tspan x="42" dy="0.355em">1.5 ألف</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="left" width="60" height="280" stroke="none" font-size="12" x="42" y="145" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="end" fill="#888888">
                                                        <tspan x="42" dy="0.355em">3 ألف</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="left" width="60" height="280" stroke="none" font-size="12" x="42" y="75" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="end" fill="#888888">
                                                        <tspan x="42" dy="0.355em">4.5 ألف</tspan>
                                                    </text></g>
                                                <g class="recharts-layer recharts-cartesian-axis-tick"><text orientation="left" width="60" height="280" stroke="none" font-size="12" x="42" y="9" class="recharts-text recharts-cartesian-axis-tick-value" text-anchor="end" fill="#888888">
                                                        <tspan x="42" dy="0.355em">6 ألف</tspan>
                                                    </text></g>
                                            </g>
                                        </g>
                                        <g class="recharts-layer recharts-bar">
                                            <g class="recharts-layer recharts-bar-rectangles">
                                                <g class="recharts-layer">
                                                    <g class="recharts-layer recharts-bar-rectangle">
                                                        <path x="55.65" y="98.33333333333334" width="45" height="186.66666666666666" radius="4,4,0,0" fill="var(--color-orange-500)" name="يناير" class="recharts-rectangle" d="M55.65,102.33333333333334A 4,4,0,0,1,59.65,98.33333333333334L 96.65,98.33333333333334A 4,4,0,0,1,
        100.65,102.33333333333334L 100.65,285L 55.65,285Z"></path>
                                                    </g>
                                                    <g class="recharts-layer recharts-bar-rectangle">
                                                        <path x="112.15" y="145" width="45" height="140" radius="4,4,0,0" fill="var(--color-orange-500)" name="فبراير" class="recharts-rectangle" d="M112.15,149A 4,4,0,0,1,116.15,145L 153.15,145A 4,4,0,0,1,
        157.15,149L 157.15,285L 112.15,285Z"></path>
                                                    </g>
                                                    <g class="recharts-layer recharts-bar-rectangle">
                                                        <path x="168.65" y="51.66666666666666" width="45" height="233.33333333333334" radius="4,4,0,0" fill="var(--color-orange-500)" name="مارس" class="recharts-rectangle" d="M168.65,55.66666666666666A 4,4,0,0,1,172.65,51.66666666666666L 209.65,51.66666666666666A 4,4,0,0,1,
        213.65,55.66666666666666L 213.65,285L 168.65,285Z"></path>
                                                    </g>
                                                    <g class="recharts-layer recharts-bar-rectangle">
                                                        <path x="225.15" y="75" width="45" height="210" radius="4,4,0,0" fill="var(--color-orange-500)" name="أبريل" class="recharts-rectangle" d="M225.15,79A 4,4,0,0,1,229.15,75L 266.15,75A 4,4,0,0,1,
        270.15,79L 270.15,285L 225.15,285Z"></path>
                                                    </g>
                                                    <g class="recharts-layer recharts-bar-rectangle">
                                                        <path x="281.65" y="5" width="45" height="280" radius="4,4,0,0" fill="var(--color-orange-500)" name="مايو" class="recharts-rectangle" d="M281.65,9A 4,4,0,0,1,285.65,5L 322.65,5A 4,4,0,0,1,
        326.65,9L 326.65,285L 281.65,285Z"></path>
                                                    </g>
                                                    <g class="recharts-layer recharts-bar-rectangle">
                                                        <path x="338.15" y="28.333333333333343" width="45" height="256.66666666666663" radius="4,4,0,0" fill="var(--color-orange-500)" name="يونيو" class="recharts-rectangle" d="M338.15,32.33333333333334A 4,4,0,0,1,342.15,28.333333333333343L 379.15,28.333333333333343A 4,4,0,0,1,
        383.15,32.33333333333334L 383.15,285L 338.15,285Z"></path>
                                                    </g>
                                                </g>
                                            </g>
                                            <g class="recharts-layer"></g>
                                        </g>
                                    </svg>
                                    <div tabindex="-1" class="recharts-tooltip-wrapper" bis_skin_checked="1" style="visibility: hidden; pointer-events: none; position: absolute; top: 0px; left: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div bis_skin_checked="1">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg h-full flex flex-col" bis_skin_checked="1">
                    <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                        <h3 class="text-xl font-semibold leading-none tracking-tight">أحدث الأنشطة</h3>
                        <p class="text-sm text-slate-500">آخر العمليات التي تمت في المنصة.</p>
                    </div>
                    <div class="p-6 pt-0 flex-grow" bis_skin_checked="1">
                        <div class="space-y-6" bis_skin_checked="1">
                            <div class="flex items-start gap-4" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1596854307809-6e754c522f95?q=80&amp;w=200"></span>
                                <div bis_skin_checked="1">
                                    <p class="text-sm font-medium text-slate-800">متجر الزهور</p>
                                    <p class="text-sm text-slate-500">طلب سحب جديد بقيمة 500 ريال</p>
                                    <p class="text-xs text-slate-400">قبل 5 دقائق</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?q=80&amp;w=200"></span>
                                <div bis_skin_checked="1">
                                    <p class="text-sm font-medium text-slate-800">مطعم أكلات بحرية</p>
                                    <p class="text-sm text-slate-500">تحديث بيانات الحساب البنكي</p>
                                    <p class="text-xs text-slate-400">قبل 15 دقيقة</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&amp;w=200"></span>
                                <div bis_skin_checked="1">
                                    <p class="text-sm font-medium text-slate-800">فعالية إطلاق المنتج</p>
                                    <p class="text-sm text-slate-500">تمت الموافقة على الفعالية</p>
                                    <p class="text-xs text-slate-400">قبل ساعة</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4" bis_skin_checked="1"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&amp;w=200"></span>
                                <div bis_skin_checked="1">
                                    <p class="text-sm font-medium text-slate-800">أحمد (دعم فني)</p>
                                    <p class="text-sm text-slate-500">أغلق تذكرة دعم #1123</p>
                                    <p class="text-xs text-slate-400">قبل 3 ساعات</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-t" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-full">عرض كل الأنشطة <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                <path d="m12 19-7-7 7-7"></path>
                                <path d="M19 12H5"></path>
                            </svg></button></div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
