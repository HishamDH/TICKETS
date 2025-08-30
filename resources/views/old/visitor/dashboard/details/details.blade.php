@extends('visitor.layouts.app')
@section('title', 'Event Details')

@push('styles')
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

    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
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
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }

    .gallery-img {
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-img:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('sub_content')
<div class="max-w-5xl mx-auto py-12">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">تفاصيل الفعالية</h1>
        <a href="{{ route('visitor.events.index') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-arrow-left-line"></i> العودة للفعاليات
        </a>
    </div>

    <!-- Event Details -->
    <div class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Event Image -->
        <div class="grid grid-cols-4 gap-3">
            <div style="height:180px;" class="imgsContainer col-span-1 overflow-y-scroll overflow-x-hidden">
                @if (!empty($event->gallery))
                @foreach (json_decode($event->gallery,true) as $index => $image)
                <img src="{{ Storage::url($image) }}"
                    alt="صورة المعرض {{ $index + 1 }}"
                    class="rounded-lg shadow gallery-img object-cover w-full h-24 mb-2"
                    onclick="openImageViewer(`{{ $index }}`)">
                @endforeach
                @endif
            </div>
            <div id="imageViewerContainer" class="mb-6 col-span-3">
                <img height="180px" style="max-height: 180px;" id="imageView" src="{{ Storage::url($event->image) }}" alt="صورة الفعالية" class="rounded-lg shadow-lg object-cover">
            </div>
        </div>

        <!-- Info -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $event->name }}</h2>
            <p class="text-gray-600 mb-2"><strong>التاريخ:</strong> {{ $event->date->format('Y-m-d H:i A') }}</p>
            <p class="text-gray-600 mb-2"><strong>الموقع:</strong> {{ $event->location }}</p>
            <p class="text-gray-600 mb-2"><strong>عدد التذاكر:</strong> {{ $event->total_tickets }}</p>
            <p class="text-gray-600 mb-2"><strong>سعر التذكرة:</strong> {{ number_format($event->ticket_price, 2) }} ريال</p>
            <p class="text-gray-600 mb-4"><strong>الحالة:</strong>
                <span class="{{ $event->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $event->status === 'active' ? 'فعالة' : 'منتهية' }}
                </span>
            </p>
        </div>

        <!-- Description -->
        <div class="col-span-2">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Description</h3>
            <p class="text-gray-700">{{ $event->description }}</p>
        </div>

        <!-- Booking Button -->
        <div class="col-span-2 text-right mt-6">
            <form action="{{ route('visitor.tickets.store',['event'=>$event->id]) }}" method="post">
                @csrf
                <button type="submit"
                    class="gradient-button text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold inline-flex items-center">
                    <i class="ri-ticket-line mr-2"></i> book now
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageViewer"
    class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-md flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl max-h-[80vh] w-full mx-4 bg-white rounded-lg overflow-hidden shadow-lg flex flex-col items-center">
        <button onclick="closeImageViewer()"
            class="absolute top-4 right-4 text-black bg-white bg-opacity-70 rounded-full p-3 hover:bg-opacity-90 transition shadow-lg text-2xl font-bold">
            &times;
        </button>
        <img id="viewerImage" src="" alt="عرض الصورة"
            class="max-w-full max-h-[70vh] object-contain select-none">

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

<script>
    const images = @json(json_decode($event -> gallery ?? '[]', true));
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
