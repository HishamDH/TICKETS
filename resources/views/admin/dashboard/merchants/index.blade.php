@extends('admin.layouts.app')
@section('content')
<div bis_skin_checked="1" style="opacity: 1; transform: none;">
    <div class="space-y-6" bis_skin_checked="1">
        <div class="flex justify-between items-center" bis_skin_checked="1">
            <div bis_skin_checked="1">
                <h1 class="text-3xl font-bold text-slate-800">إدارة التجار</h1>
                <p class="text-slate-500 mt-1">مراجعة وتفعيل وإدارة حسابات التجار.</p>
            </div><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary hover:bg-primary/90 h-10 px-4 py-2 gradient-bg text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <line x1="19" x2="19" y1="8" y2="14"></line>
                    <line x1="22" x2="16" y1="11" y2="11"></line>
                </svg>إضافة تاجر</button>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg" bis_skin_checked="1">
            <div class="flex flex-col space-y-1.5 p-6" bis_skin_checked="1">
                <div class="flex justify-between items-center" bis_skin_checked="1">
                    <h3 class="text-xl font-semibold leading-none tracking-tight">قائمة التجار</h3>
                    <div class="flex items-center gap-2" bis_skin_checked="1">
                        <div class="relative w-64" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg><input  id="searchInput" class="flex h-10 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus:ring-2 focus:ring-primary focus:border-transparent transition-all pl-10" placeholder="بحث عن تاجر..."></div>

                    </div>
                </div>
            </div>
            <div class="p-6 pt-0" bis_skin_checked="1">
                <div class="relative w-full" bis_skin_checked="1">
                    @livewire('admin.dashboard.merchant.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // إخفاء كل القوائم المفتوحة
    window.addEventListener('click', function(e) {
        document.querySelectorAll('.action-menu').forEach(menu => {
            if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });

    function toggleMenu(button) {
        const menu = button.nextElementSibling;
        const allMenus = document.querySelectorAll('.action-menu');

        allMenus.forEach(m => {
            if (m !== menu) m.classList.add('hidden');
        });

        menu.classList.toggle('hidden');
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".merchant-card");

        searchInput.addEventListener("keyup", function () {
            const query = this.value.toLowerCase();
            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                card.style.display = text.includes(query) ? "" : "none";
            });
        });
    });
</script>
@endpush
