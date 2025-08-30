@extends('visitor.layouts.app')
@section('title', 'Dashboard - ')
@push('styles')
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />

<style>
    .imgsContainer {
        scrollbar-width: thin;
        /* للفايرفوكس */
        scrollbar-color: #61B2E5 transparent;
        /* لون المقبض والمسار */

        /* كروم و سفاري و ايدج */
    }

    .imgsContainer::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }

    .imgsContainer::-webkit-scrollbar-track {
        background: transparent;
    }

    .imgsContainer::-webkit-scrollbar-thumb {
        background-color: rgba(100, 100, 100, 0.5);
        border-radius: 10px;
        border: 2px solid transparent;
        background-clip: content-box;
    }

    .imgsContainer::-webkit-scrollbar-thumb:hover {
        background-color: rgba(100, 100, 100, 0.8);
    }

    .gallery-img {
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .gallery-img:hover {
        transform: scale(1.05);
    }

    .gallery-img:active {
        transform: scale(0.95);
    }

    .gallery-img:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(87, 181, 231, 0.5);
    }

    .gallery-img:focus-visible {
        outline: none;
        box-shadow: 0 0 0 2px rgba(87, 181, 231, 0.5);
    }

    .gallery-img:focus:not(:focus-visible) {
        box-shadow: none;
    }

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

    /* input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    } */

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
<div class="max-w-5xl mx-auto py-12">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Restaurant Details</h1>
        <a href="{{  route('visitor.restaurent.index') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-arrow-left-line"></i> Back to Restaurants
        </a>
    </div>

    <div class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="grid grid-cols-4 gap-3">
            <div style="height:190px;" @if(empty($branch->gallery) || $branch->gallery == "[]") hidden @endif class="imgsContainer col-span-1 overflow-y-scroll overflow-x-hidden">
                @if (!empty($branch->gallery))
                @foreach (json_decode($branch->gallery,true) as $index => $image)
                <img src="{{ Storage::url($image) }}"
                    alt="صورة المعرض {{ $index + 1 }}"
                    class="rounded-lg shadow gallery-img object-cover w-full h-24 mb-2"
                    onclick="openImageViewer({{ $index }})">
                @endforeach
                @endif
            </div>
            <div id="imageViewerContainer" class="mb-6 @if (empty($branch->gallery) || $branch->gallery == "[]") col-span-4 @else col-span-3 @endif">
                {{-- <img height="190px" style="max-height: 190px;" id="imageView" src="{{ asset('storage/' . $branch->image) }}" alt="صورة الفعالية" class="rounded-lg shadow-lg object-cover"> --}}
                <img height="190px" style="max-height: 190px;" id="imageView" src="{{ Storage::url($branch->image) }}" alt="صورة الفعالية" class="rounded-lg shadow-lg object-cover">
            </div>
        </div>
        <!-- <div>
            <img src="{{ Storage::url($branch->image) }}" alt="Restaurant Image" class="rounded-lg shadow-lg w-full h-auto object-cover">
        </div> -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4"></h2>
            <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $branch->name }}</p>
            <p class="text-gray-600 mb-2"><strong>Branch:</strong> {{ $branch->location }}</p>
            <p class="text-gray-600 mb-2"><strong>Average Price:</strong> SAR {{ number_format($branch->hour_price, 2) }}</p>
            <p class="text-gray-600 mb-2"><strong>Rating:</strong> ⭐ {{ number_format($branch->rating, 1) }} / 5</p>
            <p class="text-gray-600 mb-4"><strong>Status:</strong>
                <span class="{{ $branch->status === 'open' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($branch->status) }}
                </span>
            </p>
        </div>
        <div class="col-span-2">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Description</h3>
            <p class="text-gray-700 mb-6">{{ $branch->description }}</p>
            <div class="max-w-5xl mx-auto my-12 glassmorphism p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6">نموذج حجز طاولة</h2>

                <!-- الفورم -->
                <form id="reservation-form" action="{{ route('visitor.reservation.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8" method="POST">
                    @csrf
                    <input type="hidden" name="branch_id" value="{{ $branch->id }}">

                    <div>
                        <label for="reservation_date" class="block font-medium text-gray-700 mb-1">select date</label>
                        <input type="date" id="reservation_date" name="reservation_date" class="w-full p-2 border rounded" required>
                    </div>
                    <div>
                        <label for="start_time" class="block font-medium text-gray-700 mb-1">from</label>
                        <input type="time" id="start_time" name="start_time" class="w-full p-2 border rounded">
                        <small id="availability-message" class="text-sm font-medium mt-1"></small>
                    </div>

                    <div>
                        <label for="end_time" class="block font-medium text-gray-700 mb-1">to</label>
                        <input type="time" id="end_time" name="end_time" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="chairs" class="block font-medium text-gray-700 mb-1">chairs</label>
                        <input type="number" min="1" value="1" max="{{ json_decode($branch->restaurant->additional_data,true)['chairs_count'] }}" id="chairs" name="chairs" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        {{-- <a href="{{ route('visitor.reservation.store', $branch->id) }}" class="gradient-button text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold inline-flex items-center"> --}}
                        <button type="submit" class="gradient-button text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold inline-flex items-center">

                            <i class="ri-restaurant-line mr-2"></i> book now
                        </button>
                        {{-- </a> --}}
                    </div>
                </form>


        </div>
    </div>
</div>

<!-- <div class="max-w-7xl mx-auto mt-12 px-4">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">📷 صور توضيحية</h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach (json_decode($branch->gallery ?? '[]', true) as $index => $image)
            <div class="cursor-pointer">
                <img src="{{ Storage::url($image) }}"
                     alt="صورة"
                     onclick="openImageViewer({{ $index }})"
                     class="rounded-lg shadow-md object-cover w-full h-32 sm:h-40 md:h-48 hover:scale-105 transition-transform duration-300">
            </div>
        @endforeach
    </div>
</div> -->

<!-- Image Viewer Modal -->
<div id="imageViewer"
    class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-md flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl max-h-[80vh] w-full mx-4 bg-white rounded-lg overflow-hidden shadow-lg flex flex-col items-center">
        <!-- Close Button -->
        <button onclick="closeImageViewer()"
            class="absolute top-4 right-4 text-black bg-white bg-opacity-70 rounded-full p-3 hover:bg-opacity-90 transition shadow-lg text-2xl font-bold">
            &#10005;
        </button>

        <!-- Image Display -->
        <img id="viewerImage" src="" alt="عرض الصورة"
            class="max-w-full max-h-[70vh] object-contain select-none">

        <!-- Navigation Buttons -->
        <div class="flex justify-between w-full bg-white bg-opacity-70 p-4">
            <button onclick="previousImage()"
                class="text-black bg-white bg-opacity-80 px-6 py-3 rounded shadow hover:bg-opacity-100 transition font-semibold text-lg">
                السابق
            </button>
            <button onclick="nextImage()"
                class="text-black bg-white bg-opacity-80 px-6 py-3 rounded shadow hover:bg-opacity-100 transition font-semibold text-lg">
                التالي
            </button>
        </div>
    </div>
</div>

{{--
<script>
    // جلب الصور من المتغير المرسل من الباك إند
    const images = @json(json_decode($branch -> gallery ?? '[]', true));

    let currentIndex = 0;

    function openImageViewer(index) {
        currentIndex = index;
        document.getElementById('imageView').src = images[currentIndex] ? {
            {
                asset('storage')
            }
        }
        / + images[currentIndex] : '';
        // document.getElementById('imageViewer').classList.remove('hidden');
    }

    function closeImageViewer() {
        document.getElementById('imageViewer').classList.add('hidden');
    }

    function previousImage() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = images.length - 1; // رجوع للصورة الأخيرة
        }
        document.getElementById('viewerImage').src = {
            {
                asset('storage')
            }
        }
        / + images[currentIndex];
    }

    function nextImage() {
        if (currentIndex < images.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // العودة للأولى
        }
        document.getElementById('viewerImage').src = {
            {
                asset('storage')
            }
        } + images[currentIndex];
    }
</script> --}}
<!-- <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script> -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startTimeInput = document.getElementById("start_time");
        const endTimeInput = document.getElementById("end_time");
        const dateInput = document.getElementById("reservation_date");
        const message = document.getElementById("availability-message");

        startTimeInput.addEventListener("change", function () {
            checkAvailability();
        });

        endTimeInput.addEventListener("change", function () {
            checkAvailability();
        });

        dateInput.addEventListener("change", function () {
            checkAvailability();
        });

        function checkAvailability() {
            const date = dateInput.value;
            const startTime = startTimeInput.value;
            const endTime = endTimeInput.value;

            if (!date || !startTime || !endTime) return;

            fetch(`/visitor/check-availability-full`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    branch_id: {{ $branch->id }},
                    date: date,
                    start_time: startTime,
                    end_time: endTime
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.available) {
                    message.textContent = '✅ هذا الوقت متاح بالكامل للحجز';
                    message.style.color = 'green';
                } else {
                    message.textContent = `❌ غير متاح - أقرب وقت مناسب: ${data.next_available}`;
                    message.style.color = 'red';
                }
            })
            .catch(err => {
                console.error("خطأ في جلب التوافر:", err);
            });
        }
    });

</script>
<script>
    const images = @json(json_decode($branch->gallery ?? '[]', true));
    let currentIndex = 0;

    function openImageViewer(index) {
        currentIndex = index;
        document.getElementById('imageView').src = `{{ asset('storage') }}/` + images[currentIndex];
        // document.getElementById('imageViewer').classList.remove('hidden');
    }

    function closeImageViewer() {
        document.getElementById('imageViewer').classList.add('hidden');
    }

    function previousImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        document.getElementById('viewerImage').src = `{{ asset('storage') }}/` + images[currentIndex];
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        document.getElementById('viewerImage').src = `{{ asset('storage') }}/` + images[currentIndex];
    }
</script>

@endsection
