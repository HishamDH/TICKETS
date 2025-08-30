<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $merchant->business_name??'' }}</title>
    <link rel="shortcut icon" href="{{ Storage::url(isset($merchant->additional_data)?$merchant->additional_data['profile_picture']??'':'') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <style>
        .floating-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    <style>
        * {
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-variation-settings:
                "slnt" 0;
        }
    </style>
</head>

<body class="font-sans">
    <!-- Header ثابت وفوق المحتوى -->
    <header class="fixed top-0 end-0 z-[100]">
        <div class="flex items-center justify-end p-3 space-x-4 rtl:space-x-reverse">
            @if (Auth::guard('customer')->check())
            <!-- زر السلة -->
            <a href="{{ route('template1.cart',['id'=>$merchant->id]) }}" class="w-10 h-10 bg-black text-white rounded flex items-center justify-center hover:opacity-80 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13l-1.5-7M7 13h10" />
                </svg>
            </a>
            @endif


            <!-- زر الحساب -->
            <a href="{{ Auth::guard('customer')->check()?route('customer.dashboard.overview'):route('customer.login',['redirect' => url()->current()]) }}" class="w-10 h-10 bg-black text-white rounded flex items-center justify-center hover:opacity-80 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.654 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
        </div>
    </header>


    @yield('content')

    <footer class="bg-gray-900 text-white py-10">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h4 class="text-lg font-bold mb-4">{{ $merchant->business_name??'' }}</h4>
                <p class="text-sm">{{ $merchant->additional_data?$merchant->additional_data['discription']??'':'' }}</p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">روابط سريعة</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-orange-400">منتجاتنا</a></li>
                    <li><a href="#" class="hover:text-orange-400">الحجوزات</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">اتصل بنا</h4>
                <p class="text-sm">الهاتف: <a href="tel:{{ $merchant->phone??'' }}">{{ $merchant->phone??'' }}</a></p>
                <p class="text-sm">الإيميل: contact@ticker-window.sa</p>
            </div>
        </div>
        <div class="text-center text-xs text-gray-400 mt-6">
            جميع الحقوق محفوظة لدى <a class="text-orange-500" href="{{ config('app.url') }}">{{ LoadConfig()->setup->name ?? null  }} © 2025 </a>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>

</html>
