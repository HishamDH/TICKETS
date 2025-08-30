@extends('merchant.layouts.app')
@section('content')
    <div class="flex-1 p-8">

        @livewire('under-review')

        <div style="opacity: 1; transform: none;">
            <div class="space-y-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-3xl font-bold text-slate-800">إدارة الإشعارات</h2>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <h3 class="text-xl font-semibold leading-none tracking-tight">إعدادات الإشعارات</h3>
                        <p class="text-sm text-slate-500">تحكم في الإشعارات التي تصلك أنت وعملاؤك وموظفوك.</p>
                    </div>
                    <div class="p-6 pt-0">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-4">إشعارات العملاء</h3>
                            <div class="border rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">تأكيد الحجز</p>
                                        <p class="text-sm text-slate-500">إشعار يرسل للعميل عند تأكيد حجزه بنجاح.</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-customer-confirm"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-customer-confirm"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-customer-confirm"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-customer-confirm"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-customer-confirm"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-customer-confirm"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">تذكير بالموعد</p>
                                        <p class="text-sm text-slate-500">تذكير يرسل للعميل قبل موعد الحجز بـ 24 ساعة.</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-customer-reminder"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-customer-reminder"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2">
                                                    </rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked"
                                                value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-customer-reminder"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-customer-reminder"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-customer-reminder"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-customer-reminder"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">إلغاء الحجز</p>
                                        <p class="text-sm text-slate-500">إشعار يرسل للعميل عند إلغاء الحجز.</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-customer-cancel"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-customer-cancel"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2">
                                                    </rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked"
                                                value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-customer-cancel"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-customer-cancel"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-customer-cancel"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-customer-cancel"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-orientation="horizontal" role="none" class="shrink-0 bg-border h-[1px] w-full my-8">
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-4">إشعارات التاجر</h3>
                            <div class="border rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">حجز جديد</p>
                                        <p class="text-sm text-slate-500">تنبيه فوري عند استلام حجز جديد.</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-merchant-new-booking"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-merchant-new-booking"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2">
                                                    </rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked"
                                                value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-merchant-new-booking"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-merchant-new-booking"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-merchant-new-booking"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-merchant-new-booking"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">طلب سحب</p>
                                        <p class="text-sm text-slate-500">تنبيه عند إنشاء طلب سحب جديد من المحفظة.</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-merchant-payout"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-merchant-payout"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2">
                                                    </rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked"
                                                value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-merchant-payout"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-merchant-payout"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-merchant-payout"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-merchant-payout"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">تقييم جديد</p>
                                        <p class="text-sm text-slate-500">إشعار عند إضافة تقييم جديد من عميل.</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-merchant-review"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-merchant-review"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2">
                                                    </rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked"
                                                value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-merchant-review"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-merchant-review"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-merchant-review"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-merchant-review"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-orientation="horizontal" role="none" class="shrink-0 bg-border h-[1px] w-full my-8">
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 mb-4">إشعارات الموظفين</h3>
                            <div class="border rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                                    <div class="space-y-1">
                                        <p class="font-semibold text-slate-800">تغيير في الفعالية</p>
                                        <p class="text-sm text-slate-500">إشعار لموظفي التحقق عند تغيير تفاصيل الفعالية.
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="email-staff-event-change"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="email-staff-event-change"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <rect width="20" height="16" x="2" y="4" rx="2">
                                                    </rect>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                </svg><span class="text-xs">بريد</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="false" data-state="unchecked"
                                                value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="sms-staff-event-change"><span data-state="unchecked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="sms-staff-event-change"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg><span class="text-xs">SMS</span></label></div>
                                        <div class="flex items-center space-x-2 space-x-reverse"><button type="button"
                                                role="switch" aria-checked="true" data-state="checked" value="on"
                                                class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=unchecked]:bg-input"
                                                id="push-staff-event-change"><span data-state="checked"
                                                    class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span></button><label
                                                class="text-sm font-medium text-gray-700 mb-2 flex flex-col items-center"
                                                for="push-staff-event-change"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="h-5 w-5 text-slate-600">
                                                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                                                </svg><span class="text-xs">تنبيه</span></label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end"><button
                                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary hover:bg-primary/90 h-10 px-4 py-2 gradient-bg text-white"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4 ml-2">
                                    <path
                                        d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z">
                                    </path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>حفظ التغييرات</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
