@extends('admin.layouts.app')
@section('content')

@livewire("EmployeesManger")

<!-- <main class="flex-1 overflow-y-auto p-6 lg:p-8">
    <div style="opacity: 1; transform: none;">
      <div class="space-y-6">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-slate-800">إدارة موظفي المنصة</h1>
            <p class="text-slate-500 mt-1">إضافة وتعديل صلاحيات فريق العمل.</p>
          </div>
          <button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary hover:bg-primary/90 h-10 px-4 py-2 gradient-bg text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <line x1="19" x2="19" y1="8" y2="14"></line>
              <line x1="22" x2="16" y1="11" y2="11"></line>
            </svg>
            إضافة موظف
          </button>
        </div>
  
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
          <div class="flex flex-col space-y-1.5 p-6">
            <h3 class="text-xl font-semibold leading-none tracking-tight">فريق العمل</h3>
          </div>
          <div class="p-6 pt-0">
            <div class="relative w-full overflow-auto">
              <table class="w-full caption-bottom text-sm">
                <thead>
                  <tr class="border-b">
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">الموظف</th>
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">الدور</th>
                    <th class="h-12 px-4 text-right font-medium text-muted-foreground">آخر نشاط</th>
                    <th class="h-12 px-4 text-left font-medium text-muted-foreground">إجراءات</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b">
                    <td class="p-4">
                      <div class="flex items-center gap-3">
                        <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                          <img class="aspect-square h-full w-full" src="-" alt="-">
                        </span>
                        <div>
                          <div class="font-semibold">-</div>
                          <div class="text-sm text-slate-500">-</div>
                        </div>
                      </div>
                    </td>
                    <td class="p-4">
                      <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-800">-</div>
                    </td>
                    <td class="p-4 text-slate-500">-</td>
                    <td class="p-4 text-left">
                      <button class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="1"></circle>
                          <circle cx="19" cy="12" r="1"></circle>
                          <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                      </button>
                    </td>
                  </tr>
  
                  <tr class="border-b">
                    <td class="p-4">
                      <div class="flex items-center gap-3">
                        <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                          <img class="aspect-square h-full w-full" src="-" alt="-">
                        </span>
                        <div>
                          <div class="font-semibold">-</div>
                          <div class="text-sm text-slate-500">-</div>
                        </div>
                      </div>
                    </td>
                    <td class="p-4">
                      <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-800">-</div>
                    </td>
                    <td class="p-4 text-slate-500">-</td>
                    <td class="p-4 text-left">
                      <button class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="1"></circle>
                          <circle cx="19" cy="12" r="1"></circle>
                          <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                      </button>
                    </td>
                  </tr>
  
                  <tr class="border-b">
                    <td class="p-4">
                      <div class="flex items-center gap-3">
                        <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                          <img class="aspect-square h-full w-full" src="-" alt="-">
                        </span>
                        <div>
                          <div class="font-semibold">-</div>
                          <div class="text-sm text-slate-500">-</div>
                        </div>
                      </div>
                    </td>
                    <td class="p-4">
                      <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-slate-100 text-slate-800">-</div>
                    </td>
                    <td class="p-4 text-slate-500">-</td>
                    <td class="p-4 text-left">
                      <button class="inline-flex items-center justify-center rounded-md text-sm font-medium h-10 w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="1"></circle>
                          <circle cx="19" cy="12" r="1"></circle>
                          <circle cx="5" cy="12" r="1"></circle>
                        </svg>
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
  </main> -->
  

@endsection