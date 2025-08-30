@extends('layouts.app')
@section('content')
<main class="pt-16">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="min-h-screen bg-slate-50 py-16" bis_skin_checked="1">
            <div class="mx-[5%]">
                <div class="container mx-auto px-4" bis_skin_checked="1">
                    <div class="text-center mb-12" bis_skin_checked="1" style="opacity: 1; transform: none;">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-orange-500 mb-4">أسعار شفافة تناسب الجميع</h1>
                        <p class="text-lg text-slate-600 max-w-3xl mx-auto">اختر الخطة التي تناسب حجم أعمالك وطموحاتك، بلا عقود طويلة الأمد أو رسوم خفية.</p>
                    </div>
                    <div class="flex  lg:grid-cols-3 gap-8 justify-center max-w-5xl mx-auto" bis_skin_checked="1">
                        <!-- <div class="relative bg-white rounded-3xl p-8 shadow-xl border border-slate-200" bis_skin_checked="1" style="opacity: 1; transform: none;">
                            <div class="text-center" bis_skin_checked="1">
                                <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg></div>
                                <h3 class="text-2xl font-bold text-slate-800 mb-2">الأساسية</h3>
                                <p class="text-slate-500 mb-6">مثالية للبدايات والفعاليات الصغيرة.</p>
                                <div class="mb-8" bis_skin_checked="1"><span class="text-4xl font-extrabold text-slate-900">5%</span><span class="text-slate-500 ml-1">+ 1 ريال / تذكرة</span></div>
                            </div>
                            <ul class="space-y-4 mb-10">
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">موقع فرعي جاهز</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">دعم 3 فعاليات نشطة</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">نظام حجز أساسي</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">سحب الأرباح خلال 48 ساعة</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">دعم فني عبر البريد الإلكتروني</span>
                                </li>
                            </ul><button class="inline-flex items-center justify-center ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-11 rounded-md px-8 w-full py-6 text-lg font-bold bg-orange-500/10 text-orange-500 hover:bg-orange-500/20">ابدأ الآن</button>
                        </div> -->
                        <div class="relative bg-white rounded-3xl p-8 shadow-xl border border-orange-500" bis_skin_checked="1" style="opacity: 1; transform: none;">
                            <div class="absolute top-0 right-8 -translate-y-1/2 bg-orange-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold flex items-center gap-2" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>الأكثر شيوعاً</div>
                            <div class="text-center" bis_skin_checked="1">
                                <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg></div>

                                <h3 class="text-2xl font-bold text-slate-800 mb-2">الأساسية</h3>
                                <p class="text-slate-500 mb-6">مجاني للمنشئات المبتدئة والمتوسطة</p>
                                <div class="mb-8" bis_skin_checked="1"><span class="text-4xl font-extrabold text-slate-900">3.5%</span><span class="text-slate-500 ml-1">+ 1.5 ريال / تذكرة على الحجوزات المدفوعة</span></div>
                            </div>
                            <ul class="space-y-4 mb-10">
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">موقع فرعي جاهز (والشعار والهوية الخاصة بك )</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">نظام حجز أساسي</span>
                                </li>

                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">إدارة فريق العمل بصلاحيات</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">تقارير وتحليلات متقدمة</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">دعم فني فوري (شات)</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">إدارة الحجوزات</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">نظام دفع امن</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">سحب الارباح خلال ٧٢ ساعة من رفع طلب السحب</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">مركز رسائل مباشرة مع العملاء</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg></div><span class="text-slate-600">نظام التحقق من التذاكر</span>
                                </li>
                            </ul><button class="inline-flex items-center justify-center ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-500/90 h-11 rounded-md px-8 w-full py-6 text-lg font-bold bg-orange-500 text-white">اختر الخطة الأساسية</button>
                        </div>
                        <div class="relative bg-white rounded-3xl p-8 shadow-xl border border-slate-200" bis_skin_checked="1" style="opacity: 1; transform: none;">
                            <div class="text-center" bis_skin_checked="1">
                                <div class="w-16 h-16 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg></div>
                                <h3 class="text-2xl font-bold text-slate-800 mb-2">الاحترافية</h3>
                                <p class="text-slate-500 mb-6">للتجار المتمرسين والشركات النامية.</p>
                                <!-- <div class="mb-8" bis_skin_checked="1"><span class="text-4xl font-extrabold text-slate-900">مخصص</span><span class="text-slate-500 ml-1">حلول متكاملة</span></div> -->
                            </div>
                            <div class="relative">
                                <ul class="space-y-4 mb-10 blur-sm">
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">موقع فرعي جاهز (والشعار والهوية الخاصة بك )</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">نظام حجز أساسي</span>
                                    </li>

                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">إدارة فريق العمل بصلاحيات</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">تقارير وتحليلات متقدمة</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">دعم فني فوري (شات)</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">إدارة الحجوزات</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">نظام دفع امن</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">سحب الارباح خلال ٧٢ ساعة من رفع طلب السحب</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">مركز رسائل مباشرة مع العملاء</span>
                                    </li>
                                    <li class="flex items-center">
                                        <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center ml-3 flex-shrink-0" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3.5 w-3.5 text-green-600">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg></div><span class="text-slate-600">نظام التحقق من التذاكر</span>
                                    </li>
                                </ul>
                                <div class="absolute top-[50%] right-[30%]">
                                    <button class="inline-flex items-center justify-center bg-orange-500/100 transition-colors disabled:pointer-events-none disabled:opacity-50 h-11 rounded-md px-8 w-full py-6 text-lg font-bold text-white hover:bg-orange-500/20">قريبا</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
