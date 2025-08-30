<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ LoadConfig()->setup->name ?? null  ?? "شباك التذاكر" }}</title>
    <link rel="shortcut icon" href="{{ Storage::url(LoadConfig()->setup->logo ?? null) }}" type="image/x-icon">
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
@php
    $isSetupd= true;
    if(!first_setup()){
        $isSetupd = false;
    }
@endphp

<body class="font-sans">


    @if(!$isSetupd)
                @livewire('general_setup')

                @else
                @livewire('front.nav')

                @yield('content')

                <footer class="bg-slate-900 text-white py-12">
        <div class="mx-[5%]">
            <div class="container mx-auto px-4" bis_skin_checked="1">
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8" bis_skin_checked="1">
                    <div bis_skin_checked="1">
                        <div class="flex items-center mb-4 cursor-pointer" bis_skin_checked="1"><img
                                alt="logo" class="w-10 h-10 ml-3"
                                src="{{Storage::url(LoadConfig()->setup->logo ?? null)}}"><span
                                class="text-xl font-bold text-white">{{ LoadConfig()->setup->name ?? null  ?? "شباك التذاكر" }}</span></div>
                        <p class="text-gray-400 text-sm leading-relaxed">البوابة الذكية لحجوزات الفعاليات والمطاعم
                            والمعارض، بوابتك نحو تجربة فريدة.</p>
                    </div>
                    <div bis_skin_checked="1"><span class="text-lg font-semibold mb-4 block text-gray-200">خدماتنا</span>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-primary transition-colors">إدارة الفعاليات</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">حجوزات المطاعم</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">تنظيم المعارض</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">نظام التحقق</a></li>
                        </ul>
                    </div>
                    <div bis_skin_checked="1"><span class="text-lg font-semibold mb-4 block text-gray-200">روابط
                            سريعة</span>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-primary transition-colors">الرئيسية</a></li>
                            <!-- <li><a href="" class="hover:text-primary transition-colors">المميزات</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">الأدوار والرحلات</a></li> -->
                            <li><a href="#" class="hover:text-primary transition-colors">الباقات</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">انضم كتاجر</a></li>
                        </ul>
                    </div>
                    <div bis_skin_checked="1"><span class="text-lg font-semibold mb-4 block text-gray-200">تواصل
                            معنا</span>
                        <div class="space-y-3 text-sm text-gray-400" bis_skin_checked="1">
                            <p>البريد: <a href="mailto:info@shobaktickets.com"
                                    class="hover:text-primary transition-colors">info@shobaktickets.com</a></p>
                            <p>الهاتف: <a href="tel:+966111234567" class="hover:text-primary transition-colors">+966 11
                                    XXX XXXX</a></p>
                            <p>العنوان: الرياض، المملكة العربية السعودية</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center" bis_skin_checked="1">
                    <p class="text-gray-500 text-sm">© 2025 شباك التذاكر. جميع الحقوق محفوظة.</p>
                </div>
            </div>
        </div>
    </footer>
     @endif

    @livewireScripts
    @stack('scripts')
    <script>
    function initBurgerMenu() {
        let burgerBtn = document.getElementById('burgerBtn');
        let mobileMenu = document.getElementById('mobileMenu');

        if (burgerBtn && mobileMenu) {
            // تخلص من كل الأحداث القديمة عن طريق استبدال العنصر بنفسه (clone)
            const newBtn = burgerBtn.cloneNode(true);
            burgerBtn.parentNode.replaceChild(newBtn, burgerBtn);
            burgerBtn = newBtn;

            burgerBtn.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', initBurgerMenu);
    document.addEventListener('livewire:navigated', initBurgerMenu);
</script>


</body>

</html>
