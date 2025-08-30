<!-- Navbar -->
<nav class="fixed top-0 w-full bg-white/80 backdrop-blur-lg border-b border-gray-200/80 z-50">
    <div class="container mx-auto px-4" bis_skin_checked="1">
        <div class="flex items-center justify-between h-16" bis_skin_checked="1">
            <div class="flex items-center cursor-pointer" bis_skin_checked="1"><img alt="logo" class="w-10 h-10 ml-3"
                    src="{{ Storage::url(LoadConfig()->setup->logo ?? null) }}"><span
                    class="text-xl font-bold gradient-text">{{ LoadConfig()->setup->name ?? null  ?? "شباك التذاكر" }}</span></div>
            <div class="hidden md:flex items-center space-x-2 space-x-reverse" bis_skin_checked="1">
                <a href="{{ route('home') }}" wire:click.prevent="checkAccess('{{ route('home') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('home')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">الرئيسية
                </a>
                {{-- <!-- <a href="{{ route('features') }}" wire:click.prevent="checkAccess('{{ route('features') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('features')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">المميزات</a>
                <a href="{{ route('merchant') }}" wire:click.prevent="checkAccess('{{ route('merchant') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('merchant')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">رحلة
                    التاجر</a><a href="{{ route('partners') }}"
                    wire:click.prevent="checkAccess('{{ route('partners') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('partners')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">نظام
                    الشركاء</a><a href="{{ route('wallet') }}"
                    wire:click.prevent="checkAccess('{{ route('wallet') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('wallet')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">المحفظة
                    والحماية</a><a href="{{ route('roles') }}"
                    wire:click.prevent="checkAccess('{{ route('roles') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('roles')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">الأدوار
                    والرحلات</a> --> --}}
                    <a href="{{ route('pricing') }}"
                    wire:click.prevent="checkAccess('{{ route('pricing') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('pricing')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">الباقات</a>
                <a href="{{ Auth::guard('merchant')->user()?route('merchant.dashboard.overview'):route('login') }}" wire:click.prevent="checkAccess('{{ Auth::guard('merchant')->user()?route('merchant.dashboard.overview'):route('login') }}')"
                    class="px-4 py-2 relative font-medium @if (Route::is('login')) text-orange-500 border-b-2 border-orange-500 transition-all duration-500 @else text-gray-600 hover:text-orange-500 @endif">{{ Auth::guard('merchant')->user()?__('dashboard'):__('login') }}</a>
            </div><button id="burgerBtn" onclick="initBurgerMenu()" class="md:hidden p-2 text-gray-700"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                    <line x1="4" x2="20" y1="12" y2="12"></line>
                    <line x1="4" x2="20" y1="6" y2="6"></line>
                    <line x1="4" x2="20" y1="18" y2="18"></line>
                </svg></button>
        </div>
        <div id="mobileMenu" class="md:hidden hidden border-t border-gray-200/80" style="opacity: 1; height: auto;" bis_skin_checked="1">
            <div class="flex flex-col space-y-2 py-4" bis_skin_checked="1">
                <a href="{{ route('home') }}" wire:click.prevent="checkAccess('{{ route('home') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('home')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif font-semibold">الرئيسية</a>
                {{-- <!-- <a href="{{ route('features') }}" wire:click.prevent="checkAccess('{{ route('features') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('features')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">المميزات</a>
                <a href="{{ route('merchant') }}" wire:click.prevent="checkAccess('{{ route('merchant') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('merchant')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">رحلة
                    التاجر</a>
                <a href="{{ route('partners') }}" wire:click.prevent="checkAccess('{{ route('partners') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('partners')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">نظام
                    الشركاء</a>
                <a href="{{ route('wallet') }}" wire:click.prevent="checkAccess('{{ route('wallet') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('wallet')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">المحفظة
                    والحماية</a>
                <a href="{{ route('roles') }}" wire:click.prevent="checkAccess('{{ route('roles') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('roles')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">الأدوار
                    والرحلات</a> --> --}}
                <a href="{{ route('pricing') }}" wire:click.prevent="checkAccess('{{ route('pricing') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('pricing')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">الباقات</a>
                <a href="{{ Auth::guard('merchant')->user()?route('merchant.dashboard.overview'):route('login') }}" wire:click.prevent="checkAccess('{{ Auth::guard('merchant')->user()?route('merchant.dashboard.overview'):route('login') }}')"
                    class="block w-full text-right px-4 py-3 rounded-lg transition-colors @if (Route::is('login')) text-orange-500 bg-orange-500/10 transition-all duration-500 @else text-gray-600 hover:text-orange-500 hover:bg-orange-500/10 @endif">{{ Auth::guard('merchant')->user()?__('dashboard'):__('login') }}</a>
            </div>
        </div>
    </div>
</nav>
