@extends('layouts.app')
@section('content')
<main class="pt-16">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="min-h-screen bg-slate-50 py-16" bis_skin_checked="1">
            <div class="mx-[5%]">
                <div class="container mx-auto px-4" bis_skin_checked="1">
                    <div class="text-center mb-12" bis_skin_checked="1" style="opacity: 1; transform: none;">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-orange-500 mb-4">مميزات لكل مستخدم</h1>
                        <p class="text-lg text-slate-600 max-w-3xl mx-auto">نقدم مجموعة أدوات ومميزات مخصصة لكل دور في المنصة، لضمان تجربة سلسة ومتكاملة للجميع.</p>
                    </div>
                    <div dir="rtl" data-orientation="horizontal" class="w-full" bis_skin_checked="1">
                        <div role="tablist" aria-orientation="horizontal" class="items-center justify-center text-muted-foreground grid w-full grid-cols-1 sm:grid-cols-3 gap-2 h-auto p-2 bg-orange-500/10 rounded-xl" tabindex="0" data-orientation="horizontal" bis_skin_checked="1" style="outline: none;"><button type="button" role="tab" aria-selected="true" aria-controls="radix-:r2:-content-client" data-state="active" id="radix-:r2:-trigger-client" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2 text-sm md:text-base py-2.5" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>العميل</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r2:-content-merchant" data-state="inactive" id="radix-:r2:-trigger-merchant" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2 text-sm md:text-base py-2.5" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                    <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
                                    <path d="M2 7h20"></path>
                                    <path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"></path>
                                </svg>التاجر</button><button type="button" role="tab" aria-selected="false" aria-controls="radix-:r2:-content-platform_staff" data-state="inactive" id="radix-:r2:-trigger-platform_staff" class="justify-center whitespace-nowrap rounded-sm px-3 font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2 text-sm md:text-base py-2.5" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg>إدارة المنصة</button></div>
                        <div bis_skin_checked="1" style="opacity: 1;">
                            <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r2:-trigger-client" id="radix-:r2:-content-client" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 mt-10" bis_skin_checked="1" style="animation-duration: 0s;">
                                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" bis_skin_checked="1">
                                    <div class="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="w-16 h-16 bg-sky-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                                <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                                                <path d="M13 5v2"></path>
                                                <path d="M13 17v2"></path>
                                                <path d="M13 11v2"></path>
                                            </svg></div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">مرونة الحجز</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">احجز كزائر أو بحساب، اختر مقعدك من مخطط تفاعلي، أو حدد طاولتك ووقتها في المطاعم بكل سهولة.</p>
                                    </div>
                                    <div class="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                                <line x1="2" x2="22" y1="10" y2="10"></line>
                                            </svg></div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">دفع إلكتروني آمن</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">ندعم كافة طرق الدفع: بطاقات ائتمan، Apple Pay، والتحويل البنكي، لتجربة دفع سلسة وموثوقة.</p>
                                    </div>
                                    <div class="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="w-16 h-16 bg-indigo-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                                <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                                <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                                <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                                <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                                <path d="M21 21v.01"></path>
                                                <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                                <path d="M3 12h.01"></path>
                                                <path d="M12 3h.01"></path>
                                                <path d="M12 16v.01"></path>
                                                <path d="M16 12h1"></path>
                                                <path d="M21 12v.01"></path>
                                                <path d="M12 21v-1"></path>
                                            </svg></div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">استلام فوري للتذاكر</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">استلم تذاكرك فوراً بعد الدفع عبر الإيميل، مع دعم إضافتها إلى محافظ Apple و Google.</p>
                                    </div>
                                    <div class="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="w-16 h-16 bg-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg></div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">إدارة الحجوزات</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">ألغِ أو عدّل حجزك (حسب سياسة التاجر)، واطلع على سجل حجوزاتك السابقة في أي وقت.</p>
                                    </div>
                                    <div class="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                                <path d="m5 8 6 6"></path>
                                                <path d="m4 14 6-6 2-3"></path>
                                                <path d="M2 5h12"></path>
                                                <path d="M7 2h1"></path>
                                                <path d="m22 22-5-10-5 10"></path>
                                                <path d="M14 18h6"></path>
                                            </svg></div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">واجهة ثنائية اللغة</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">استخدم المنصة باللغة العربية أو الإنجليزية لتجربة مريحة ومخصصة لك.</p>
                                    </div>
                                    <div class="bg-white p-6 rounded-2xl shadow-lg card-hover h-full text-center" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="w-16 h-16 bg-rose-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-md" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg></div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-2">برنامج النقاط والمكافآت</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">اجمع نقاطاً مع كل حجز واستبدلها بمكافآت وخصومات حصرية من التجار المشاركين.</p>
                                    </div>
                                </div>
                            </div>
                            <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r2:-trigger-merchant" hidden="" id="radix-:r2:-content-merchant" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 mt-10" bis_skin_checked="1"></div>
                            <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r2:-trigger-platform_staff" hidden="" id="radix-:r2:-content-platform_staff" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 mt-10" bis_skin_checked="1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
