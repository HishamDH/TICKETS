@extends('seller.layouts.app')
@section('title', 'تعديل صور الجاليري')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    .form-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .gallery-edit {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .gallery-item {
        position: relative;
        background: #fff;
        border: 1px solid #ddd;
        padding: 1rem;
        border-radius: 0.75rem;
        text-align: center;
    }

    .gallery-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .edit-label {
        display: inline-block;
        background: #4F46E5;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        margin-bottom: 0.5rem;
    }

    .gallery-item input[type="file"] {
        display: none;
    }

    .btn-add,
    .btn-save {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 1rem;
    }

    .btn-add:hover,
    .btn-save:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }

    .actions {
        text-align: center;
    }
</style>
@endpush




@section('sub_content')
<div class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="grid grid-cols-4 gap-3">
        <div style="height:190px;" class="imgsContainer col-span-1 overflow-y-scroll overflow-x-hidden">
            @if (!empty($branch->gallery))
            @foreach (json_decode($branch->gallery,true) as $index => $image)
            <img src="{{ Storage::url($image) }}"
                alt="صورة المعرض {{ $index + 1 }}"
                class="rounded-lg shadow gallery-img object-cover w-full h-24 mb-2"
                onclick="openImageViewer(`{{ $index }}`)">
            @endforeach
            @endif
        </div>
        <div id="imageViewerContainer" class="mb-6 col-span-3">
            <img height="190px" style="max-height: 190px;" id="imageView" src="{{ Storage::url($branch->image) }}" alt="صورة الفعالية" class="rounded-lg shadow-lg object-cover">
        </div>
    </div>
    <!-- <div>
        <img src="{{ Storage::url($branch->image) }}" alt="Restaurant Image" class="rounded-lg shadow-lg w-full h-auto object-cover">
    </div> -->
    <div>
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

        <div class="text-right">
            <a href="#"
                class="gradient-button text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold inline-flex items-center">
                <i class="ri-restaurant-line mr-2"></i> احجز طاولة
            </a>
        </div>
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


<script>
// جلب الصور من المتغير المرسل من الباك إند
const images = @json(json_decode($branch -> gallery ?? '[]', true));

let currentIndex = 0;

function openImageViewer(index) {
    currentIndex = index;
    document.getElementById('imageView').src = images[currentIndex] ? `{{ asset('storage') }}/` + images[currentIndex] : '';
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
    document.getElementById('viewerImage').src = `{{ asset('storage') }}/` + images[currentIndex];
}

function nextImage() {
    if (currentIndex < images.length - 1) {
        currentIndex++;
    } else {
        currentIndex = 0; // العودة للأولى
    }
    document.getElementById('viewerImage').src = `{{ asset('storage') }}/` + images[currentIndex];
}
</script>



@endsection