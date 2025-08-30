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


<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Activity Widget -->
    <!-- <div class="lg:col-span-1">
        <div
            class="glassmorphism rounded-xl p-6 h-full transition-all duration-300 card-hover">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">Recent Bookings</h2>
                <span class="text-primary text-sm cursor-pointer">View all</span>
            </div>

            <div class="space-y-4">
                <div
                    class="p-3 rounded-lg bg-white bg-opacity-50 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Dubai Jazz Festival</h3>
                            <p class="text-sm text-gray-600">
                                May 28, 2025 • 7:30 PM
                            </p>
                        </div>
                        <span
                            class="status-confirmed text-xs px-3 py-1 rounded-full">Confirmed</span>
                    </div>
                    <div class="flex mt-3 gap-2">
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-qr-code-line ri-sm"></i> View QR
                        </button>
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-file-pdf-line ri-sm"></i> Download PDF
                        </button>
                    </div>
                </div>

                <div
                    class="p-3 rounded-lg bg-white bg-opacity-50 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Riyadh Season Concert</h3>
                            <p class="text-sm text-gray-600">
                                June 5, 2025 • 8:00 PM
                            </p>
                        </div>
                        <span class="status-pending text-xs px-3 py-1 rounded-full">Pending</span>
                    </div>
                    <div class="flex mt-3 gap-2">
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-bank-card-line ri-sm"></i> Complete Payment
                        </button>
                    </div>
                </div>

                <div
                    class="p-3 rounded-lg bg-white bg-opacity-50 border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Cairo Film Festival</h3>
                            <p class="text-sm text-gray-600">
                                May 15, 2025 • 6:00 PM
                            </p>
                        </div>
                        <span class="status-canceled text-xs px-3 py-1 rounded-full">Canceled</span>
                    </div>
                    <div class="flex mt-3 gap-2">
                        <button
                            class="flex items-center justify-center gap-1 text-xs bg-white px-3 py-1.5 rounded-full border border-gray-200 !rounded-button whitespace-nowrap">
                            <i class="ri-refresh-line ri-sm"></i> Rebook
                        </button>
                    </div>
                </div>
            </div>

            <button
                class="w-full mt-6 py-3 text-center gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                View All Bookings
            </button>
        </div>
    </div> -->

    <!-- Featured Events Grid -->
    <div id="events" class="lg:col-span-3">
        <!-- Search Section -->
        <div class="mb-10 flex justify-between">
            <div class="glassmorphism rounded-full p-2 flex items-center w-full max-w-3xl">
                <form action="{{ route('visitor.dashboard') }}" method="GET" class="flex items-center w-full max-w-4xl">
                    <div
                        class="w-10 h-10 flex items-center justify-center text-gray-500">
                        <i class="ri-search-line ri-xl"></i>
                    </div>
                    <input
                        type="text" name="search"
                        placeholder="Search for events..."
                        class="search-bar w-full bg-transparent border-none outline-none px-3 py-2 text-gray-700 placeholder-gray-500" />
                    <button
                        class="gradient-button text-white px-5 mx-3 py-2 rounded-full whitespace-nowrap font-medium">
                        Search
                    </button>
                </form>
            </div>
            <button class="glassmorphism rounded-full px-3 py-2 z-50" id="calender_toggle"><i class="ri-filter-line text-lg"></i></button>

        </div>
        <!-- <h2 class="text-xl font-semibold mb-6">Featured Events</h2> -->
        <div id="cards_conatiner" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Event Card 1 -->
            @foreach($events as $event)
            <a href="{{route('visitor.events.show',$event->id)}}">
                <div class="card-hover glassmorphism p-3 rounded-lg shadow-lg transition-transform">
                    <div>
                        <div
                            class="absolute top-3 left-3 bg-orange-600 text-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $event->category->name }}
                        </div>
                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                        <div
                            class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $event->ticket_price }} SAR
                        </div>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h2>
                    <p class="text-gray-600 mt-2">
                        {{ Str::limit($event->description, 50) }}
                    </p>
                    <p class="text-gray-500 mt-1"><span class="text-black"><i class="ri-calendar-line ri-sm"></i></span> {{ Carbon\Carbon::create($event->date)->diffForHumans() }}</p>
                    <p class="text-gray-500 mt-1"><span class="text-black"><i class="ri-map-pin-line ri-sm"></i></span> <span class="rounded-full px-2 bg-green-200">{{ $event->location }}</span></p>
                    <button
                        class="w-full mt-4 py-2 gradient-button text-white rounded-lg !rounded-button whitespace-nowrap font-medium">
                        Book Now
                    </button>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <!-- Calendar Widget -->
    <div id="calender" class="lg:col-span-1 hidden">
        <div class="glassmorphism rounded-3xl p-6 sticky top-32">
            <div>
                <h3 class="text-xl font-bold text-indigo-900 mb-6 font-['Space_Grotesk']">Event Calendar</h3>
                <button id="calender_toggle_1" class="absolute top-4 mt-3 right-5 decoration-0 text-primary p-0"><i class="ri-close-line text-indigo-400"></i></button>
            </div>
            <form method="GET" action="{{ route('visitor.dashboard') }}">
                <!-- Month selector -->
                <div class="flex justify-between items-center mb-6">
                    <button type="button" id="prevMonth" class="w-8 h-8 flex items-center justify-center rounded-full glassmorphism">
                        <i class="ri-arrow-left-s-line text-indigo-400"></i>
                    </button>
                    <span id="monthYear" class="text-indigo-900 font-medium"></span>
                    <button type="button" id="nextMonth" class="w-8 h-8 flex items-center justify-center rounded-full glassmorphism">
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
                <div id="calendarDays" class="grid grid-cols-7 gap-1 mb-4"></div>
                <!-- Hidden input for selected date -->
                <input type="hidden" name="date" id="selectedDate">

                <!-- Categories -->
                <div class="mt-8">
                    <h4 class="text-md font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Categories</h4>
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

                <!-- Price Range (Double Range Slider) -->
                <div class="filter-sidebar">
                    <h4 class="text-md font-bold text-indigo-900 mb-4 font-['Space_Grotesk']">Price</h4>
                    <!-- 💰 شريط السعر المحسّن -->
                    <div class="filter-group">
                        <div class="price-slider">
                            <div class="progress-bar" id="progress"></div>
                            <div class="range-input">
                                <input type="hidden" id="priceChanged" value="false">
                                <input type="range" id="maxPrice" name="maxPrice" min="50" max="3000" value="1000" step="50">
                                <input type="range" id="minPrice" name="minPrice" min="0" max="3000" value="0" step="50">
                            </div>
                        </div>
                        <div class="price-values mt-3">
                            <span>{{ 'price' }}</span>
                            <span class="price-bubble" id="minPriceBubble">SAR 100</span> -
                            <span class="price-bubble" id="maxPriceBubble">SAR 75</span>
                        </div>
                    </div>

                </div>

                <!-- Filter button -->
                <button type="submit" class="w-full glassmorphism gradient-button mt-6 py-3 rounded-xl text-white font-medium !rounded-button whitespace-nowrap">
                    Filter Events
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
        const calenderBtn = document.getElementById('calender_toggle');
        calenderBtn.classList.toggle('hidden');
        const calender = document.getElementById('calender');
        calender.classList.toggle('hidden');
        const cardsConatiner = document.getElementById('cards_conatiner');
        cardsConatiner.classList.toggle('md:grid-cols-3');
        cardsConatiner.classList.toggle('md:grid-cols-2');
        const events = document.getElementById('events');
        events.classList.toggle('lg:col-span-3');
        events.classList.toggle('lg:col-span-2');
    }

    // Calendar functionality
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

        // Initialize current month and year
        const monthYear = document.getElementById('monthYear');
        const currentDate = new Date();
        monthYear.textContent = currentDate.toLocaleString('default', {
            month: 'long',
            year: 'numeric'
        });

        // Load current month days
        loadMonthDays(currentDate.getFullYear(), currentDate.getMonth());

        document.getElementById('prevMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            monthYear.textContent = currentDate.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            loadMonthDays(currentDate.getFullYear(), currentDate.getMonth());
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            monthYear.textContent = currentDate.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            loadMonthDays(currentDate.getFullYear(), currentDate.getMonth());
        });
    });

    function loadMonthDays(year, month) {
        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const numDays = lastDay.getDate();
        const startDay = firstDay.getDay();

        // Empty slots for previous month
        for (let i = 0; i < startDay; i++) {
            const emptyDay = document.createElement('button');
            emptyDay.classList.add('calendar-day', 'w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'rounded-full', 'text-transparent', 'text-sm');
            calendarDays.appendChild(emptyDay);
        }

        // Days of current month
        for (let day = 1; day <= numDays; day++) {
            const dayButton = document.createElement('button');
            dayButton.textContent = day;
            dayButton.classList.add('calendar-day', 'w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'rounded-full', 'text-indigo-700', 'text-sm');

            dayButton.addEventListener('click', function(e) {
                e.preventDefault(); // منع الحدث الافتراضي

                // إزالة التحديد من كل الأيام
                document.querySelectorAll('.calendar-day-active').forEach(el => {
                    el.classList.remove('calendar-day-active', 'text-primary', 'font-bold', 'glow', 'gradient-button');
                    // el.classList.add('text-indigo-700');
                });

                // تفعيل التحديد لليوم الحالي
                this.classList.add('active', 'glow', 'gradient-button');
                // this.classList.remove('text-indigo-700');

                // تعيين التاريخ المحدد في hidden input
                const selectedDate = new Date(year, month, day);
                const yearStr = selectedDate.getFullYear();
                const monthStr = ('0' + (selectedDate.getMonth() + 1)).slice(-2);
                const dayStr = ('0' + selectedDate.getDate()).slice(-2);
                document.getElementById('selectedDate').value = `${yearStr}-${monthStr}-${dayStr}`;
            });

            calendarDays.appendChild(dayButton);
        }

        // Empty slots for next month
        const endDay = lastDay.getDay();
        for (let i = endDay + 1; i < 7; i++) {
            const emptyDay = document.createElement('button');
            emptyDay.classList.add('calendar-day', 'w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'rounded-full', 'text-transparent', 'text-sm');
            calendarDays.appendChild(emptyDay);
        }
    }
</script>
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
                    this.classList.add('calendar-day-active', 'glow');
                    this.classList.remove('text-indigo-700');
                } else {
                    this.classList.remove('calendar-day-active', 'glow');
                    this.classList.add('text-indigo-700');
                }
            });
        });
    });
</script>
<script>
    const minPrice = document.getElementById("minPrice");
    const maxPrice = document.getElementById("maxPrice");
    const minPriceBubble = document.getElementById("minPriceBubble");
    const maxPriceBubble = document.getElementById("maxPriceBubble");
    const progress = document.getElementById("progress");

    function updatePriceRange() {
        document.getElementById("priceChanged").value = "true";
        let minVal = parseInt(minPrice.value);
        let maxVal = parseInt(maxPrice.value);

        if (minVal >= maxVal) {
            minVal = maxVal - 1;
            minPrice.value = minVal;
        }

        const minPercent = ((minVal - minPrice.min) / (minPrice.max - minPrice.min)) * 100;
        const maxPercent = ((maxVal - minPrice.min) / (minPrice.max - minPrice.min)) * 100;

        progress.style.left = minPercent + "%";
        progress.style.width = (maxPercent - minPercent) + "%";

        minPriceBubble.textContent = `${minVal} SAR`;
        maxPriceBubble.textContent = `${maxVal==3000?'100,000':maxVal} SAR`;

        minPriceBubble.style.left = minPercent + "%";
        maxPriceBubble.style.left = maxPercent + "%";
    }

    minPrice.addEventListener("input", updatePriceRange);
    maxPrice.addEventListener("input", updatePriceRange);

    updatePriceRange();
</script>
@endpush
