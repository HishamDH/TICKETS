@extends('layouts.app')
@section('content')
<main class="pt-16">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="bg-gradient-to-b from-gray-50 to-blue-50 py-12 px-4 font-cairo" dir="rtl" bis_skin_checked="1">
            <div class="mx-[5%]">
                <div class="container mx-auto space-y-20" bis_skin_checked="1">
                    <section>
                        <header class="text-center mb-12" style="opacity: 1; transform: none;">
                            <div class="inline-block p-4 bg-orange-500/10 rounded-2xl mb-4" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-16 h-16 text-orange-500">
                                    <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                                    <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                                    <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
                                </svg></div>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-orange-500 mb-4">نظام المحفظة والسحب</h1>
                            <p class="text-lg text-gray-600 max-w-3xl mx-auto">تجربة مالية سلسة وآمنة للتجار مع آلية سحب مرنة تراعي أمان العمليات.</p>
                        </header>
                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8" bis_skin_checked="1">
                            <div class="lg:col-span-3 space-y-8" bis_skin_checked="1">
                                <h2 class="text-3xl font-bold text-gray-800 border-r-4 border-orange-500 pr-4">🧱 آلية عمل النظام</h2>
                                <div class="space-y-6" bis_skin_checked="1">
                                    <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="flex flex-col items-center self-stretch" bis_skin_checked="1">
                                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 ring-4 ring-green-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                    <line x1="12" x2="12" y1="15" y2="3"></line>
                                                </svg></div>
                                            <div class="w-0.5 flex-grow bg-green-200 my-2" bis_skin_checked="1"></div>
                                        </div>
                                        <div class="pt-3 flex-1" bis_skin_checked="1">
                                            <h3 class="font-bold text-lg text-gray-800">1. استقبال الأرباح</h3>
                                            <p class="text-gray-600">كل عملية حجز ناجحة ينتج عنها رصيد معلّق داخل محفظة التاجر. الرصيد يُجمَّع ولكن لا يمكن سحبه فورًا لحماية من الاسترجاع السريع.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="flex flex-col items-center self-stretch" bis_skin_checked="1">
                                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 ring-4 ring-green-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                                    <path d="M5 22h14"></path>
                                                    <path d="M5 2h14"></path>
                                                    <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"></path>
                                                    <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"></path>
                                                </svg></div>
                                            <div class="w-0.5 flex-grow bg-green-200 my-2" bis_skin_checked="1"></div>
                                        </div>
                                        <div class="pt-3 flex-1" bis_skin_checked="1">
                                            <h3 class="font-bold text-lg text-gray-800">2. فترة الحجز المالي (مثلاً 24–48 ساعة)</h3>
                                            <p class="text-gray-600">بعد مرور فترة الأمان، يتحوّل الرصيد إلى رصيد قابل للسحب تلقائيًا.</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="flex flex-col items-center self-stretch" bis_skin_checked="1">
                                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 ring-4 ring-green-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                                    <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                                    <line x1="2" x2="22" y1="10" y2="10"></line>
                                                </svg></div>
                                            <div class="w-0.5 flex-grow bg-green-200 my-2" bis_skin_checked="1"></div>
                                        </div>
                                        <div class="pt-3 flex-1" bis_skin_checked="1">
                                            <h3 class="font-bold text-lg text-gray-800">3. طلب السحب</h3>
                                            <p class="text-gray-600">يدخل التاجر إلى لوحة “المحفظة” ويطلب سحب المبلغ. يظهر له تفاصيل العمولة ووسيلة السحب (حساب بنكي / مدى / STC Pay).</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                        <div class="flex flex-col items-center self-stretch" bis_skin_checked="1">
                                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 ring-4 ring-green-50" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                                    <path d="m22 2-7 20-4-9-9-4Z"></path>
                                                    <path d="M22 2 11 13"></path>
                                                </svg></div>
                                        </div>
                                        <div class="pt-3 flex-1" bis_skin_checked="1">
                                            <h3 class="font-bold text-lg text-gray-800">4. الموافقة والتحويل</h3>
                                            <p class="text-gray-600">الطلب يُرسل إلى الإدارة، تتم مراجعته خلال 24–48 ساعة، ثم يُحوّل المبلغ إلى حساب التاجر ويُحدّث السجل تلقائيًا.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-2 space-y-8" bis_skin_checked="1">
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-orange-500/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" x2="8" y1="13" y2="13"></line>
                                                    <line x1="16" x2="8" y1="17" y2="17"></line>
                                                    <line x1="10" x2="8" y1="9" y2="9"></line>
                                                </svg></div>
                                            <h3 class="tracking-tight text-xl font-bold text-gray-800">🧾 التقارير والمعلومات للتاجر</h3>
                                        </div>
                                        <div class="p-6 pt-0 text-gray-600 space-y-3" bis_skin_checked="1">
                                            <ul class="list-disc list-inside space-y-2">
                                                <li>عدد الحجوزات المربوطة بكل دفعة.</li>
                                                <li>تفاصيل العمولة لكل عملية.</li>
                                                <li>حالة السحب (بانتظار – مكتمل – مرفوض).</li>
                                                <li>أسباب الرفض (في حال وجود مشكلة بنكية أو فنية).</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="rounded-2xl text-slate-900 bg-white/60 backdrop-blur-sm border-2 border-green-500/20 shadow-xl p-6" bis_skin_checked="1">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">🎯 الهدف</h3>
                                    <p class="text-gray-600">توفير تجربة مالية سلسة وآمنة للتجار، مع فصل واضح بين الرصيد المتاح والرصد المعلّق، ودعم آلية سحب مرنة تُراعي أمان العمليات وحماية حقوق العملاء.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="relative flex py-5 items-center" bis_skin_checked="1">
                        <div class="flex-grow border-t border-gray-300" bis_skin_checked="1"></div><span class="flex-shrink mx-4 text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg></span>
                        <div class="flex-grow border-t border-gray-300" bis_skin_checked="1"></div>
                    </div>
                    <section>
                        <header class="text-center mb-12" style="opacity: 1; transform: none;">
                            <div class="inline-block p-4 bg-red-500/10 rounded-2xl mb-4" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-16 h-16 text-red-500">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg></div>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-600 mb-4">نظام الحماية من الاحتيال</h1>
                            <p class="text-lg text-gray-600 max-w-3xl mx-auto">ضمان سلامة العمليات التجارية والمالية ومنع أي تلاعب أو استخدام غير شرعي.</p>
                        </header>
                        <div bis_skin_checked="1">
                            <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">🛡️ آليات الحماية الذكية في المنصة</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12" bis_skin_checked="1">
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-orange-500/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <path d="M12 8V4H8"></path>
                                                    <rect width="16" height="12" x="4" y="8" rx="2"></rect>
                                                    <path d="M2 14h2"></path>
                                                    <path d="M20 14h2"></path>
                                                    <path d="M15 13v2"></path>
                                                    <path d="M9 13v2"></path>
                                                </svg></div>
                                            <h3 class="tracking-tight text-xl font-bold text-gray-800">الرقابة التلقائية</h3>
                                        </div>
                                        <div class="p-6 pt-0 text-gray-600 space-y-3" bis_skin_checked="1">
                                            <p>النظام يراقب سلوك الحجوزات ويكتشف التكرار، اختلافات المواقع، وروابط الإحالة المشبوهة.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-orange-500/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <path d="M5 22h14"></path>
                                                    <path d="M5 2h14"></path>
                                                    <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"></path>
                                                    <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"></path>
                                                </svg></div>
                                            <h3 class="tracking-tight text-xl font-bold text-gray-800">تأخير السحب</h3>
                                        </div>
                                        <div class="p-6 pt-0 text-gray-600 space-y-3" bis_skin_checked="1">
                                            <p>لا يمكن سحب الأموال فورًا، مما يمنع الاحتيال المرتبط بالحجوزات الوهمية أو الاسترجاعات السريعة.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-orange-500/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                </svg></div>
                                            <h3 class="tracking-tight text-xl font-bold text-gray-800">التوثيق الثنائي (2FA)</h3>
                                        </div>
                                        <div class="p-6 pt-0 text-gray-600 space-y-3" bis_skin_checked="1">
                                            <p>مطلوب عند تعديل البريد، تغيير الحساب البنكي، أو طلب سحب كبير ومفاجئ.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-orange-500/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" x2="8" y1="13" y2="13"></line>
                                                    <line x1="16" x2="8" y1="17" y2="17"></line>
                                                    <line x1="10" x2="8" y1="9" y2="9"></line>
                                                </svg></div>
                                            <h3 class="tracking-tight text-xl font-bold text-gray-800">سجل التدقيق (Audit Log)</h3>
                                        </div>
                                        <div class="p-6 pt-0 text-gray-600 space-y-3" bis_skin_checked="1">
                                            <p>يسجل كل شيء: دخول/خروج، تعديل بيانات، إنشاء/إلغاء حجز، طلب سحب، وتغيير الإعدادات.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-orange-500/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg></div>
                                            <h3 class="tracking-tight text-xl font-bold text-gray-800">تنبيهات إدارية فورية</h3>
                                        </div>
                                        <div class="p-6 pt-0 text-gray-600 space-y-3" bis_skin_checked="1">
                                            <p>يتم إرسال تنبيه لفريق الأمان عند أي سلوك غير اعتيادي ويتم تعليق السحب مؤقتًا للمراجعة.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">✅ حماية مزدوجة</h2>
                            <div class="rounded-2xl bg-white text-slate-900 max-w-4xl mx-auto overflow-hidden shadow-lg border-2 border-blue-500/10" bis_skin_checked="1">
                                <div class="relative w-full overflow-auto" bis_skin_checked="1">
                                    <table class="w-full caption-bottom text-sm">
                                        <thead class="[&amp;_tr]:border-b">
                                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted bg-gray-100">
                                                <th class="h-12 text-right align-middle [&amp;:has([role=checkbox])]:pr-0 w-1/2 text-lg font-bold text-gray-700 p-4">النوع</th>
                                                <th class="h-12 text-right align-middle [&amp;:has([role=checkbox])]:pr-0 text-lg font-bold text-gray-700 p-4">الحماية</th>
                                            </tr>
                                        </thead>
                                        <tbody class="[&amp;_tr:last-child]:border-0">
                                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                <td class="align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold text-lg text-red-600 p-4">ضد التاجر</td>
                                                <td class="align-middle [&amp;:has([role=checkbox])]:pr-0 p-4">تجميد تلقائي عند السلوك المشبوه، مراجعة يدوية، سجل تدقيق (Audit Log).</td>
                                            </tr>
                                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted bg-gray-50">
                                                <td class="align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold text-lg text-blue-600 p-4">ضد العميل</td>
                                                <td class="align-middle [&amp;:has([role=checkbox])]:pr-0 p-4">حجز أمواله مؤقتًا، QR فريد لكل تذكرة، منع التكرار.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
