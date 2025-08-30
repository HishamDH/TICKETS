<nav class="flex-1 px-4 space-y-2">

    <a href="{{ route('admin.dashboard.overview') }}"
        wire:click.prevent="intended(`{{ route('admin.dashboard.overview') }}`)"
        class="w-full flex items-center p-3 rounded-lg transition-colors text-right {{ request()->routeIs('admin.dashboard.overview') ? 'bg-orange-500 text-white border-l-4 border-orange-500' : 'hover:bg-slate-700' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-4">
            <rect width="7" height="9" x="3" y="3" rx="1"></rect>
            <rect width="7" height="5" x="14" y="3" rx="1"></rect>
            <rect width="7" height="9" x="14" y="12" rx="1"></rect>
            <rect width="7" height="5" x="3" y="16" rx="1"></rect>
        </svg>
        <span>نظرة عامة</span>
    </a>
@if (adminPermission('staff_approval'))
    <a href="{{ route('admin.dashboard.merchants.index') }}"
        wire:click.prevent="intended(`{{ route('admin.dashboard.merchants.index') }}`)"
        class="w-full flex items-center p-3 rounded-lg transition-colors text-right {{ request()->routeIs('admin.dashboard.merchants.index') ? 'bg-orange-500 text-white border-l-4 border-orange-500' : 'hover:bg-slate-700' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-4">
            <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
            <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
            <path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"></path>
            <path d="M2 7h20"></path>
            <path
                d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7">
            </path>
        </svg>
        <span>إدارة التجار</span>
    </a>
@endif
@if (adminPermission('withdraw_check'))

    <a href="{{ route('admin.dashboard.withdraws.index') }}">

        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 ml-4">
                <path d="m22 2-7 20-4-9-9-4Z"></path>
                <path d="M22 2 11 13"></path>
            </svg>
            <span>إدارة طلبات السحب</span>
        </button>
    </a>
@endif
    <a href="{{ route('admin.dashboard.withdraw.handled') }}">

        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 ml-4">
                <path d="M9 12l2 2 4-4"></path>
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"></path>
                <path d="M14 2v6h6"></path>
            </svg>

            <span>طلبات السحب المنفذة</span>
        </button>
    </a>
@if (adminPermission('merchants_access'))

    <a href="{{ route('admin.dashboard.merchant.access') }}">

        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 ml-4">
                <path d="M2 16V4a2 2 0 0 1 2-2h11"></path>
                <path d="M5 14H4a2 2 0 1 0 0 4h1"></path>
                <path d="M22 18H11a2 2 0 1 0 0 4h11V6H11a2 2 0 0 0-2 2v12"></path>
            </svg>
            <span>الوصول لحسبات التجار</span>
        </button>
    </a>
@endif
    {{-- <a href="{{ route('admin.dashboard.public_reservations') }}"> 

    
    <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-4">
            <path d="M2 16V4a2 2 0 0 1 2-2h11"></path>
            <path d="M5 14H4a2 2 0 1 0 0 4h1"></path>
            <path d="M22 18H11a2 2 0 1 0 0 4h11V6H11a2 2 0 0 0-2 2v12"></path>
        </svg>
        <span>الحجوزات العامة</span>
    </button>

</a> --}}
@if (adminPermission('employees_edit'))

    <a href="{{ route('admin.dashboard.employees') }}">

        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 ml-4">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>إدارة الموظفين</span>
        </button>
    </a>
@endif
@if (adminPermission('tickets'))

    <a href="{{ route('admin.dashboard.support.index') }}">
        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 ml-4">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="m4.93 4.93 4.24 4.24"></path>
                <path d="m14.83 9.17 4.24-4.24"></path>
                <path d="m14.83 14.83 4.24 4.24"></path>
                <path d="m9.17 14.83-4.24 4.24"></path>
                <circle cx="12" cy="12" r="4"></circle>
            </svg>
            <span>الدعم الفني</span>
        </button>
    </a>
@endif
    <a href="{{ route('admin.dashboard.reports') }}">
        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5 ml-4">
                <path d="M3 3v18h18"></path>
                <path d="M18 17V9"></path>
                <path d="M13 17V5"></path>
                <path d="M8 17v-3"></path>
            </svg>
            <span>التحليلات والتقارير</span>
        </button>
    </a>
    @if(LoadConfig()->system->owner == Auth::guard("admin")->user()->id)
    <a href="{{ route('admin.dashboard.setup') }}">
        <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5 ml-4">
                <path
                    d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z">
                </path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            <span>إعدادات النظام</span>
        </button>
    </a>
    @endif
    <!-- <button class="w-full flex items-center p-3 rounded-lg transition-colors text-right hover:bg-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-4">
            <path d="M12 4.5a2.5 2.5 0 0 0-4.96-.46 2.5 2.5 0 0 0-1.98 3 2.5 2.5 0 0 0-1.32 4.24 3 3 0 0 0 .34 5.58 2.5 2.5 0 0 0 2.96 3.08 2.5 2.5 0 0 0 4.91.05L12 20V4.5Z"></path>
            <path d="M16 8V5c0-1.1.9-2 2-2"></path>
            <path d="M12 13h4"></path>
            <path d="M12 18h6a2 2 0 0 1 2 2v1"></path>
            <path d="M12 8h8"></path>
            <path d="M20.5 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
            <path d="M16.5 13a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
            <path d="M20.5 21a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
            <path d="M18.5 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"></path>
        </svg>
        <span>الرقابة الذكية</span>
    </button> -->
</nav>
