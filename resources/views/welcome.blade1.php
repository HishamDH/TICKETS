@extends('layouts.app')
@push('styles')
<style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        overflow-x: hidden;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(106, 90, 205, 0.1);
    }

    .neumorphism {
        box-shadow:
            8px 8px 16px rgba(106, 90, 205, 0.1),
            -8px -8px 16px rgba(255, 255, 255, 0.7);
    }

    .event-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow:
            0 8px 32px rgba(106, 90, 205, 0.1),
            inset 0 0 16px rgba(224, 255, 255, 0.05);
        transform-style: preserve-3d;
        transition: all 0.5s ease;
    }

    .event-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow:
            0 16px 48px rgba(106, 90, 205, 0.15),
            inset 0 0 24px rgba(224, 255, 255, 0.1);
    }

    .light-beam {
        background: linear-gradient(90deg,
                rgba(224, 255, 255, 0) 0%,
                rgba(224, 255, 255, 0.1) 50%,
                rgba(224, 255, 255, 0) 100%);
        transform: rotate(-45deg);
        position: absolute;
        width: 200%;
        height: 100px;
        top: -50px;
        left: -50%;
        animation: beam-move 8s infinite linear;
    }

    /* @keyframes beam-move {
            0% {
                transform: rotate(-45deg) translateX(-100%);
            }

            100% {
                transform: rotate(-45deg) translateX(100%);
            }
        } */

    .nav-button {
        transition: all 0.3s ease;
    }

    .nav-button:hover {
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 15px rgba(87, 181, 231, 0.5);
    }

    .calendar-day {
        transition: all 0.3s ease;
    }

    .calendar-day:hover:not(.calendar-day-active) {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    .calendar-day-active {
        background: rgba(87, 181, 231, 0.2);
        box-shadow: 0 0 10px rgba(87, 181, 231, 0.3);
    }

    .grid-background {
        background-image:
            linear-gradient(rgba(177, 156, 217, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(177, 156, 217, 0.1) 1px, transparent 1px);
        background-size: 40px 40px;
        background-position: center center;
        perspective: 1000px;
        transform-style: preserve-3d;
        transform: rotateX(60deg) scale(1.5);
        opacity: 0.3;
    }

    .hero-bg {
        background-image: radial-gradient(circle at 20% 30%, rgba(224, 255, 255, 0.15) 0%, transparent 60%),
            radial-gradient(circle at 80% 70%, rgba(177, 156, 217, 0.15) 0%, transparent 60%);
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }

    /* @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        } */

    .glow {
        box-shadow: 0 0 15px rgba(87, 181, 231, 0.5);
    }
</style>
@endpush
@section('content')

<body class="min-h-screen overflow-x-hidden">
    <div class="hero-bg relative min-h-screen">
        <!-- Light beams -->
        <div class="light-beam"></div>
        <div class="light-beam" style="animation-delay: 4s;"></div>

        <!-- Grid background -->
        <div class="grid-background absolute inset-0 z-0"></div>

        <!-- Navigation -->
        <nav class="fixed top-0 left-0 w-full z-50 px-8 py-6 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-3xl font-['Pacifico'] text-primary">{{ LoadConfig()->setup->name ?? null  }}</h1>
            </div>

            <div class="flex items-center space-x-6">
                <button class="nav-button glassmorphism px-6 py-3 rounded-full text-indigo-900 font-medium tracking-wide !rounded-button whitespace-nowrap">Explore</button>
                <button class="nav-button glassmorphism px-6 py-3 rounded-full text-indigo-900 font-medium tracking-wide !rounded-button whitespace-nowrap">Events</button>
                <button class="nav-button glassmorphism px-6 py-3 rounded-full text-indigo-900 font-medium tracking-wide !rounded-button whitespace-nowrap">Artists</button>
                <button class="nav-button glassmorphism px-6 py-3 rounded-full text-indigo-900 font-medium tracking-wide !rounded-button whitespace-nowrap">About</button>
                <a href="{{ Auth::user()?route('dashboard'):route('login') }}" class="nav-button bg-primary bg-opacity-20 px-6 py-3 rounded-full text-primary font-semibold tracking-wide !rounded-button whitespace-nowrap">{{ Auth::user()?'Dashboard':'Sign In' }}</a>
            </div>
        </nav>

        <!-- Main content -->
        <main class="container mx-auto pt-32 pb-20 px-8 relative z-10 flex">
            <!-- Left side - Event cards -->
            <div class="w-full pr-8">
                <div class="mb-12">
                    <h2 class="text-5xl font-bold text-indigo-900 tracking-wider mb-4 font-['Space_Grotesk']">Discover <span class="text-primary">Extraordinary</span> Events</h2>
                    <p class="text-lg text-indigo-700 max-w-2xl">Step into our virtual exhibition hall where every event is a unique experience waiting to unfold. Explore and book your next adventure.</p>
                </div>

                <!-- Search bar -->
                <div class="glassmorphism rounded-full flex items-center px-6 py-4 mb-12 max-w-2xl">
                    <div class="w-5 h-5 flex items-center justify-center mr-3">
                        <i class="ri-search-line text-indigo-400"></i>
                    </div>
                    <input type="text" placeholder="Search events, artists, or venues..." class="bg-transparent border-none outline-none flex-1 text-indigo-900 placeholder-indigo-300">
                    <button class="bg-primary bg-opacity-20 text-primary px-6 py-2 rounded-full font-medium !rounded-button whitespace-nowrap">Search</button>
                </div>

                <!-- Event cards grid -->
                <div class="grid grid-cols-4 gap-8">
                    <!-- Event card 1 -->
                    <div class="event-card rounded-2xl p-6 h-96 flex flex-col justify-between floating-animation" style="animation-delay: 0s;">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full bg-primary bg-opacity-20 text-primary text-sm font-medium mb-3">Music</span>
                                <h3 class="text-2xl font-bold text-indigo-900 font-['Space_Grotesk']">Neon Horizon Festival</h3>
                                <p class="text-indigo-700 mt-2">An immersive electronic music experience with top global artists</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                                <i class="ri-heart-line text-indigo-400"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-map-pin-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">Quantum Arena, San Francisco</span>
                            </div>
                            <div class="flex items-center mb-6">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-calendar-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">June 15-17, 2025</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-900">$149.99</span>
                                <button class="bg-primary px-5 py-2 rounded-full text-white font-medium !rounded-button whitespace-nowrap">Book Now</button>
                            </div>
                        </div>
                    </div>

                    <!-- Event card 2 -->
                    <div class="event-card rounded-2xl p-6 h-96 flex flex-col justify-between floating-animation" style="animation-delay: 1s;">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full bg-secondary bg-opacity-20 text-secondary text-sm font-medium mb-3">Art</span>
                                <h3 class="text-2xl font-bold text-indigo-900 font-['Space_Grotesk']">Digital Dreams Exhibition</h3>
                                <p class="text-indigo-700 mt-2">Cutting-edge digital art installations from renowned creators</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                                <i class="ri-heart-line text-indigo-400"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-map-pin-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">Nova Gallery, New York</span>
                            </div>
                            <div class="flex items-center mb-6">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-calendar-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">July 3-28, 2025</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-900">$35.00</span>
                                <button class="bg-secondary px-5 py-2 rounded-full text-white font-medium !rounded-button whitespace-nowrap">Book Now</button>
                            </div>
                        </div>
                    </div>

                    <!-- Event card 3 -->
                    <div class="event-card rounded-2xl p-6 h-96 flex flex-col justify-between floating-animation" style="animation-delay: 0.5s;">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-600 text-sm font-medium mb-3">Conference</span>
                                <h3 class="text-2xl font-bold text-indigo-900 font-['Space_Grotesk']">Future Tech Summit</h3>
                                <p class="text-indigo-700 mt-2">Explore emerging technologies with industry pioneers</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                                <i class="ri-heart-fill text-red-400"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-map-pin-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">Prism Convention Center, Tokyo</span>
                            </div>
                            <div class="flex items-center mb-6">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-calendar-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">August 10-12, 2025</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-900">$299.99</span>
                                <button class="bg-yellow-500 px-5 py-2 rounded-full text-white font-medium !rounded-button whitespace-nowrap">Book Now</button>
                            </div>
                        </div>
                    </div>

                    <!-- Event card 4 -->
                    <div class="event-card rounded-2xl p-6 h-96 flex flex-col justify-between floating-animation" style="animation-delay: 1.5s;">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-medium mb-3">Theater</span>
                                <h3 class="text-2xl font-bold text-indigo-900 font-['Space_Grotesk']">Celestial: The Experience</h3>
                                <p class="text-indigo-700 mt-2">Immersive theatrical journey through space and time</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                                <i class="ri-heart-line text-indigo-400"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-4">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-map-pin-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">Lumina Theater, London</span>
                            </div>
                            <div class="flex items-center mb-6">
                                <div class="w-5 h-5 flex items-center justify-center mr-2">
                                    <i class="ri-calendar-line text-indigo-400"></i>
                                </div>
                                <span class="text-indigo-700">September 5-30, 2025</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-indigo-900">$85.50</span>
                                <button class="bg-green-500 px-5 py-2 rounded-full text-white font-medium !rounded-button whitespace-nowrap">Book Now</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View more button -->
                <div class="mt-12 text-center">
                    <button class="glassmorphism px-8 py-4 rounded-full text-indigo-900 font-medium tracking-wide inline-flex items-center !rounded-button whitespace-nowrap">
                        View More Events
                        <div class="w-5 h-5 flex items-center justify-center ml-2">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Right side - Calendar widget -->
            <div class="w-1/4 hidden">
                <div class="glassmorphism rounded-3xl p-6 sticky top-32">
                    <h3 class="text-xl font-bold text-indigo-900 mb-6 font-['Space_Grotesk']">Event Calendar</h3>

                    <!-- Month selector -->
                    <div class="flex justify-between items-center mb-6">
                        <button class="w-8 h-8 flex items-center justify-center rounded-full glassmorphism">
                            <i class="ri-arrow-left-s-line text-indigo-400"></i>
                        </button>
                        <span class="text-indigo-900 font-medium">June 2025</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded-full glassmorphism">
                            <i class="ri-arrow-right-s-line text-indigo-400"></i>
                        </button>
                    </div>

                    <!-- Weekdays -->
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        <span class="text-center text-xs text-indigo-400">Su</span>
                        <span class="text-center text-xs text-indigo-400">Mo</span>
                        <span class="text-center text-xs text-indigo-400">Tu</span>
                        <span class="text-center text-xs text-indigo-400">We</span>
                        <span class="text-center text-xs text-indigo-400">Th</span>
                        <span class="text-center text-xs text-indigo-400">Fr</span>
                        <span class="text-center text-xs text-indigo-400">Sa</span>
                    </div>

                    <!-- Calendar days -->
                    <div class="grid grid-cols-7 gap-1">
                        <!-- Previous month -->
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-300 text-sm">26</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-300 text-sm">27</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-300 text-sm">28</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-300 text-sm">29</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-300 text-sm">30</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-300 text-sm">31</button>

                        <!-- Current month -->
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">1</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">2</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">3</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">4</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">5</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">6</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">7</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">8</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">9</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">10</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">11</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">12</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">13</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">14</button>
                        <button class="calendar-day calendar-day-active w-8 h-8 flex items-center justify-center rounded-full text-primary font-bold text-sm glow">15</button>
                        <button class="calendar-day calendar-day-active w-8 h-8 flex items-center justify-center rounded-full text-primary font-bold text-sm glow">16</button>
                        <button class="calendar-day calendar-day-active w-8 h-8 flex items-center justify-center rounded-full text-primary font-bold text-sm glow">17</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">18</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">19</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">20</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">21</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">22</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">23</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">24</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">25</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">26</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">27</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">28</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">29</button>
                        <button class="calendar-day w-8 h-8 flex items-center justify-center rounded-full text-indigo-700 text-sm">30</button>
                    </div>

                    <!-- Upcoming events -->
                    <div class="mt-8">
                        <h4 class="text-md font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Upcoming Events</h4>

                        <!-- Event 1 -->
                        <div class="glassmorphism rounded-xl p-4 mb-3">
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary bg-opacity-20 mr-3">
                                    <i class="ri-music-line text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-indigo-900">Neon Horizon Festival</h5>
                                    <p class="text-xs text-indigo-700 mt-1">June 15-17, 2025</p>
                                </div>
                            </div>
                        </div>

                        <!-- Event 2 -->
                        <div class="glassmorphism rounded-xl p-4 mb-3">
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-secondary bg-opacity-20 mr-3">
                                    <i class="ri-paint-brush-line text-secondary"></i>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-indigo-900">Digital Dreams Exhibition</h5>
                                    <p class="text-xs text-indigo-700 mt-1">July 3-28, 2025</p>
                                </div>
                            </div>
                        </div>

                        <!-- Event 3 -->
                        <div class="glassmorphism rounded-xl p-4">
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-yellow-100 mr-3">
                                    <i class="ri-global-line text-yellow-600"></i>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-indigo-900">Future Tech Summit</h5>
                                    <p class="text-xs text-indigo-700 mt-1">August 10-12, 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter button -->
                    <button class="w-full glassmorphism mt-6 py-3 rounded-xl text-indigo-900 font-medium !rounded-button whitespace-nowrap">
                        Filter Events
                    </button>
                </div>
            </div>
        </main>

        <!-- Newsletter section -->
        <section class="container mx-auto px-8 py-16 relative z-10">
            <div class="glassmorphism rounded-3xl p-12 text-center">
                <h2 class="text-3xl font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Never Miss an Event</h2>
                <p class="text-indigo-700 max-w-xl mx-auto mb-8">Subscribe to our newsletter and be the first to know about exclusive events and special offers.</p>
                <div class="flex max-w-md mx-auto">
                    <input type="email" placeholder="Your email address" class="bg-white bg-opacity-30 border-none outline-none rounded-l-full px-6 py-3 flex-1 text-indigo-900 placeholder-indigo-300">
                    <button class="bg-primary px-6 py-3 rounded-r-full text-white font-medium !rounded-button whitespace-nowrap">Subscribe</button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="container mx-auto px-8 py-12 relative z-10">
            <div class="flex flex-wrap justify-between">
                <div class="w-1/4 mb-8">
                    <h1 class="text-3xl font-['Pacifico'] text-primary mb-4">{{ LoadConfig()->setup->name ?? null  }}</h1>
                    <p class="text-indigo-700 mb-6">Experience the future of event booking in our immersive virtual exhibition hall.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                            <i class="ri-facebook-fill text-indigo-400"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                            <i class="ri-twitter-x-fill text-indigo-400"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                            <i class="ri-instagram-fill text-indigo-400"></i>
                        </a>
                        <a href="#" class="w-10 h-10 flex items-center justify-center rounded-full glassmorphism">
                            <i class="ri-linkedin-fill text-indigo-400"></i>
                        </a>
                    </div>
                </div>

                <div class="w-1/6 mb-8">
                    <h4 class="text-lg font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Explore</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">All Events</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Categories</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Venues</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Artists</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Virtual Tours</a></li>
                    </ul>
                </div>

                <div class="w-1/6 mb-8">
                    <h4 class="text-lg font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">About Us</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Blog</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Careers</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Press</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div class="w-1/6 mb-8">
                    <h4 class="text-lg font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">FAQs</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Ticket Support</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Refund Policy</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Accessibility</a></li>
                    </ul>
                </div>

                <div class="w-1/6 mb-8">
                    <h4 class="text-lg font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Cookie Policy</a></li>
                        <li><a href="#" class="text-indigo-700 hover:text-primary transition-colors">Copyright</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 mt-8 border-t border-indigo-100 flex justify-between items-center">
                <p class="text-indigo-700">© 2025 logo. All rights reserved.</p>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <i class="ri-visa-fill text-indigo-900 text-xl mr-2"></i>
                        <i class="ri-mastercard-fill text-indigo-900 text-xl mr-2"></i>
                        <i class="ri-paypal-fill text-indigo-900 text-xl mr-2"></i>
                        <i class="ri-apple-fill text-indigo-900 text-xl"></i>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script id="calendarInteraction">
        document.addEventListener('DOMContentLoaded', function() {
            const calendarDays = document.querySelectorAll('.calendar-day');

            calendarDays.forEach(day => {
                day.addEventListener('click', function() {
                    // Skip if it's a previous month day
                    if (this.classList.contains('text-indigo-300')) return;

                    // Toggle active state
                    const isActive = this.classList.contains('calendar-day-active');

                    if (!isActive) {
                        this.classList.add('calendar-day-active', 'text-primary', 'font-bold', 'glow');
                        this.classList.remove('text-indigo-700');
                    } else {
                        this.classList.remove('calendar-day-active', 'text-primary', 'font-bold', 'glow');
                        this.classList.add('text-indigo-700');
                    }
                });
            });
        });
    </script>

    <script id="eventCardInteraction">
        document.addEventListener('DOMContentLoaded', function() {
            const eventCards = document.querySelectorAll('.event-card');
            const heartIcons = document.querySelectorAll('.ri-heart-line, .ri-heart-fill');

            // Add hover effect to event cards
            eventCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                    this.style.boxShadow = '0 16px 48px rgba(106, 90, 205, 0.15), inset 0 0 24px rgba(224, 255, 255, 0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });

            // Add heart toggle functionality
            heartIcons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.stopPropagation();

                    if (this.classList.contains('ri-heart-line')) {
                        this.classList.remove('ri-heart-line', 'text-indigo-400');
                        this.classList.add('ri-heart-fill', 'text-red-400');
                    } else {
                        this.classList.remove('ri-heart-fill', 'text-red-400');
                        this.classList.add('ri-heart-line', 'text-indigo-400');
                    }
                });
            });
        });
    </script>

    <script id="navInteraction">
        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('.nav-button');

            navButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('bg-primary')) {
                        this.classList.add('bg-opacity-20');
                        this.style.boxShadow = '0 0 15px rgba(87, 181, 231, 0.3)';
                    }
                });

                button.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('bg-primary')) {
                        this.classList.remove('bg-opacity-20');
                        this.style.boxShadow = '';
                    }
                });
            });
        });
    </script>
</body>
@endsection
