@extends('layouts.app')
@section('content')
<!-- Hero Section -->
<section class="min-h-screen flex flex-col justify-center items-center text-center bg-[#F5EFF1] pt-24 px-4">
    <img src="{{ Storage::url(LoadConfig()->setup->logo ?? null) }}" alt="logo"
        class="w-40 h-40 mb-6 floating-animation" />
    <h1 class="text-5xl md:text-7xl font-extrabold mb-6 text-orange-500 text-orange-500">
        {{ LoadConfig()->setup->name ?? null  }}
    </h1>
    <p class="text-lg md:text-xl text-gray-700 max-w-xl mb-6">
        بوابتك الذكية لإدارة وبيع تذاكر الفعاليات والحجوزات
    </p>
    <p class="text-lg text-slate-500 mb-12 max-w-2xl mx-auto">منصة متكاملة تمكّن التجار من إدارة حجوزاتهم وبيع
        التذاكر بكل سهولة وأمان عبر مواقعهم الخاصة، مع توفير تجربة فريدة للعملاء.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ Auth::id()?route('dashboard'):route('register') }}"
            class="flex justify-center items-center bg-orange-500 hover:bg-orange-600 text-white px-12 py-3 rounded-lg shadow-lg shadow-orange-300 text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="ml-2 h-5 w-5">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg> انضم كتاجر الآن
        </a>
        <!-- <button
            class="flex justify-center items-center border-2 border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white px-6 py-3 rounded-lg text-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="ml-2 h-5 w-5">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
            </svg> استعراض لوحات التحكم
        </button> -->
    </div>
</section>
<section class="py-24 bg-slate-50">
    <div class="mx-[5%]">
        <div class="container mx-auto px-4" bis_skin_checked="1">
            <div class="text-center mb-16" bis_skin_checked="1" style="opacity: 1; transform: none;">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-orange-500">لماذا شباك التذاكر؟</h2>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto">نوفر لك كل ما تحتاجه لإدارة أعمالك بكفاءة
                    واحترافية،
                    مع التركيز على نموك ونجاحك.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" bis_skin_checked="1">
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-white">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg></div>
                    <h3 class="text-xl font-bold mb-4 text-slate-800">موقع مستقل لكل تاجر</h3>
                    <p class="text-slate-600 leading-relaxed">احصل على موقعك الخاص بتصميم مخصص وهوية بصرية فريدة
                        تعكس
                        علامتك التجارية.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10 text-white">
                            <rect width="14" height="20" x="5" y="2" rx="2" ry="2">
                            </rect>
                            <path d="M12 18h.01"></path>
                        </svg></div>
                    <h3 class="text-xl font-bold mb-4 text-slate-800">واجهة سهلة الاستخدام</h3>
                    <p class="text-slate-600 leading-relaxed">تصميم عصري ومتجاوب يعمل على جميع الأجهزة بسلاسة،
                        ليضمن
                        تجربة رائعة لعملائك.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2">
                            </rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg></div>
                    <h3 class="text-xl font-bold mb-4 text-slate-800">أمان متقدم</h3>
                    <p class="text-slate-600 leading-relaxed">نظام حماية عالي المستوى لبياناتك وبيانات عملائك، مع
                        تشفير
                        متطور للمدفوعات.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg></div>
                    <h3 class="text-xl font-bold mb-4 text-slate-800">سرعة في الأداء</h3>
                    <p class="text-slate-600 leading-relaxed">بنية تحتية قوية تضمن نظاماً سريعاً وموثوقاً لضمان
                        تجربة
                        مستخدم لا مثيل لها.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                            <polyline points="16 7 22 7 22 13"></polyline>
                        </svg></div>
                    <h3 class="text-xl font-bold mb-4 text-slate-800">تقارير تفصيلية</h3>
                    <p class="text-slate-600 leading-relaxed">احصل على إحصائيات شاملة ولوحات بيانات تفاعلية لمتابعة
                        أداء أعمالك بدقة.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover cursor-pointer text-center"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-md"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <circle cx="12" cy="8" r="6"></circle>
                            <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>
                        </svg></div>
                    <h3 class="text-xl font-bold mb-4 text-slate-800">دعم فني متميز</h3>
                    <p class="text-slate-600 leading-relaxed">فريق دعم متخصص متاح لمساعدتك في كل خطوة، لضمان تحقيق
                        أقصى
                        استفادة من المنصة.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-24 bg-white">
    <div class="mx-[5%]">
        <div class="container mx-auto px-4" bis_skin_checked="1">
            <div class="text-center mb-16" bis_skin_checked="1" style="opacity: 1; transform: none;">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-orange-500">خدماتنا المتكاملة</h2>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto">حلول شاملة ومصممة خصيصاً لتلبية جميع احتياجاتك
                    في
                    إدارة الفعاليات والحجوزات.</p>
            </div>
            <div class="grid lg:grid-cols-3 gap-8" bis_skin_checked="1">
                <div class="bg-orange-500/5 p-8 rounded-3xl border border-primary/10 card-hover cursor-pointer"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 shadow-lg"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2">
                            </rect>
                            <line x1="16" x2="16" y1="2" y2="6"></line>
                            <line x1="8" x2="8" y1="2" y2="6"></line>
                            <line x1="3" x2="21" y1="10" y2="10"></line>
                        </svg></div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">إدارة الفعاليات</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">نظام متكامل لإدارة جميع أنواع الفعاليات مع خرائط
                        مقاعد تفاعلية.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>خرائط مقاعد تفاعلية</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>إدارة الأسعار المرنة</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>تقارير المبيعات الحية</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>نظام إشعارات ذكي</li>
                    </ul>
                </div>
                <div class="bg-orange-500/5 p-8 rounded-3xl border border-primary/10 card-hover cursor-pointer"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 shadow-lg"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg></div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">حجوزات المطاعم</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">إدارة طاولات المطاعم وأوقات العمل مع نظام حجز
                        متطور.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>إدارة الطاولات الذكية</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>جدولة المواعيد بسهولة</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>قوائم طعام رقمية</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>نظام تقييمات العملاء</li>
                    </ul>
                </div>
                <div class="bg-orange-500/5 p-8 rounded-3xl border border-primary/10 card-hover cursor-pointer"
                    bis_skin_checked="1" style="opacity: 1; transform: none;">
                    <div class="w-20 h-20 bg-orange-500 rounded-3xl flex items-center justify-center mb-6 shadow-lg"
                        bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-white">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2">
                            </rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path>
                            <path d="M16 6h.01"></path>
                            <path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path>
                            <path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path>
                            <path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path>
                            <path d="M8 14h.01"></path>
                        </svg></div>
                    <h3 class="text-2xl font-bold mb-4 text-slate-800">تنظيم المعارض</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">حلول متخصصة للمعارض مع إصدار بادجات ونظام تسجيل
                        متقدم.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>إصدار بادجات احترافية</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>نظام تسجيل مرن</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>إدارة العارضين والرعاة</li>
                        <li class="flex items-center text-slate-700 font-medium"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="h-5 w-5 text-green-500 ml-3 flex-shrink-0">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <path d="m9 11 3 3L22 4"></path>
                            </svg>تقارير الحضور والتفاعل</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section class="py-24 bg-slate-50">
    <div class="mx-[5%]">
        <div class="container mx-auto px-4" bis_skin_checked="1">
            <div class="text-center mb-16" bis_skin_checked="1" style="opacity: 1; transform: none;">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-orange-500">شركاء النجاح</h2>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto">نثق بشركائنا الذين يشاركوننا الرؤية في تقديم
                    أفضل
                    الحلول التقنية لتجارنا وعملائهم.</p>
            </div>
            <div class="relative" bis_skin_checked="1">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8" bis_skin_checked="1">
                    <div class="flex flex-col items-center text-center" bis_skin_checked="1"
                        style="opacity: 1; transform: none;">
                        <div class="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4"
                            bis_skin_checked="1"><img class="w-16 h-16 object-contain" alt="Global Innovators"
                                src="{{ asset('assets/logo/Ticket-Window-02.png') }}"></div>
                        <h3 class="font-bold text-slate-700">Global Innovators</h3>
                        <p class="text-xs text-slate-500">شريك استراتيجي في الابتكار التقني</p>
                    </div>
                    <div class="flex flex-col items-center text-center" bis_skin_checked="1"
                        style="opacity: 1; transform: none;">
                        <div class="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4"
                            bis_skin_checked="1"><img class="w-16 h-16 object-contain" alt="Future Solutions"
                                src="{{ asset('assets/logo/Ticket-Window-02.png') }}"></div>
                        <h3 class="font-bold text-slate-700">Future Solutions</h3>
                        <p class="text-xs text-slate-500">حلول دفع آمنة وموثوقة</p>
                    </div>
                    <div class="flex flex-col items-center text-center" bis_skin_checked="1"
                        style="opacity: 1; transform: none;">
                        <div class="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4"
                            bis_skin_checked="1"><img class="w-16 h-16 object-contain" alt="Creative Minds"
                                src="{{ asset('assets/logo/Ticket-Window-02.png') }}"></div>
                        <h3 class="font-bold text-slate-700">Creative Minds</h3>
                        <p class="text-xs text-slate-500">خبراء في تصميم تجارب المستخدم</p>
                    </div>
                    <div class="flex flex-col items-center text-center" bis_skin_checked="1"
                        style="opacity: 1; transform: none;">
                        <div class="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4"
                            bis_skin_checked="1"><img class="w-16 h-16 object-contain" alt="Tech Pioneers"
                                src="{{ asset('assets/logo/Ticket-Window-02.png') }}"></div>
                        <h3 class="font-bold text-slate-700">Tech Pioneers</h3>
                        <p class="text-xs text-slate-500">رواد في تطوير البنية التحتية</p>
                    </div>
                    <div class="flex flex-col items-center text-center" bis_skin_checked="1"
                        style="opacity: 1; transform: none;">
                        <div class="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4"
                            bis_skin_checked="1"><img class="w-16 h-16 object-contain" alt="NextGen Events"
                                src="{{ asset('assets/logo/Ticket-Window-02.png') }}"></div>
                        <h3 class="font-bold text-slate-700">NextGen Events</h3>
                        <p class="text-xs text-slate-500">شريك في تنظيم الفعاليات الكبرى</p>
                    </div>
                    <div class="flex flex-col items-center text-center" bis_skin_checked="1"
                        style="opacity: 1; transform: none;">
                        <div class="w-24 h-24 rounded-full bg-white shadow-lg border-2 border-primary/20 flex items-center justify-center mb-4"
                            bis_skin_checked="1"><img class="w-16 h-16 object-contain" alt="Venture Capital"
                                src="{{ asset('assets/logo/Ticket-Window-02.png') }}"></div>
                        <h3 class="font-bold text-slate-700">Venture Capital</h3>
                        <p class="text-xs text-slate-500">دعم استثماري لتوسيع الأعمال</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<section class="py-24 bg-orange-500 text-white">
    <div class="container mx-auto px-4 text-center" bis_skin_checked="1">
        <div bis_skin_checked="1" style="opacity: 1; transform: none;">
            <h2 class="text-4xl font-bold mb-6">هل أنت جاهز لبدء رحلتك معنا؟</h2>
            <p class="text-xl mb-10 max-w-2xl mx-auto opacity-90">انضم إلى آلاف التجار الذين يثقون في شباك التذاكر
                لتحويل أفكارهم إلى واقع ناجح.</p>
            <a href="{{ Auth::id()?route('dashboard'):route('register') }}"
                class="inline-flex items-center justify-center ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-11 rounded-md bg-white text-orange-500 hover:bg-gray-100 px-10 py-6 text-lg font-bold shadow-2xl transform hover:scale-105 transition-transform"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="ml-2 h-5 w-5">
                    <path
                        d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z">
                    </path>
                    <path d="M13 5v2"></path>
                    <path d="M13 17v2"></path>
                    <path d="M13 11v2"></path>
                </svg>
                ابدأ الآن مجاناً
            </a>
        </div>
    </div>
</section>
@endsection
