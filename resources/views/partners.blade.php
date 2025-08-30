@extends('features')
@section('content')
<main class="pt-16">
    <div bis_skin_checked="1" style="opacity: 1; transform: none;">
        <div class="bg-gradient-to-b from-gray-50 to-blue-50 py-12 px-4 font-cairo" dir="rtl" bis_skin_checked="1">
            <div class="mx-[5%]">
                
                <div class="container mx-auto" bis_skin_checked="1">
                    <header class="text-center mb-16" style="opacity: 1; transform: none;">
                        <div class="inline-block p-4 bg-orange-500/10 rounded-2xl mb-4" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-16 h-16 text-orange-500">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg></div>
                        <h1 class="text-4xl md:text-6xl font-extrabold text-orange-500 mb-4">نظام الشركاء والمندوبين</h1>
                        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">في منصة شباك التذاكر</p>
                    </header>
                    <section class="mb-16">
                        <div class="rounded-2xl text-slate-900 max-w-4xl mx-auto bg-white/60 backdrop-blur-sm border-2 border-green-500/20 shadow-xl p-8 text-center" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 text-green-500 mx-auto mb-4">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">🎯 الهدف من النظام</h2>
                            <p class="text-lg text-gray-600">تمكين المنصة من التوسع، وجذب تجار جدد أو عملاء، بدون الحاجة إلى فريق مبيعات داخلي دائم، من خلال ربط كل تاجر أو عميل بمندوب أو شريك، ومنحهم عمولة مقابل النتائج.</p>
                        </div>
                    </section>
                    <section class="mb-16">
                        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">🧩 مكونات النظام</h2>

                        <div dir="ltr" data-orientation="horizontal" class="w-full max-w-6xl mx-auto" bis_skin_checked="1">
                            <div role="tablist" aria-orientation="horizontal" class="h-10 items-center justify-center rounded-md bg-muted p-1 text-gray-600 bg-gray-100 grid w-full grid-cols-1 md:grid-cols-3 gap-2" tabindex="0" data-orientation="horizontal" bis_skin_checked="1" style="outline: none;">
                                <button type="button" role="tab" aria-selected="true" aria-controls="radix-:r3:-content-representative" data-state="active" id="radix-:r3:-trigger-representative" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">المندوب</button>
                                <button type="button" role="tab" aria-selected="false" aria-controls="radix-:r3:-content-affiliate" data-state="inactive" id="radix-:r3:-trigger-affiliate" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">الشريك التسويقي</button>
                                <button type="button" role="tab" aria-selected="false" aria-controls="radix-:r3:-content-accountManager" data-state="inactive" id="radix-:r3:-trigger-accountManager" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">أخصائي الحسابات</button>
                            </div>
                            <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r3:-trigger-representative" id="radix-:r3:-content-representative" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 mt-6" bis_skin_checked="1" style="animation-duration: 0s;">
                                <div class="h-full" bis_skin_checked="1">
                                    <div class="rounded-2xl text-slate-900 h-full bg-white/50 border-2 border-primary/10 shadow-lg transition-all hover:shadow-primary/20" bis_skin_checked="1">
                                        <div class="space-y-1.5 p-6 flex flex-row items-center gap-4" bis_skin_checked="1">
                                            <div class="p-3 bg-orange-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                                                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2"></rect>
                                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                                </svg></div>
                                            <div bis_skin_checked="1">
                                                <h3 class="tracking-tight text-2xl font-bold text-gray-800">المندوب</h3>
                                                <p class="text-sm text-gray-500">شخص يقوم بتسجيل تجار جدد على المنصة.</p>
                                            </div>
                                        </div>
                                        <div class="p-6 pt-0" bis_skin_checked="1">
                                            <div class="relative w-full overflow-auto" bis_skin_checked="1">
                                                <table class="w-full caption-bottom text-sm">
                                                    <thead class="[&amp;_tr]:border-b">
                                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 w-[120px]">الوظيفة</th>
                                                            <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">التفاصيل</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="[&amp;_tr:last-child]:border-0">
                                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold">دوره</td>
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">شخص يقوم بتسجيل تجار جدد على المنصة</td>
                                                        </tr>
                                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold">العمولة</td>
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">يحصل على نسبة ثابتة أو مخصصة من مبيعات التاجر الذي قام بتسجيله</td>
                                                        </tr>
                                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold">آلية الربط</td>
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">كل مندوب لديه رابط إحالة (Referral Link)</td>
                                                        </tr>
                                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold">صلاحياته</td>
                                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">يرى التجار الذين سجّلهم، إيراداتهم، عمولته، سجل السحب</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r3:-trigger-affiliate" hidden="" id="radix-:r3:-content-affiliate" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 mt-6" bis_skin_checked="1"></div>
                            <div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r3:-trigger-accountManager" hidden="" id="radix-:r3:-content-accountManager" tabindex="0" class="ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 mt-6" bis_skin_checked="1"></div>
                        </div>
                    </section>
                    <section class="mb-16">
                        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">🖥️ لوحة تحكم المندوب / الشريك</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" bis_skin_checked="1">
                            <div bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="rounded-2xl text-slate-900 bg-white/50 border-2 border-blue-500/10 shadow-lg" bis_skin_checked="1">
                                    <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                        <div class="p-3 bg-blue-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500">
                                                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                                <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                            </svg></div>
                                        <h3 class="tracking-tight text-xl font-bold text-gray-800">الصفحة الرئيسية</h3>
                                    </div>
                                    <div class="p-6 pt-0 text-gray-600 space-y-2" bis_skin_checked="1">
                                        <ul class="list-disc list-inside space-y-2">
                                            <li>عدد التجار الذين سجلوا عبره</li>
                                            <li>إجمالي الإيرادات الناتجة من التجار</li>
                                            <li>العمولة المكتسبة</li>
                                            <li>حالة كل تاجر (مفعل – موقوف – معلّق)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="rounded-2xl text-slate-900 bg-white/50 border-2 border-blue-500/10 shadow-lg" bis_skin_checked="1">
                                    <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                        <div class="p-3 bg-blue-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500">
                                                <line x1="12" x2="12" y1="2" y2="22"></line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg></div>
                                        <h3 class="tracking-tight text-xl font-bold text-gray-800">صفحة السحب</h3>
                                    </div>
                                    <div class="p-6 pt-0 text-gray-600 space-y-2" bis_skin_checked="1">
                                        <ul class="list-disc list-inside space-y-2">
                                            <li>الرصيد الحالي القابل للسحب</li>
                                            <li>سجل السحوبات السابقة</li>
                                            <li>زر “طلب سحب”</li>
                                            <li>حالة كل طلب (بانتظار – مكتمل – مرفوض)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="rounded-2xl text-slate-900 bg-white/50 border-2 border-blue-500/10 shadow-lg" bis_skin_checked="1">
                                    <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                        <div class="p-3 bg-blue-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500">
                                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                            </svg></div>
                                        <h3 class="tracking-tight text-xl font-bold text-gray-800">الروابط</h3>
                                    </div>
                                    <div class="p-6 pt-0 text-gray-600 space-y-2" bis_skin_checked="1">
                                        <ul class="list-disc list-inside space-y-2">
                                            <li>رابط الإحالة الخاص به</li>
                                            <li>QR قابل للطباعة أو المشاركة</li>
                                            <li>أدوات ترويجية (نصوص، بنرات، قوالب رسائل)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="mb-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-6xl mx-auto" bis_skin_checked="1">
                            <div class="rounded-2xl text-slate-900 bg-white/50 border-2 border-blue-500/10 shadow-lg" bis_skin_checked="1">
                                <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                    <div class="p-3 bg-blue-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500">
                                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                        </svg></div>
                                    <h3 class="tracking-tight text-xl font-bold text-gray-800">🔐 نظام ربط الشركاء بالتجار والعملاء</h3>
                                </div>
                                <div class="p-6 pt-0 text-gray-600 space-y-2" bis_skin_checked="1">
                                    <h3 class="font-bold text-lg text-blue-600">الربط التلقائي:</h3>
                                    <p>أي تاجر يسجّل عبر رابط مندوب يتم ربطه تلقائيًا بذلك المندوب. يمكن أيضًا للإدارة ربط تاجر يدويًا بمندوب محدد.</p>
                                    <h3 class="font-bold text-lg text-blue-600 mt-4">الشفافية:</h3>
                                    <p>لا يستطيع المندوب التعديل على بيانات التاجر. يرى فقط الإحصائيات العامة (عدد الحجوزات، حجم المبيعات، نسبة العمولة) ولا يرى بيانات العملاء أو معلومات مالية حساسة.</p>
                                </div>
                            </div>
                            <div class="rounded-2xl text-slate-900 bg-white/50 border-2 border-blue-500/10 shadow-lg" bis_skin_checked="1">
                                <div class="space-y-1.5 p-6 flex flex-row items-center gap-4 pb-4" bis_skin_checked="1">
                                    <div class="p-3 bg-blue-500/10 rounded-lg" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-blue-500">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg></div>
                                    <h3 class="tracking-tight text-xl font-bold text-gray-800">🛡️ نظام الحماية والمراجعة</h3>
                                </div>
                                <div class="p-6 pt-0 text-gray-600 space-y-2" bis_skin_checked="1">
                                    <ul class="list-disc list-inside space-y-2">
                                        <li>لا يمكن للمندوب تغيير التاجر بعد ربطه.</li>
                                        <li>أي تلاعب بالرابط (مثلاً IP مكرر، تسجيل مزيف) يُراجَع تلقائيًا.</li>
                                        <li>الإدارة تملك حق تعليق المندوب في حال وجود تجاوزات.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section>
                        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">💼 سير العمل الكامل لنظام المندوب</h2>
                        <div class="max-w-2xl mx-auto" bis_skin_checked="1">
                            <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="flex flex-col items-center" bis_skin_checked="1">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl" bis_skin_checked="1">1</div>
                                    <div class="w-0.5 h-16 bg-green-500/30" bis_skin_checked="1"></div>
                                </div>
                                <div class="pt-2" bis_skin_checked="1">
                                    <p class="font-bold text-lg text-gray-800">إنشاء حساب مندوب</p>
                                    <p class="text-gray-600">عبر إدارة المنصة أو تسجيل ذاتي بعد الموافقة</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="flex flex-col items-center" bis_skin_checked="1">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl" bis_skin_checked="1">2</div>
                                    <div class="w-0.5 h-16 bg-green-500/30" bis_skin_checked="1"></div>
                                </div>
                                <div class="pt-2" bis_skin_checked="1">
                                    <p class="font-bold text-lg text-gray-800">استلام رابط الإحالة</p>
                                    <p class="text-gray-600">يظهر تلقائيًا في لوحة التحكم</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="flex flex-col items-center" bis_skin_checked="1">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl" bis_skin_checked="1">3</div>
                                    <div class="w-0.5 h-16 bg-green-500/30" bis_skin_checked="1"></div>
                                </div>
                                <div class="pt-2" bis_skin_checked="1">
                                    <p class="font-bold text-lg text-gray-800">مشاركة الرابط</p>
                                    <p class="text-gray-600">مع تجار أو عملاء عبر أي وسيلة</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="flex flex-col items-center" bis_skin_checked="1">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl" bis_skin_checked="1">4</div>
                                    <div class="w-0.5 h-16 bg-green-500/30" bis_skin_checked="1"></div>
                                </div>
                                <div class="pt-2" bis_skin_checked="1">
                                    <p class="font-bold text-lg text-gray-800">تسجيل تاجر عبر الرابط</p>
                                    <p class="text-gray-600">يُربط تلقائيًا بالمندوب</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="flex flex-col items-center" bis_skin_checked="1">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl" bis_skin_checked="1">5</div>
                                    <div class="w-0.5 h-16 bg-green-500/30" bis_skin_checked="1"></div>
                                </div>
                                <div class="pt-2" bis_skin_checked="1">
                                    <p class="font-bold text-lg text-gray-800">التاجر يبدأ بالحجز والبيع</p>
                                    <p class="text-gray-600">يُحسب للمندوب نسبة من الأرباح</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4 space-x-reverse" bis_skin_checked="1" style="opacity: 1; transform: none;">
                                <div class="flex flex-col items-center" bis_skin_checked="1">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-500 text-white font-bold text-xl" bis_skin_checked="1">6</div>
                                </div>
                                <div class="pt-2" bis_skin_checked="1">
                                    <p class="font-bold text-lg text-gray-800">المندوب يطلب السحب</p>
                                    <p class="text-gray-600">يتم مراجعته وتحويله له عبر النظام</p>
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
