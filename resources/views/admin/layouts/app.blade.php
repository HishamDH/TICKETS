<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ LoadConfig()->setup->name ?? null   ?? "شباك التذاكر"}}</title>
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

        .scrolled-div::-webkit-scrollbar {
            width: 4px;
            /* عرض الشريط */
            height: 4px;
            /* للحالة الأفقية */
        }

        .scrolled-div::-webkit-scrollbar-track {
            background: #888;
            /* خلفية المسار */
            border-radius: 8px;
        }

        .scrolled-div::-webkit-scrollbar-thumb {
            background: orange;
            /* لون مقبض السكرول */
            /* border-radius: 8px; */
        }

        .scrolled-div::-webkit-scrollbar-thumb:hover {
            background: rgb(208, 135, 0);
            /* لون المقبض عند التحويم */
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
    <div class="flex h-screen bg-slate-100" dir="rtl" bis_skin_checked="1">
            
        <div class="scrolled-div fixed top-0 right-0 h-full overflow-y-auto bg-slate-800 text-white w-64 z-40 flex flex-col" bis_skin_checked="1" style="transform: none;">
            <div class="p-6 mb-4 flex items-center justify-center border-b border-slate-700" bis_skin_checked="1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-orange-500">
                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
                    <path d="M13 5v2"></path>
                    <path d="M13 17v2"></path>
                    <path d="M13 11v2"></path>
                </svg>
                <h1 class="text-2xl font-bold mr-2">شباك التذاكر</h1>
            </div>
            @livewire('admin.aside.nav')
            <div class="mt-auto p-4 border-t" bis_skin_checked="1">
                <form action="{{route('admin.logout')}}" method="post">
                    @csrf
                    <button type="submit" class="inline-flex items-center rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full justify-start text-base text-orange-500 hover:text-orange-600 hover:bg-orange-500/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-3">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" x2="9" y1="12" y2="12"></line>
                        </svg>تسجيل الخروج</button>
                </form>
            </div>
            <!-- <div class="p-4 border-t border-slate-700" bis_skin_checked="1">
                    <p class="text-xs text-slate-400 text-center">© 2025 شباك التذاكر. جميع الحقوق محفوظة.</p>
                </div> -->
        </div>

        <div class="flex-1 flex flex-col transition-all duration-300 mr-64" bis_skin_checked="1">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center sticky top-0 z-30"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg></button>
                <div class="flex items-center gap-4" bis_skin_checked="1"><button class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 relative text-slate-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                        </svg><span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span></button><span class="relative flex shrink-0 overflow-hidden rounded-full cursor-pointer h-9 w-9" type="button" id="radix-:r1k:" aria-haspopup="menu" aria-expanded="false" data-state="closed"><img class="aspect-square h-full w-full" alt="Admin" src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?q=80&amp;w=200"></span></div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 lg:p-8">

                @yield('content')

            </main>
        </div>
    </div>
    @livewireScripts()
    @stack('scripts')
</body>

</html>
