@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  <div class="space-y-8">
    <div class="flex justify-between items-center">
      <h2 class="text-3xl font-bold text-slate-800">العروض الترويجية والأكواد</h2>
    </div>
    @livewire('under-review')

    <div dir="rtl">
      <div role="tablist" class="h-10 grid w-full grid-cols-2 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground">
        <button type="button" role="tab" aria-selected="true" class="flex items-center gap-2 justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm">
          <svg class="h-4 w-4" ...></svg>
          إنشاء كود جديد
        </button>
        <button type="button" role="tab" aria-selected="false" class="flex items-center gap-2 justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2">
          <svg class="h-4 w-4" ...></svg>
          قائمة الأكواد
        </button>
      </div>

      <div class="mt-6 pt-6 rounded-2xl border border-slate-200 bg-white shadow-lg text-slate-900">
        <div class="p-6 space-y-1.5">
          <h3 class="text-xl font-semibold leading-none tracking-tight">إنشاء كود خصم جديد</h3>
          <p class="text-sm text-slate-500">قم بإعداد كود خصم جديد لجذب المزيد من العملاء.</p>
        </div>

        <div class="p-6 pt-0 space-y-6">

          <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="promoName">اسم العرض (داخلي)</label>
              <input id="promoName" placeholder="مثال: خصم اليوم الوطني" class="w-full h-10 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="promoCode">كود الخصم</label>
              <div class="flex gap-2">
                <input id="promoCode" placeholder="NATIONAL94" class="w-full h-10 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" />
                <button class="w-10 h-10 flex items-center justify-center rounded-md border border-slate-300 bg-white hover:bg-orange-100 hover:text-orange-700 transition-colors focus-visible:ring-2 focus-visible:ring-orange-500">
                  <svg class="h-4 w-4" ...></svg>
                </button>
              </div>
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">نوع الخصم</label>
              <button type="button" class="flex h-10 w-full items-center justify-between rounded-md border bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                <span>اختر نوع الخصم...</span>
                <svg class="h-4 w-4 opacity-50" ...></svg>
              </button>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="discountValue">قيمة الخصم</label>
              <input id="discountValue" type="number" placeholder="مثال: 15 أو 50" class="w-full h-10 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" />
            </div>
          </div>

          <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2" for="usageLimit">الحد الأقصى للاستخدام</label>
              <input id="usageLimit" type="number" placeholder="مثال: 100" class="w-full h-10 rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all" />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الانتهاء</label>
              <button class="w-full h-10 flex items-center justify-start rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-normal text-right hover:bg-orange-100 hover:text-orange-700 focus-visible:ring-2 focus-visible:ring-orange-500">
                <svg class="ml-2 h-4 w-4" ...></svg>
                <span>اختر تاريخاً</span>
              </button>
            </div>
          </div>

          <div class="space-y-4">
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">تطبيق على</label>
              <button class="flex h-10 w-full items-center justify-between rounded-md border bg-white px-3 py-2 text-sm placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                <span>اختر الخدمات المستهدفة...</span>
                <svg class="h-4 w-4 opacity-50" ...></svg>
              </button>
            </div>
          </div>

          <button class="w-full h-11 rounded-md bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center text-sm font-medium px-8 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2">
            <svg class="w-5 h-5 ml-2" ...></svg>
            إنشاء كود الخصم
          </button>

        </div>
      </div>

    </div>
  </div>
</div>

@endsection
