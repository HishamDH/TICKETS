<div x-data="{ modalOpen: false, modalContent: null }" class="relative" x-cloak>

    @php
    $profile = $offering->user->additional_data['profile_picture'] ?? null;
    $id = $offering->user->id ?? null;
    $gallery = $offering->features['gallery'] ?? [];
    @endphp

    {{-- Particles --}}
    <div id="particles-js" class="fixed inset-0 z-0"></div>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.0/tsparticles.bundle.min.js"></script>
    <script>
        tsParticles.load("particles-js", {
            fpsLimit: 60,
            particles: {
                number: {
                    value: 80,
                    limit: 120 // ← ما يزيد عن 120 particle
                },
                color: {
                    value: ["#FFA500", "#FF8C00", "#FFD700"]
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.5,
                    random: true
                },
                size: {
                    value: {
                        min: 2,
                        max: 6
                    },
                    random: true
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "none",
                    outModes: "bounce"
                },
                links: {
                    enable: true,
                    distance: 120,
                    color: "#FFA500",
                    opacity: 0.2,
                    width: 1
                }
            },
            interactivity: {
                events: {
                    onhover: {
                        enable: true,
                        mode: "grab"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    }
                },
                modes: {
                    grab: {
                        distance: 150,
                        links: {
                            opacity: 0.4
                        }
                    }
                }
            },
            detectRetina: true
        });
    </script>

    {{-- AOS --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 900,
                once: true,
                easing: "ease-out-back"
            });
        });
    </script>

    {{-- Glassmorphism & Animations CSS --}}
    <style>
        .glass-card {
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .float:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }
        }

        .shake:hover {
            animation: shake 0.5s ease-in-out;
        }
    </style>

    {{-- Modal --}}
    <div x-show="modalOpen" x-transition.opacity
    class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center">
    <button @click="modalOpen=false"
            class="absolute top-4 right-4 z-50 bg-black/60 text-white rounded-full w-10 h-10 flex items-center justify-center text-2xl font-bold hover:bg-red-600">
            &times;
        </button>
    <div class="relative max-w-4xl w-full px-6">
        
        <!-- زر الإغلاق -->


        <div x-html="modalContent" class="relative z-40"></div>
    </div>
</div>


    {{-- Main Page --}}
    <div class="relative z-10 max-w-7xl mx-auto space-y-10 p-6 md:p-10">

        {{-- Back Button --}}
        <a href="{{ route('template', $id) }}" wire:navigate
            class="glass-card inline-flex items-center px-4 py-2 font-semibold text-orange-600 hover:text-orange-800 hover:scale-105 transition-all duration-300">
            ← الرجوع
        </a>

        {{-- Main Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

            {{-- Main Image --}}
            @if ($offering->image)
            <div data-aos="fade-up"
                class="glass-card overflow-hidden transform hover:scale-105 hover:rotate-1 transition-all duration-500">
                <img src="{{ Storage::url($offering->image) }}" alt="{{ $offering->name }}"
                    class="w-full h-80 md:h-full object-cover">
            </div>
            @endif

            {{-- Service Info --}}
            <div data-aos="fade-up" data-aos-delay="100" class="space-y-6 glass-card p-6 float">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-wide">{{ $offering->name }}</h1>
                <p class="text-base text-gray-500 font-medium">الموقع: <span
                        class="text-gray-700">{{ $offering->location }}</span></p>
                <p class="text-2xl text-green-600 font-bold">السعر: {{ $offering->price }} دج</p>

                <div
                    class="text-base text-gray-700 leading-relaxed max-h-60 overflow-y-auto border-t pt-4 whitespace-pre-line scrollbar-thin scrollbar-thumb-orange-300 scrollbar-track-gray-100">
                    {!! nl2br(e($offering->description)) !!}
                </div>

                {{-- Seller Info --}}
                @if ($offering->user)
                <a href="{{ route('template', $id) }}" wire:navigate
                    class="glass-card p-4 flex items-center gap-4 hover:scale-105 transition-all duration-300 float">
                    <img src="{{ $profile ? Storage::url($profile) : 'https://ui-avatars.com/api/?name=' . urlencode($offering->user->f_name . ' ' . $offering->user->l_name) }}"
                        alt="صورة التاجر"
                        class="w-16 h-16 rounded-full object-cover border-2 border-orange-300 shadow">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $offering->user->business_name ?? $offering->user->f_name . ' ' . $offering->user->l_name }}
                        </p>
                        <p class="text-sm text-gray-500">صاحب الخدمة</p>
                    </div>
                </a>
                @endif
            </div>
        </div>

        {{-- Gallery --}}
        @if (is_array($gallery) && count($gallery))
        <div class="border-t pt-8" data-aos="fade-up" data-aos-delay="200">
            <h3 class="text-xl font-bold text-gray-800 mb-6">صور إضافية:</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($gallery as $img)
                <img src="{{ Storage::url($img) }}"
                    @click="modalOpen=true; modalContent='<img src={{ Storage::url($img) }} class=rounded-2xl max-h-[85vh] w-full object-contain shadow-xl border-4 border-white>'"
                    class="glass-card cursor-pointer object-cover h-32 w-full rounded-2xl float shake transition-all duration-300"
                    alt="صورة إضافية">
                @endforeach
            </div>
        </div>
        @endif

        {{-- Livewire Components --}}
        <div class="space-y-10">
    {{-- سيشنز --}}
    @if (!empty($offering->features['sessions']))
        @livewire('templates.template1.components.session', ['offering' => $offering], key('session-' . $offering->id))
    @endif

    {{-- السياحة: destinations --}}
    @if ($category === 'tourism' && !empty($offering->features['destinations']))
        @livewire('templates.template1.components.destination', ['offering' => $offering], key('destination-' . $offering->id))
    @endif

    {{-- المعارض: products --}}
    @if ($category === 'exhibition' && !empty($offering->features['products']))
        @livewire('templates.template1.components.products', ['offering' => $offering], key('products-' . $offering->id))
    @endif

    {{-- الصيانة: supportedDevices --}}
    @if ($category === 'maintenance' && !empty($offering->features['supportedDevices']))
        @livewire('templates.template1.components.support-devices', ['offering' => $offering], key('support-' . $offering->id))
    @endif

    {{-- ورش: trainingWorkshops --}}
    @if ($category === 'workshop' && !empty($offering->features['trainingWorkshops']))
        @livewire('templates.template1.components.train-workshops', ['offering' => $offering], key('workshop-' . $offering->id))
    @endif

    {{-- مطاعم: plats --}}
    @if ($category === 'restaurant' && !empty($offering->features['plats']))
        @livewire('templates.template1.components.plats', ['offering' => $offering], key('plats-' . $offering->id))
    @endif

    {{-- أونلاين: eventLinks --}}
    @if ($category === 'online' && !empty($offering->features['eventLinks']))
        @livewire('templates.template1.components.eventlinks', ['offering' => $offering], key('eventlinks-' . $offering->id))
    @endif

    {{-- فعاليات أطفال --}}
    @if ($category === 'children_event')
        @if (!empty($offering->features['games']))
            @livewire('templates.template1.components.games', ['offering' => $offering], key('games-' . $offering->id))
        @endif

        @if (!empty($offering->features['kidshops']))
            @livewire('templates.template1.components.kidshops', ['offering' => $offering], key('kidshops-' . $offering->id))
        @endif

        @if (!empty($offering->features['cartoons']))
            @livewire('templates.template1.components.cartoons', ['offering' => $offering], key('cartoons-' . $offering->id))
        @endif
    @endif

    {{-- سيرفيس: portfolio --}}
    @if ($type === 'services' && !empty($offering->features['Portfolio']))
        @livewire('templates.template1.components.portfolio', ['offering' => $offering], key('portfolio-' . $offering->id))
    @endif

    {{-- باقي الخصائص --}}
    @if (!empty($offering->features['speakers']))
        @livewire('templates.template1.components.speakers', ['offering' => $offering], key('speakers-' . $offering->id))
    @endif

    @if (!empty($offering->features['Offerfeatures']))
        @livewire('templates.template1.components.offer-features', ['offering' => $offering], key('features-' . $offering->id))
    @endif

    @if (!empty($offering->features['sponsors']))
        @livewire('templates.template1.components.sponsors', ['offering' => $offering], key('sponsors-' . $offering->id))
    @endif

    @if (!empty($offering->features['activities']))
        @livewire('templates.template1.components.activities', ['offering' => $offering], key('activities-' . $offering->id))
    @endif

    @if (!empty($offering->features['services']))
        @livewire('templates.template1.components.services', ['offering' => $offering], key('services-' . $offering->id))
    @endif

    @if (!empty($offering->features['availableTools']))
        @livewire('templates.template1.components.tools', ['offering' => $offering], key('tools-' . $offering->id))
    @endif
</div>



    </div>
</div>