<div>

    @if (($merchant && has_Permetion(Auth::id(), 'overview_page', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.overview', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.overview', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.overview') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.overview') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.overview') || Route::is('merchant.dashboard.m.overview')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                <rect width="7" height="5" x="3" y="16" rx="1"></rect>
            </svg>
            <span>نظرة عامة</span>
        </a>
    @endif


    @if (is_work(Auth::id()) && !$merchant)
        <a href="{{ route('merchant.dashboard.work_center.index') }}"
            wire:click.prevent="intended('{{ route('merchant.dashboard.work_center.index') }}')"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all 
                @if (Route::is('merchant.dashboard.work_center.index')) bg-orange-500 text-white shadow-md 
                @else text-slate-600 hover:bg-slate-100 @endif">
            <svg fill="#000000" height="24px" width="24px" version="1.1" id="Layer_1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                xml:space="preserve">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <g>
                            <g>
                                <path
                                    d="M512,194.313v-37.012c0-2.554-1.035-4.866-2.708-6.54c-0.001-0.001-0.001-0.002-0.002-0.004l-74.024-74.024 c-1.735-1.735-4.089-2.709-6.542-2.709H181.976c-5.11,0-9.253,4.142-9.253,9.253c0,5.111,4.143,9.253,9.253,9.253h242.915 l55.518,55.518H31.591L87.109,92.53h57.855c5.11,0,9.253-4.142,9.253-9.253c0-5.111-4.143-9.253-9.253-9.253H83.277 c-2.454,0-4.808,0.975-6.542,2.709L2.711,150.757c-0.001,0-0.001,0.001-0.001,0.003C1.035,152.434,0,154.746,0,157.301v37.012 c0,14.796,4.559,28.544,12.337,39.925v194.485c0,5.111,4.143,9.253,9.253,9.253H490.41c5.11,0,9.253-4.142,9.253-9.253V280.675 c0-5.111-4.143-9.253-9.253-9.253c-5.11,0-9.253,4.142-9.253,9.253V419.47H191.229V293.012c0-5.111-4.143-9.253-9.253-9.253 H70.94c-5.11,0-9.253,4.142-9.253,9.253V419.47H30.843V252.794c11.414,7.852,25.225,12.459,40.096,12.459 c26.396,0,49.47-14.49,61.687-35.935c12.216,21.445,35.291,35.935,61.687,35.935c26.396,0,49.47-14.49,61.687-35.935 c12.216,21.445,35.291,35.935,61.687,35.935s49.47-14.49,61.687-35.935c12.216,21.445,35.291,35.935,61.687,35.935 C480.177,265.253,512,233.43,512,194.313z M80.193,302.265h92.53V419.47h-92.53V302.265z M441.06,246.747 c-28.913,0-52.434-23.521-52.434-52.434c0-5.111-4.143-9.253-9.253-9.253c-5.11,0-9.253,4.142-9.253,9.253 c0,28.913-23.521,52.434-52.434,52.434c-28.913,0-52.434-23.521-52.434-52.434c0-5.111-4.143-9.253-9.253-9.253 s-9.253,4.142-9.253,9.253c0,28.913-23.521,52.434-52.434,52.434c-28.913,0-52.434-23.521-52.434-52.434 c0-5.111-4.143-9.253-9.253-9.253c-5.11,0-9.253,4.142-9.253,9.253c0,28.913-23.521,52.434-52.434,52.434 s-52.434-23.521-52.434-52.434v-27.759h474.988v27.759C493.494,223.226,469.973,246.747,441.06,246.747z">
                                </path>
                                <path
                                    d="M144.964,345.446c-5.11,0-9.253,4.142-9.253,9.253v12.337c0,5.111,4.143,9.253,9.253,9.253s9.253-4.142,9.253-9.253 v-12.337C154.217,349.587,150.074,345.446,144.964,345.446z">
                                </path>
                                <path
                                    d="M268.337,370.12c-5.11,0-9.253,4.142-9.253,9.253c0,5.111,4.143,9.253,9.253,9.253H441.06 c5.11,0,9.253-4.142,9.253-9.253v-86.361c0-5.111-4.143-9.253-9.253-9.253H231.325c-5.11,0-9.253,4.142-9.253,9.253v86.361 c0,5.111,4.143,9.253,9.253,9.253c5.11,0,9.253-4.142,9.253-9.253v-77.108h191.229v67.855H268.337z">
                                </path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            <span>مركز العمل</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'offers_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.offer.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.offer.index', ['merchant' => $merchant]) }}`)"

        @else
        href="{{ route('merchant.dashboard.offer.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.offer.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all 
                @if (Route::is('merchant.dashboard.offer.index') || Route::is('merchant.dashboard.m.offer.index')) bg-orange-500 text-white shadow-md 
                @else 
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path
                    d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z">
                </path>
                <path d="M13 5v2"></path>
                <path d="M13 17v2"></path>
                <path d="M13 11v2"></path>
            </svg>
            <span>إدارة الخدمات</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'reservations_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.reservations.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.reservations.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.reservations.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.reservations.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.reservations.index') || Route::is('merchant.dashboard.m.reservations.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                <path d="M12 11h4"></path>
                <path d="M12 16h4"></path>
                <path d="M8 11h.01"></path>
                <path d="M8 16h.01"></path>
            </svg>
            <span>إدارة الحجوزات</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'check_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.checking', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.checking', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.checking') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.checking') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.checking') || Route::is('merchant.dashboard.m.checking')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                <path d="M21 21v.01"></path>
                <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                <path d="M3 12h.01"></path>
                <path d="M12 3h.01"></path>
                <path d="M12 16v.01"></path>
                <path d="M16 12h1"></path>
                <path d="M21 12v.01"></path>
                <path d="M12 21v-1"></path>
            </svg>
            <span>التحقق</span>
        </a>
    @endif


    @if (($merchant && has_Permetion(Auth::id(), 'pos_page', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.pos.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.pos.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.pos.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.pos.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.pos.index') || Route::is('merchant.dashboard.m.pos.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect width="12" height="8" x="6" y="14"></rect>
            </svg>
            <span>البيع الداخلي (POS)</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'ratings_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.customer_reviews', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.customer_reviews', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.customer_reviews') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.customer_reviews') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.customer_reviews') || Route::is('merchant.dashboard.m.customer_reviews')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <polygon
                    points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                </polygon>
            </svg>
            <span>مراجعات العملاء</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'reports_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.statistics.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.statistics.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.statistics.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.statistics.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.statistics.index') || Route::is('merchant.dashboard.m.statistics.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <path d="M3 3v18h18"></path>
                <path d="M18 17V9"></path>
                <path d="M13 17V5"></path>
                <path d="M8 17v-3"></path>
            </svg>
            <span>التقارير والتحليلات</span>
        </a>
    @endif
    {{-- <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.intelligence_analytics',['merchant'=>$merchant]) }}" @else href="{{ route('merchant.dashboard.intelligence_analytics') }}" @endif wire:click.prevent="intended('{{ route('merchant.dashboard.intelligence_analytics') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if (Route::is('merchant.dashboard.intelligence_analytics')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
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
    <span>الذكاء والتحليلات</span>
    </a> --}}

    {{-- <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.notification_management',['merchant'=>$merchant]) }}" @else href="{{ route('merchant.dashboard.notification_management') }}" @endif wire:click.prevent="intended('{{ route('merchant.dashboard.notification_management') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if (Route::is('merchant.dashboard.notification_management')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
    </svg>
    <span>إدارة الإشعارات</span>
    </a> --}}


    @if (($merchant && has_Permetion(Auth::id(), 'messages_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.message_center', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.message_center', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.message_center') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.message_center') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.message_center') || Route::is('merchant.dashboard.m.message_center')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span>مركز الرسائل</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'wallet_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.withdraws.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.withdraws.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.withdraws.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.withdraws.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.withdraws.index') || Route::is('merchant.dashboard.m.withdraws.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"></path>
                <path d="M3 5v14a2 2 0 0 0 2 2h16v-5"></path>
                <path d="M18 12a2 2 0 0 0 0 4h4v-4Z"></path>
            </svg>
            <span>المحفظة والسحب</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'branches_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.branch.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.branch.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.branch.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.branch.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.branch.index') || Route::is('merchant.dashboard.m.branch.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <line x1="6" x2="6" y1="3" y2="15"></line>
                <circle cx="18" cy="6" r="3"></circle>
                <circle cx="6" cy="18" r="3"></circle>
                <path d="M18 9a9 9 0 0 1-9 9"></path>
            </svg>
            <span>إدارة الفروع</span>
        </a>
    @endif


    @if (($merchant && has_Permetion(Auth::id(), 'team_manager_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.team_management', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.team_management', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.team_management') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.team_management') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.team_management') || Route::is('merchant.dashboard.m.team_management')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>إدارة الفريق</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'settings_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.page_setup', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.page_setup', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.page_setup') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.page_setup') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.page_setup') || Route::is('merchant.dashboard.m.page_setup')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <circle cx="13.5" cy="6.5" r=".5"></circle>
                <circle cx="17.5" cy="10.5" r=".5"></circle>
                <circle cx="8.5" cy="7.5" r=".5"></circle>
                <circle cx="6.5" cy="12.5" r=".5"></circle>
                <path
                    d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z">
                </path>
            </svg>
            <span>إعداد الصفحة</span>
        </a>
    @endif

    @if (!$merchant ?? false)
        <a href="{{ route('merchant.dashboard.profile_setup') }}"
            wire:click.prevent="intended(`{{ route('merchant.dashboard.profile_setup') }}`)"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.profile_setup')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 12c2.761 0 5-2.239 5-5S14.761 2 12 2 7 4.239 7 7s2.239 5 5 5zm0 2c-3.866 0-7 2.015-7 4.5V20h14v-1.5c0-2.485-3.134-4.5-7-4.5z" />
            </svg>



            <span>إعداد الحساب</span>
        </a>
    @endif

    @if (($merchant && has_Permetion(Auth::id(), 'policies_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.policies_settings.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.policies_settings.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.policies_settings.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.policies_settings.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.m.policies_settings.index') ||
                        Route::is('merchant.dashboard.policies_settings.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <circle cx="6" cy="13" r="3"></circle>
                <path d="m9.7 14.4-.9-.3"></path>
                <path d="m3.2 11.9-.9-.3"></path>
                <path d="m4.6 16.7.3-.9"></path>
                <path d="m7.6 16.7-.4-1"></path>
                <path d="m4.8 10.3-.4-1"></path>
                <path d="m2.3 14.6 1-.4"></path>
                <path d="m8.7 11.8 1-.4"></path>
                <path d="m7.4 9.3-.3.9"></path>
                <path d="M14 2v6h6"></path>
                <path d="M4 5.5V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-1.5"></path>
            </svg>



            <span>السياسات والإعدادات</span>
        </a>
    @endif

    {{--

            <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.policies_settings',['merchant'=>$merchant]) }}" @else href="{{ route('merchant.dashboard.policies_settings.index') }}" @endif wire:click.prevent="intended('{{ route('merchant.dashboard.policies_settings.index') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if (Route::is('merchant.dashboard.policies_settings.index')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif">

    </a> --}}

    @if (($merchant && has_Permetion(Auth::id(), 'support_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.support.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.support.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.support.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.support.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.support.index') || Route::is('merchant.dashboard.m.support.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="m4.93 4.93 4.24 4.24"></path>
                <path d="m14.83 9.17 4.24-4.24"></path>
                <path d="m14.83 14.83 4.24 4.24"></path>
                <path d="m9.17 14.83-4.24 4.24"></path>
                <circle cx="12" cy="12" r="4"></circle>
            </svg>
            <span>الدعم الفني</span>
        </a>
    @endif
    {{-- <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.languages_translation',['merchant'=>$merchant]) }}" @else href="{{ route('merchant.dashboard.languages_translation') }}" @endif wire:click.prevent="intended('{{ route('merchant.dashboard.languages_translation') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if (Route::is('merchant.dashboard.languages_translation')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
        <path d="M2 12h20"></path>
    </svg>
    <span>اللغات والترجمة</span>
    </a> --}}

    {{-- <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.api',['merchant'=>$merchant]) }}" @else href="{{ route('merchant.dashboard.api') }}" @endif wire:click.prevent="intended('{{ route('merchant.dashboard.api') }}')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all @if (Route::is('merchant.dashboard.api')) bg-orange-500 text-white shadow-md @else text-slate-600 hover:bg-slate-100 @endif">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
        <polyline points="16 18 22 12 16 6"></polyline>
        <polyline points="8 6 2 12 8 18"></polyline>
    </svg>
    <span>API والتكاملات</span>
    </a> --}}
    @if (($merchant && has_Permetion(Auth::id(), 'history_view', $merchant)) || !$merchant)
        <a @if ($merchant ?? false) href="{{ route('merchant.dashboard.m.activity_log.index', ['merchant' => $merchant]) }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.m.activity_log.index', ['merchant' => $merchant]) }}`)"
        @else
        href="{{ route('merchant.dashboard.activity_log.index') }}"
        wire:click.prevent="intended(`{{ route('merchant.dashboard.activity_log.index') }}`)" @endif
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all
                @if (Route::is('merchant.dashboard.activity_log.index') || Route::is('merchant.dashboard.m.activity_log.index')) bg-orange-500 text-white shadow-md
                @else
                    text-slate-600 hover:bg-slate-100 @endif">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="w-5 h-5">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                <path d="M3 3v5h5"></path>
                <path d="M12 7v5l4 2"></path>
            </svg>
            <span>سجل الأنشطة</span>
        </a>
    @endif
</div>
