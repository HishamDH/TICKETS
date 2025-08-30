@extends('merchant.layouts.app',["merchant" => $merchantid ?? false])
@section('content')

<div class="flex-1 p-8">
    @php
        if($merchantid){
            $hasBranchCreatePermession = has_Permetion(Auth::id(),'branches_create', $merchantid);
            $hasBranchEditPermession = has_Permetion(Auth::id(),'branches_edit', $merchantid);
            $hasBranchDeletePermession = has_Permetion(Auth::id(),'branches_delete', $merchantid);
        } else {
            $hasBranchCreatePermession = true;
            $hasBranchEditPermession = true;
            $hasBranchDeletePermession = true;
        }

    @endphp
    <div style="opacity: 1; transform: none;">
        <div class="space-y-8">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-slate-800">إدارة الفروع</h2>
            </div>
            <div dir="rtl" data-orientation="horizontal">
                <div role="tablist" aria-orientation="horizontal" class="h-10 items-center justify-center rounded-md bg-orange-500/10 p-1 text-orange-500/10-foreground grid w-full grid-cols-2 gap-3" tabindex="0" data-orientation="horizontal" style="outline: none;">
                    <button type="button" role="tab" aria-selected="true" aria-controls="radix-:r9r:-content-list" data-state="active" id="tab-list" class="justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                            <line x1="8" x2="21" y1="6" y2="6"></line>
                            <line x1="8" x2="21" y1="12" y2="12"></line>
                            <line x1="8" x2="21" y1="18" y2="18"></line>
                            <line x1="3" x2="3.01" y1="6" y2="6"></line>
                            <line x1="3" x2="3.01" y1="12" y2="12"></line>
                            <line x1="3" x2="3.01" y1="18" y2="18"></line>
                        </svg> قائمة الفروع</button>
                    <button type="button" role="tab" aria-selected="false" aria-controls="radix-:r9r:-content-create" data-state="inactive" id="tab-create" class="justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm flex items-center gap-2" tabindex="-1" data-orientation="horizontal" data-radix-collection-item=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 12h8"></path>
                            <path d="M12 8v8"></path>
                        </svg> إضافة فرع جديد</button>
                </div>
                <div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:r9r:-trigger-list" id="radix-:r9r:-content-list" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 pt-6" style="animation-duration: 0s;">
                    <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="text-xl font-semibold leading-none tracking-tight">قائمة الفروع</h3>
                            <p class="text-sm text-slate-500">عرض وإدارة جميع فروعك من مكان واحد.</p>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&amp;_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-orange-500/10/50 data-[state=selected]:bg-orange-500/10">
                                            <th class="h-12 px-4 text-right align-middle font-medium text-orange-500/10-foreground [&amp;:has([role=checkbox])]:pr-0">اسم الفرع</th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-orange-500/10-foreground [&amp;:has([role=checkbox])]:pr-0">الموقع</th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-orange-500/10-foreground [&amp;:has([role=checkbox])]:pr-0">الحالة</th>
                                            <th class="h-12 px-4 text-right align-middle font-medium text-orange-500/10-foreground [&amp;:has([role=checkbox])]:pr-0">إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody class="[&amp;_tr:last-child]:border-0">
                                        @foreach ($branches as $branch)
                                        <tr class="border-b transition-colors hover:bg-orange-500/10/50 data-[state=selected]:bg-orange-500/10">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-semibold">{{ $branch->name }}</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">{{ $branch->location }}</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0"><span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">نشط</span></td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 space-x-1 space-x-reverse">
{{-- زر التعديل --}}
@if($hasBranchEditPermession)
    <button 
        data-id="{{ $branch->id }}" 
        data-name="{{ $branch->name }}" 
        data-location="{{ $branch->location }}" 
        class="edit-Btn inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-slate-500">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
        </svg>
    </button>
@else
    <span class="text-xs text-gray-400">لا تملك صلاحية التعديل</span>
@endif

{{-- زر الحذف --}}
@if($hasBranchDeletePermession)
    <button 
        data-id="{{ $branch->id }}" 
        class="delete-btn inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-red-500">
            <path d="M3 6h18"></path>
            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
            <line x1="10" x2="10" y1="11" y2="17"></line>
            <line x1="14" x2="14" y1="11" y2="17"></line>
        </svg>
    </button>
@else
    <span class="text-xs text-gray-400">لا تملك صلاحية الحذف</span>
@endif

                                            </td>
                                        </tr>
                                        @endforeach

   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    
                
                <div data-state="inactive" style="display: none;" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:rg:-trigger-create" id="radix-:rg:-content-create" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 pt-6" bis_skin_checked="1">
                    
                    @if ($hasBranchCreatePermession)
                        <form method="POST" action="{{ isset($merchantid) ?  route('merchant.dashboard.m.branch.store',["merchant" => $merchantid]) : route('merchant.dashboard.branch.store') }}">
                            @csrf
                            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                                <div class="flex flex-col space-y-1.5 p-6">
                                    <h3 class="text-xl font-semibold leading-none tracking-tight">إضافة فرع جديد</h3>
                                    <p class="text-sm text-slate-500">أدخل بيانات الفرع الجديد لتبدأ بإدارته.</p>
                                </div>
                                <div class="p-6 pt-0 space-y-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="branchName">اسم الفرع</label>
                                        <div class="relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <line x1="6" x2="6" y1="3" y2="15"></line>
                                                <circle cx="18" cy="6" r="3"></circle>
                                                <circle cx="6" cy="18" r="3"></circle>
                                                <path d="M18 9a9 9 0 0 1-9 9"></path>
                                            </svg>
                                            <input type="text" name="name" id="branchName" required placeholder="مثال: مطعم فرع العليا"
                                                class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 pr-10 text-sm placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2" for="branchLocation">موقع الفرع</label>
                                        <div class="relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                            <input type="text" name="location" id="branchLocation" required placeholder="مثال: الرياض، شارع التحلية"
                                                class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 pr-10 text-sm placeholder:text-slate-500 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                                        </div>
                                    </div>

                                    <button type="submit"
                                        class="inline-flex items-center justify-center text-sm font-medium bg-orange-500 hover:bg-orange-500/90 h-11 rounded-md px-8 w-full text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="M8 12h8"></path>
                                            <path d="M12 8v8"></path>
                                        </svg>
                                        إضافة الفرع
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                    <p class="text-sm text-slate-500">لاتملك صلاحية لانشاء فرع جديد</p>
                    @endif
                </div>
                <div id="tab-content-edit" class="mt-2 pt-6 hidden">
                        <form method="POST" id="edit-branch-form">
                            @if ($hasBranchEditPermession)

                            @csrf
                            @method('PUT')
                            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                                <div class="flex flex-col space-y-1.5 p-6">
                                    <h3 class="text-xl font-semibold leading-none tracking-tight">تعديل الفرع</h3>
                                    <p class="text-sm text-slate-500">قم بتعديل بيانات الفرع الحالي.</p>
                                </div>
                                <div class="p-6 pt-0 space-y-6">
                                    <input type="hidden" name="id" id="edit-branch-id">

                                    <div class="space-y-2">
                                        <label for="edit-branch-name" class="block text-sm font-medium text-gray-700 mb-2">اسم الفرع</label>
                                        <input type="text" name="name" id="edit-branch-name" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm" required>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="edit-branch-location" class="block text-sm font-medium text-gray-700 mb-2">موقع الفرع</label>
                                        <input type="text" name="location" id="edit-branch-location" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm" required>
                                    </div>

                                    <button type="submit" class="inline-flex items-center justify-center text-sm font-medium bg-orange-500 hover:bg-orange-500/90 h-11 rounded-md px-8 w-full text-white">
                                        حفظ التعديلات
                                    </button>
                                </div>
                            </div>
                            @else
                            <p class="text-sm text-slate-500">لاتملك صلاحية لتعديل فرع </p>
    
                        @endif
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal حذف -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    
    @if ($hasBranchDeletePermession)
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md text-center">
        <h2 class="text-xl font-semibold mb-4">هل أنت متأكد من حذف الفرع؟</h2>
        <p class="text-gray-600 mb-6">هذا الإجراء لا يمكن التراجع عنه.</p>
        <form id="deleteBranchForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center gap-4">
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">نعم، حذف</button>
                <button type="button" id="cancelDelete" class="bg-orange-500/10 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400">إلغاء</button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md text-center">
        <h2 class="text-xl font-semibold mb-4">ليس لديك صلاحية لحذف الفرع</h2>
        <p class="text-gray-600 mb-6">يرجى التواصل مع المسؤول.</p>
        <button type="button" id="cancelDelete" class="bg-orange-500/10 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400">إغلاق</button>
    @endif

</div>
@endsection
<script>
    document.addEventListener("livewire:navigated", function() {
        const listTab = document.getElementById("tab-list");
        const createTab = document.getElementById("tab-create");
        const edit_Btn = document.getElementById("edit");
        // listTab.setAttribute("data-state", "inactive");
        // setTimeout(() => {
        //     listTab.click();
        // }, 200);

        const listContent = document.getElementById("radix-:r9r:-content-list");
        const formContent = document.getElementById("radix-:rg:-content-create");
        const editContent = document.getElementById("tab-content-edit");

        function activateTab(activeBtn, inactiveBtn, activeContent, inactiveContent) {
            // Toggle display
            activeContent.style.display = "block";
            inactiveContent.style.display = "none";

            // Toggle data-state
            activeContent.setAttribute("data-state", "active");
            inactiveContent.setAttribute("data-state", "inactive");

            // Toggle aria-selected
            activeBtn.setAttribute("aria-selected", "true");
            inactiveBtn.setAttribute("aria-selected", "false");
            activeBtn.setAttribute("data-state", "active");
            inactiveBtn.setAttribute("data-state", "inactive");

            // Toggle background classes manually
            activeBtn.classList.add("bg-white", "text-slate-900", "shadow-sm");
            inactiveBtn.classList.remove("bg-white", "text-slate-900", "shadow-sm");
        }

        listTab.addEventListener("click", function() {
            activateTab(listTab, createTab, listContent, formContent);
            activateTab(listTab, createTab, listContent, editContent);
        });

        createTab.addEventListener("click", function() {
            activateTab(createTab, listTab, formContent, listContent);
            activateTab(createTab, listTab, formContent, editContent);
        });
        document.addEventListener("click", function(e) {
            if (e.target.closest(".edit-Btn")) {
                const btn = e.target.closest(".edit-Btn");
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const location = btn.dataset.location;

                document.getElementById("edit-branch-id").value = id;
                document.getElementById("edit-branch-name").value = name;
                document.getElementById("edit-branch-location").value = location;

                const form = document.getElementById("edit-branch-form");
                const merchantId = "{{ $merchantid ?? '' }}"; 

                if (merchantId) {
                
                    form.action = `/merchant/dashboard/m/${merchantId}/branch/${id}`;
                } else {
                    
                    form.action = `/merchant/dashboard/branch/${id}`;
                }
    
                activateTab(listTab, createTab, editContent, formContent);
                activateTab(listTab, listTab, editContent, listContent);
            }
            if (e.target.closest(".delete-btn")) {
                const btn = e.target.closest(".delete-btn");
                const id = btn.dataset.id;
                const form = document.getElementById("deleteBranchForm");
                const merchantIdD = "{{ $merchantid ?? '' }}"; 

                if (merchantIdD) {

                    form.action = `/merchant/dashboard/m/${merchantIdD}/branch/${id}`;
                } else {
                    
                    form.action = `/merchant/dashboard/branch/${id}`;
                }
                //form.action = `/merchant/dashboard/branch/${id}`;
                document.getElementById("deleteModal").classList.remove("hidden");
                document.getElementById("deleteModal").classList.add("flex");
            }
        });
        document.getElementById("cancelDelete").addEventListener("click", function () {
            document.getElementById("deleteModal").classList.add("hidden");
            document.getElementById("deleteModal").classList.remove("flex");
        });
    });
</script>
