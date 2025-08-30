@extends('merchant.layouts.app')
@section('content')

<div class="flex-1 p-8">
  <div style="opacity: 1; transform: none;">
    <div class="space-y-8">

      <!-- العنوان -->
      <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-slate-800">نظام الحجز الجماعي</h2>
      </div>
        @livewire('under-review')

      <div dir="rtl" data-orientation="horizontal">
        <!-- التبويبات -->
        <div role="tablist" aria-orientation="horizontal" class="h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground grid w-full grid-cols-2" tabindex="0">

          <!-- تبويب: إنشاء -->
          <button type="button" role="tab" aria-selected="true" aria-controls="radix-:r8u:-content-create" data-state="active" id="radix-:r8u:-trigger-create" class="justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2" tabindex="-1">
            <svg ... class="h-4 w-4">...</svg>
            إنشاء حجز جماعي
          </button>

          <!-- تبويب: سجل -->
          <button type="button" role="tab" aria-selected="false" aria-controls="radix-:r8u:-content-list" data-state="inactive" id="radix-:r8u:-trigger-list" class="justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2" tabindex="-1">
            <svg ... class="h-4 w-4">...</svg>
            سجل الحجوزات الجماعية
          </button>
        </div>

        <!-- التبويب: المحتوى -->
        <div data-state="active" role="tabpanel" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 pt-6">

          <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
            <div class="flex flex-col space-y-1.5 p-6">
              <h3 class="text-xl font-semibold leading-none tracking-tight">إنشاء حجز لشركة أو جهة</h3>
              <p class="text-sm text-slate-500">أدخل تفاصيل الحجز لإصدار فاتورة موحدة.</p>
            </div>

            <div class="p-6 pt-0 space-y-6">
              <!-- كل الفورمات داخل هنا بدون تغيير فقط عدلت ألوان الفوكس والزر -->

              <!-- ... نفس الكود السابق ... -->

              <!-- زر الإرسال -->
              <button class="inline-flex items-center justify-center text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-orange-500 hover:bg-orange-600 h-11 rounded-md px-8 w-full text-white">
                <svg class="w-5 h-5 ml-2">...</svg>
                إنشاء الحجز وإصدار فاتورة موحدة
              </button>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
