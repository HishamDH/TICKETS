@extends('layouts.app')
@section('content')

<body class="text-gray-800 grid grid-cols-10">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-0 left-0 h-full w-64 glassmorphism shadow-lg z-20 hidden md:block">
        <div class="flex flex-col h-full p-6">
            <!-- Logo -->
            <div class="grid grid-cols-10">
                <div class="mb-10 flex items-center gap-2 col-span-8 sm:col-span-10">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center text-white font-bold text-xl">
                        S
                    </div>
                    <span class="text-2xl font-semibold text-gray-700">Admin</span>
                </div>
                <div class="col-span-2 sm:hidden text-right">
                    <button id="menu-toggle1" class="md:hidden p-2 bg-white shadow rounded-full">
                        <i class="ri-menu-line text-2xl text-gray-600"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1">
                <ul class="space-y-4">
                    <li>
                        <a href="{{route('admin.dashboard')}}"
                            class="flex items-center gap-3 text-gray-700 font-medium hover:text-primary transition">
                            <i class="ri-dashboard-line text-xl"></i>
                            Overview
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.sellers.index') }}"
                            class="flex items-center gap-3 text-gray-700 font-medium hover:text-primary transition">
                            <i class="ri-user-line text-xl"></i>
                            Sellers
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.employees.index') }}"
                            class="flex items-center gap-3 text-gray-700 font-medium hover:text-primary transition">
                            <i class="ri-team-line text-xl"></i>
                            Employees
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
    <div class="col-span-2"></div>

    <div class="relative max-h-screen overflow-hidden overflow-y-scroll col-span-10 sm:col-span-8 sm:px-12 md:px-12 lg:px-12">

        <!-- Particles -->
        <div
            id="particles-container"
            class="absolute inset-0 z-0 pointer-events-none"></div>

        <div class="container mx-auto px-4 py-8 relative z-10">
            <div class="fixed top-4 left-4 z-30 md:hidden">
                <button id="menu-toggle" class="p-2 bg-white shadow rounded-full">
                    <i class="ri-menu-line text-2xl text-gray-600"></i> Burger menu
                </button>
            </div>
            <ul id="settings-menu" class="fixed bg-white glassmorphism shadow-lg rounded-lg py-2 z-[99999] hidden">
                <li>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-700 font-medium hover:bg-gray-100 transition">
                        <i class="ri-settings-3-line text-xl"></i> Settings
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-2 text-red-500 font-medium hover:bg-red-100 transition w-full text-left">
                            <i class="ri-logout-box-line text-xl"></i> Logout
                        </button>
                    </form>

                </li>
            </ul>
            <ul id="notifications-menu" class="fixed bg-white glassmorphism shadow-lg rounded-lg py-2 z-[99999] hidden w-80 max-w-[90vw]">
                <li class="px-4 py-2 border-b border-gray-100">
                    <div class="flex items-start gap-3">
                        <i class="ri-information-line text-xl text-primary"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">New booking confirmed</p>
                            <p class="text-xs text-gray-500">2 minutes ago</p>
                        </div>
                    </div>
                </li>
                <li class="px-4 py-2 border-b border-gray-100">
                    <div class="flex items-start gap-3">
                        <i class="ri-calendar-event-line text-xl text-secondary"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Upcoming event tomorrow</p>
                            <p class="text-xs text-gray-500">1 hour ago</p>
                        </div>
                    </div>
                </li>
                <li class="px-4 py-2">
                    <div class="flex items-center justify-center">
                        <a href="#" class="text-sm text-primary font-medium">View All Notifications</a>
                    </div>
                </li>
            </ul>


            <!-- Header Section -->
            <header
                class="mt-5 sm:mt-0 glassmorphism rounded-xl p-4 mb-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-r from-primary to-secondary flex items-center justify-center overflow-hidden border-2 border-white">
                        <img
                            src="https://readdy.ai/api/search-image?query=professional%20portrait%20photo%20of%20a%20young%20middle%20eastern%20man%20with%20short%20dark%20hair%20and%20a%20friendly%20smile%2C%20high%20quality%2C%20photorealistic%2C%20soft%20lighting%2C%20neutral%20background&width=200&height=200&seq=avatar1&orientation=squarish"
                            alt="User Avatar"
                            class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-semibold">
                            {{ Auth::user()->name }}
                        </h1>
                        <p class="text-sm text-gray-600">{{ Carbon\Carbon::now()->format('D, M d, Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="relative w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 cursor-pointer">
                        <i class="ri-notification-3-line ri-xl"></i>
                        <span
                            class="absolute top-2 right-2 w-2 h-2 rounded-full bg-secondary"></span>
                    </div>
                    <div class="relative w-10 h-10 flex items-center justify-center rounded-full hover:bg-gray-100 cursor-pointer group z-10">
                        <i class="ri-settings-3-line ri-xl"></i>
                    </div>

                </div>
            </header>
            @yield('sub_content')
        </div>
    </div>
    @stack('scripts')
</body>







<script id="carousel-control">
    document.addEventListener("DOMContentLoaded", function() {
        const carousel = document.getElementById("carousel");
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");
        const scrollAmount = 300;

        prevBtn.addEventListener("click", function() {
            carousel.scrollBy({
                left: -scrollAmount,
                behavior: "smooth",
            });
        });

        nextBtn.addEventListener("click", function() {
            carousel.scrollBy({
                left: scrollAmount,
                behavior: "smooth",
            });
        });
    });
    document.getElementById("menu-toggle").addEventListener("click", function() {
        toggleSidebar();
    });
    document.getElementById("menu-toggle1").addEventListener("click", function() {
        toggleSidebar();
    });

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("translate-x-0");
        sidebar.classList.toggle("hidden");
        sidebar.classList.toggle("w-full");
        sidebar.classList.toggle("w-64");
    }
    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.querySelector('.ri-settings-3-line.ri-xl');
        const menu = document.getElementById('settings-menu');

        btn.addEventListener('click', function(e) {
            const notifMenu = document.getElementById('notifications-menu');
            if (!notifMenu.classList.contains('hidden')) {
                notifMenu.classList.toggle('hidden');
            }
            e.stopPropagation();
            const rect = btn.getBoundingClientRect();
            menu.classList.toggle('hidden');
            menu.style.top = (rect.bottom + 10) + 'px';
            menu.style.left = (rect.left - (menu.offsetWidth - rect.width)) + 'px';
        });

        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        const notifBtn = document.querySelector('.ri-notification-3-line.ri-xl');
        const notifMenu = document.getElementById('notifications-menu');

        notifBtn.addEventListener('click', function(e) {
            const menu = document.getElementById('settings-menu');
            if (!menu.classList.contains('hidden')) {
                menu.classList.toggle('hidden');
            }
            e.stopPropagation();
            const rect = notifBtn.getBoundingClientRect();
            notifMenu.classList.toggle('hidden');
            notifMenu.style.top = (rect.bottom + 10) + 'px';
            notifMenu.style.left = (rect.left - (notifMenu.offsetWidth - rect.width)) + 'px';
        });

        document.addEventListener('click', function(e) {
            if (!notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                notifMenu.classList.add('hidden');
            }
        });
    });
</script>



@endsection








