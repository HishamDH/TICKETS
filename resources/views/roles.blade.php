@extends('layouts.app')
@section('content')
<main class="pt-16">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="min-h-screen bg-slate-50 py-16" bis_skin_checked="1">
            <div class="mx-[5%]">
                <div class="container mx-auto px-4" bis_skin_checked="1">
                    <div class="text-center mb-12" bis_skin_checked="1" style="opacity: 1; transform: none;">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-orange-500 mb-4">الأدوار والرحلات</h1>
                        <p class="text-lg text-slate-600 max-w-3xl mx-auto">لكل مستخدم دور فريد ورحلة مصممة بعناية لضمان تجربة سلسة وفعالة داخل منصة شباك التذاكر.</p>
                    </div>
                    <div dir="rtl" data-orientation="horizontal" class="w-full" bis_skin_checked="1">
                        <div role="tablist" aria-orientation="horizontal" class="items-center justify-center text-muted-foreground grid w-full grid-cols-1 sm:grid-cols-3 gap-2 h-auto p-2 bg-orange-500/10 rounded-xl mb-10" tabindex="0" data-orientation="horizontal" bis_skin_checked="1" style="outline: none;"><button type="button" role="tab" aria-selected="true" aria-controls="radix-:r9:-content-client" data-state="active" id="radix-:r9:-trigger-client" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2 text-sm md:text-base py-2.5" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>العميل</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r9:-content-merchant" data-state="inactive" id="radix-:r9:-trigger-merchant" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2 text-sm md:text-base py-2.5" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                    <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
                                    <path d="M2 7h20"></path>
                                    <path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path>
                                </svg>التاجر</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r9:-content-platform_staff" data-state="inactive" id="radix-:r9:-trigger-platform_staff" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2 text-sm md:text-base py-2.5" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>الإدارة</button></div>
                        <div bis_skin_checked="1" style="opacity: 1;">
                            <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r9:-trigger-client" id="radix-:r9:-content-client" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1" style="animation-duration: 0s;">
                                <div class="grid lg:grid-cols-2 gap-12 items-start" bis_skin_checked="1">
                                    <div bis_skin_checked="1">
                                        <h3 class="text-2xl font-bold text-slate-800 mb-2 flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg>الصلاحيات</h3>
                                        <p class="text-slate-500 mb-6">نظرة على الصلاحيات المتاحة لهذا الدور.</p>
                                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100" bis_skin_checked="1">
                                            <div class="overflow-x-auto" bis_skin_checked="1">
                                                <table class="w-full text-right">
                                                    <thead class="bg-slate-50">
                                                        <tr>
                                                            <th class="p-4 font-semibold text-sm text-slate-600">الصلاحية</th>
                                                            <th class="p-4 font-semibold text-sm text-slate-600">التوضيح</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-sky-600">
                                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                </svg>مشاهدة الفعاليات</td>
                                                            <td class="p-4 text-slate-700 text-sm">داخل صفحات التجار فقط، ليست في الموقع الرئيسي.</td>
                                                        </tr>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-emerald-600">
                                                                    <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                                                    <line x1="2" x2="22" y1="10" y2="10"></line>
                                                                </svg>الحجز والدفع</td>
                                                            <td class="p-4 text-slate-700 text-sm">حجز التذاكر أو الطاولات أو التسجيل بالمعرض مع الدفع المباشر.</td>
                                                        </tr>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-amber-600">
                                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                    <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                                                </svg>التعديل / الإلغاء</td>
                                                            <td class="p-4 text-slate-700 text-sm">ممكن فقط إن أنشأ حسابًا، ووفق سياسة التاجر.</td>
                                                        </tr>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-indigo-600">
                                                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                                    <line x1="16" x2="8" y1="13" y2="13"></line>
                                                                    <line x1="16" x2="8" y1="17" y2="17"></line>
                                                                    <line x1="10" x2="8" y1="9" y2="9"></line>
                                                                </svg>عرض سجل الحجوزات</td>
                                                            <td class="p-4 text-slate-700 text-sm">قائمة بجميع الحجوزات السابقة والمقبلة.</td>
                                                        </tr>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-orange-500">
                                                                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                                    <path d="M13 5v2"></path>
                                                                    <path d="M13 17v2"></path>
                                                                    <path d="M13 11v2"></path>
                                                                </svg>تحميل التذكرة</td>
                                                            <td class="p-4 text-slate-700 text-sm">مباشرة بعد الدفع، مع دعم Apple Wallet.</td>
                                                        </tr>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-yellow-500">
                                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                                </svg>التقييم</td>
                                                            <td class="p-4 text-slate-700 text-sm">تقييم الفعالية بعد الحضور.</td>
                                                        </tr>
                                                        <tr class="border-t border-slate-100" style="opacity: 1;">
                                                            <td class="p-4 font-bold text-orange-500 align-top flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-rose-500">
                                                                    <path d="M6 3h12l4 6-10 13L2 9Z"></path>
                                                                    <path d="M11 3 8 9l4 13 4-13-3-6"></path>
                                                                    <path d="M2 9h20"></path>
                                                                </svg>جمع النقاط</td>
                                                            <td class="p-4 text-slate-700 text-sm">حسب سياسة التاجر إن فعّل نظام المكافآت.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div bis_skin_checked="1">
                                        <h3 class="text-2xl font-bold text-slate-800 mb-2 flex items-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500">
                                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                                <polyline points="16 7 22 7 22 13"></polyline>
                                            </svg>الرحلة</h3>
                                        <p class="text-slate-500 mb-6">خطوات رحلة المستخدم من البداية إلى النهاية.</p>
                                        <div class="relative pr-8 border-r-2 border-orange-500/20" bis_skin_checked="1">
                                            <div class="mb-8 relative" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                                <div class="absolute -right-[1.1rem] top-1 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg" bis_skin_checked="1">1</div>
                                                <div class="bg-white p-6 rounded-2xl shadow-lg ml-4" bis_skin_checked="1">
                                                    <h4 class="font-bold text-slate-800 mb-2">الزيارة والاستكشاف</h4>
                                                    <p class="text-sm text-slate-600">يزور الموقع الفرعي للتاجر ويستعرض الفعالية أو الخدمة المتاحة.</p>
                                                </div>
                                            </div>
                                            <div class="mb-8 relative" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                                <div class="absolute -right-[1.1rem] top-1 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg" bis_skin_checked="1">2</div>
                                                <div class="bg-white p-6 rounded-2xl shadow-lg ml-4" bis_skin_checked="1">
                                                    <h4 class="font-bold text-slate-800 mb-2">الاختيار والحجز</h4>
                                                    <p class="text-sm text-slate-600">يختار التذكرة / الطاولة / التسجيل ويقوم بالدفع إلكترونيًا.</p>
                                                </div>
                                            </div>
                                            <div class="mb-8 relative" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                                <div class="absolute -right-[1.1rem] top-1 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg" bis_skin_checked="1">3</div>
                                                <div class="bg-white p-6 rounded-2xl shadow-lg ml-4" bis_skin_checked="1">
                                                    <h4 class="font-bold text-slate-800 mb-2">استلام التذكرة</h4>
                                                    <p class="text-sm text-slate-600">يحصل على التذكرة أو البادج مباشرة بعد الدفع.</p>
                                                </div>
                                            </div>
                                            <div class="mb-8 relative" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                                <div class="absolute -right-[1.1rem] top-1 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg" bis_skin_checked="1">4</div>
                                                <div class="bg-white p-6 rounded-2xl shadow-lg ml-4" bis_skin_checked="1">
                                                    <h4 class="font-bold text-slate-800 mb-2">الحضور والمشاركة</h4>
                                                    <p class="text-sm text-slate-600">يدخل الفعالية ويُسجّل حضوره باستخدام التذكرة.</p>
                                                </div>
                                            </div>
                                            <div class="mb-8 relative" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                                <div class="absolute -right-[1.1rem] top-1 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg" bis_skin_checked="1">5</div>
                                                <div class="bg-white p-6 rounded-2xl shadow-lg ml-4" bis_skin_checked="1">
                                                    <h4 class="font-bold text-slate-800 mb-2">ما بعد الفعالية</h4>
                                                    <p class="text-sm text-slate-600">يعود لحسابه لعرض سجل الحجوزات، تقييم التجربة، وإعادة الحجز مستقبلاً.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r9:-trigger-merchant" hidden="" id="radix-:r9:-content-merchant" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
                            <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r9:-trigger-platform_staff" hidden="" id="radix-:r9:-content-platform_staff" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" bis_skin_checked="1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
