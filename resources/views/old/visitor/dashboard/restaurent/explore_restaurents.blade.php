@extends('visitor.layouts.app')
@section('title', 'Dashboard - ')
@push('styles')
<style>
    .price-slider {
        position: relative;
        width: 100%;
        height: 6px;
        background: #ddd;
        border-radius: 5px;
    }

    .range-input {
        position: relative;
        width: 100%;
    }

    .range-input input {
        position: absolute;
        width: 100%;
        top: -5px;
        z-index: 10;
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        pointer-events: none;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        background: #ffffff;
        border: 1px solid #007bff;
        border-radius: 50%;
        cursor: pointer;
        pointer-events: all;
        position: relative;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }

    .progress-bar {
        position: absolute;
        height: 6px;
        background: #5b91cf;
        border-radius: 5px;
        z-index: 1;
    }

    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(87, 181, 231, 0.05) 50%, rgba(177, 156, 217, 0.1) 100%);
        min-height: 100vh;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .neumorphism {
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.05),
            -5px -5px 15px rgba(255, 255, 255, 0.8);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(87, 181, 231, 0.1);
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(87, 181, 231, 0.5) 0%, rgba(177, 156, 217, 0.5) 100%);
        pointer-events: none;
        opacity: 0.2;
    }

    .search-bar:focus {
        box-shadow: 0 0 0 3px rgba(87, 181, 231, 0.3);
    }

    .status-confirmed {
        background-color: rgba(34, 197, 94, 0.2);
        color: rgb(34, 197, 94);
    }

    .status-pending {
        background-color: rgba(234, 179, 8, 0.2);
        color: rgb(234, 179, 8);
    }

    .status-canceled {
        background-color: rgba(239, 68, 68, 0.2);
        color: rgb(239, 68, 68);
    }

    .carousel {
        scroll-snap-type: x mandatory;
        scrollbar-width: none;
    }

    .carousel::-webkit-scrollbar {
        display: none;
    }

    .carousel-item {
        scroll-snap-align: start;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }
</style>
@endpush



@section('sub_content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div id="restaurants" class="lg:col-span-3">
        <!-- Search Section -->
        <div class="mb-10 flex justify-between">
            <div class="glassmorphism rounded-full p-2 flex items-center w-full max-w-3xl">
                <form action="{{ route('visitor.restaurent.index') }}" method="GET" class="flex items-center w-full max-w-4xl">
                    <div
                        class="w-10 h-10 flex items-center justify-center text-gray-500">
                        <i class="ri-search-line ri-xl"></i>
                    </div>
                    <input
                        type="text" name="search"
                        placeholder="Search for restaurent, location..."
                        class="search-bar w-full bg-transparent border-none outline-none px-3 py-2 text-gray-700 placeholder-gray-500" />
                    <button
                        class="gradient-button text-white px-5 mx-3 py-2 rounded-full whitespace-nowrap font-medium">
                        Search
                    </button>
                </form>
            </div>
            <button class="glassmorphism rounded-full px-3 py-2 z-50" id="calender_toggle"><i class="ri-filter-line text-lg"></i></button>
        </div>

        <div id="cards_container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($restaurants as $restaurant)

            @php
            $data = json_decode($restaurant->additional_data, true);
            $formatted_y = \Carbon\Carbon::parse($data['open_at']??'');
            $formatted_h = \Carbon\Carbon::parse($data['close_at']??'');
            @endphp



            <div class="card-hover glassmorphism p-3 rounded-lg shadow-lg transition-transform">
                <div>

                    @if($formatted_y <= now() && $formatted_h >= now())
                        <div class="absolute top-3 left-3 bg-green-600 text-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                            Open
                        </div>
                        @else
                        <div class="absolute top-3 left-3 bg-red-600 text-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                            Closed
                        </div>
                        @endif
                        <img src="{{ Storage::url($data['image']) }}" alt="{{ $restaurant->name }}" class="w-full h-48 object-cover rounded-lg mb-4">

                </div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $restaurant->name }}</h2>
                <p class="text-gray-500 mt-1">
                    <i class="ri-time-line"></i> {{ $formatted_y->format('g:i A') }} - {{ $formatted_h->format('g:i A')}}
                </p>
                <a href="{{ route('visitor.restaurent.show', $restaurant->id) }}">
                    <button class="w-full mt-4 py-2 gradient-button text-white rounded-lg whitespace-nowrap font-medium">
                        Book a Table
                    </button>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <div id="calender" class="lg:col-span-1 hidden">
        <div class="glassmorphism rounded-3xl p-6 sticky top-32">
            <form method="GET" action="{{ route('visitor.restaurent.index') }}">
                <div>
                    <h4 class="text-md font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Categories</h4>
                    <button id="calender_toggle_1" class="absolute top-4 mt-3 right-5 decoration-0 text-primary p-0"><i class="ri-close-line text-indigo-400"></i></button>
                </div>
                <!-- Categories -->
                <div class="">
                    <div class="flex flex-col gap-2 mb-4">
                        @foreach ($categories as $category)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                class="form-checkbox text-indigo-600 rounded focus:ring-indigo-500"
                                {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}>
                            <span class="text-sm text-indigo-800">{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>


                <!-- Filter button -->
                <button type="submit" class="w-full glassmorphism gradient-button mt-6 py-3 rounded-xl text-white font-medium !rounded-button whitespace-nowrap">
                    Filter Restaurents
                </button>
            </form>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script id="particles-animation">
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById("particles-container");
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement("div");
            particle.classList.add("particle");

            // Random size between 5px and 15px
            const size = Math.random() * 10 + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;

            // Random position
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;

            // Random opacity
            particle.style.opacity = Math.random() * 0.2 + 0.1;

            // Animation
            const duration = Math.random() * 20 + 10;
            const delay = Math.random() * 5;

            particle.style.animation = `float ${duration}s ease-in-out ${delay}s infinite`;

            container.appendChild(particle);
        }

        // Add keyframes for floating animation
        const style = document.createElement("style");
        style.textContent = `
                      @keyframes float {
                          0% {
                              transform: translate(0, 0);
                          }
                          50% {
                              transform: translate(${Math.random() * 30 - 15}px, ${Math.random() * 30 - 15}px);
                          }
                          100% {
                              transform: translate(0, 0);
                          }
                      }
                  `;
        document.head.appendChild(style);
    });
    document.getElementById('calender_toggle_1').addEventListener('click', function() {
        calenderToggle();
    });
    document.getElementById('calender_toggle').addEventListener('click', function() {
        calenderToggle();
    });

    function calenderToggle() {
        console.log('hi');

        const calenderBtn = document.getElementById('calender_toggle');
        calenderBtn.classList.toggle('hidden');
        const calender = document.getElementById('calender');
        calender.classList.toggle('hidden');
        const cardsConatiner = document.getElementById('cards_container');
        cardsConatiner.classList.toggle('md:grid-cols-3');
        cardsConatiner.classList.toggle('md:grid-cols-2');
        const restaurants = document.getElementById('restaurants');
        restaurants.classList.toggle('lg:col-span-3');
        restaurants.classList.toggle('lg:col-span-2');
    }
</script>
@endpush
