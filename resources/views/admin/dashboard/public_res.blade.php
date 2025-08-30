@extends('admin.layouts.app')


@section('content')




<div style="opacity: 1; transform: none;">
      <div class="space-y-6">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-slate-800">إدارة الحجوزات العامة</h1>
            <p class="text-slate-500 mt-1">عرض شامل لجميع الحجوزات في النظام والتدخل عند الحاجة.</p>
          </div>
          <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="7 10 12 15 17 10"></polyline>
              <line x1="12" x2="12" y1="15" y2="3"></line>
            </svg>
            تصدير تقرير
          </button>
        </div>
  
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
          <div class="flex flex-col space-y-1.5 p-6">
            <div class="flex justify-between items-center">
              <h3 class="text-xl font-semibold leading-none tracking-tight">سجل الحجوزات</h3>
              <div class="flex items-center gap-2">
                <div class="relative w-64">
                  <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                  </svg>
                  <input class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm pl-10" placeholder="بحث برقم الحجز أو العميل...">
                </div>
                <button type="button" class="flex h-10 items-center justify-between rounded-md border px-3 py-2 text-sm w-[180px]">
                  <span>فلترة حسب الحالة</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
  
          <div class="p-6 pt-0">
            <div class="relative w-full overflow-auto">
              <table class="w-full caption-bottom text-sm">
                <thead>
                  <tr class="border-b">
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">رقم الحجز</th>
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">التاجر</th>
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">العميل</th>
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">المبلغ</th>
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">الحالة</th>
                    <th class="h-12 px-4 text-left font-medium text-muted-foreground">إجراء</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b">
                    <td class="p-4 font-medium">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">
                      <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-800">-</div>
                    </td>
                    <td class="p-4 text-left">
                      <button class="inline-flex items-center justify-center text-sm font-medium h-9 rounded-md px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                          <path d="M12 9v4"></path>
                          <path d="M12 17h.01"></path>
                        </svg>
                        مراجعة
                      </button>
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="p-4 font-medium">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">
                      <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-800">-</div>
                    </td>
                    <td class="p-4 text-left">
                      <button class="inline-flex items-center justify-center text-sm font-medium h-9 rounded-md px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                          <path d="M12 9v4"></path>
                          <path d="M12 17h.01"></path>
                        </svg>
                        مراجعة
                      </button>
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="p-4 font-medium">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">-</td>
                    <td class="p-4">
                      <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-800">-</div>
                    </td>
                    <td class="p-4 text-left">
                      <button class="inline-flex items-center justify-center text-sm font-medium h-9 rounded-md px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                          <path d="M12 9v4"></path>
                          <path d="M12 17h.01"></path>
                        </svg>
                        مراجعة
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection  