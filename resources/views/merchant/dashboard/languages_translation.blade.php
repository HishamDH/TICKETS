@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  @livewire('under-review')

  <div style="opacity: 1; transform: none;">
    <div class="space-y-8">

      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-3xl font-bold text-slate-800">اللغات والترجمة</h2>
          <p class="text-slate-500 mt-2">قم بإدارة اللغات المتاحة في صفحتك وأضف ترجمات للمحتوى.</p>
        </div>
        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-600 h-10 px-4 py-2 gradient-bg text-white">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
          </svg>
          حفظ التغييرات
        </button>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none tracking-tight">إدارة اللغات</h3>
          <p class="text-sm text-slate-500">اختر اللغات التي تريد دعمها في موقعك.</p>
        </div>
        <div class="p-6 pt-0 space-y-4">
          <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
            <div>
              <span class="font-semibold">العربية</span>
              <span class="text-xs text-orange-500 font-medium mr-2">(اللغة الأساسية)</span>
            </div>
            <button type="button" disabled value="on" class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=unchecked]:bg-input">
              <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
            </button>
          </div>

          <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
            <div><span class="font-semibold">English</span></div>
            <button type="button" value="on" class="peer inline-flex h-[24px] w-[44px] shrink-0 cursor-pointer items-center rounded-full border-2 border-transparent transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 focus-visible:ring-offset-background disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-orange-500 data-[state=unchecked]:bg-input">
              <span class="pointer-events-none block h-5 w-5 rounded-full bg-background shadow-lg ring-0 transition-transform data-[state=checked]:translate-x-5 data-[state=unchecked]:translate-x-0"></span>
            </button>
          </div>

          <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 w-full">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2">
              <circle cx="12" cy="12" r="10"></circle>
              <path d="M8 12h8"></path>
              <path d="M12 8v8"></path>
            </svg>
            إضافة لغة جديدة
          </button>
        </div>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
        <div class="flex flex-col space-y-1.5 p-6">
          <h3 class="text-xl font-semibold leading-none tracking-tight">إدارة الترجمات</h3>
          <p class="text-sm text-slate-500">أدخل الترجمات للمحتوى الخاص بك باللغات التي قمت بتفعيلها.</p>
        </div>
        <div class="p-6 pt-0">
          <!-- التابات + الترجمة لكل عنصر موجودين هون كما أرسلتهم سابقاً -->
          <!-- الإيقونات محفوظة كما هي -->
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
