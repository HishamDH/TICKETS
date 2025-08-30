@extends('seller.layouts.app')
@section('title', 'Create Branch')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(106, 90, 205, 0.15);
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
<div class="max-w-5xl mx-auto py-12">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Branch</h1>
        <a href="{{ route('seller.branch.index') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-git-branch-line"></i> Back to Branches
        </a>
    </div>

    <form action="{{ route('seller.branch.store') }}" method="POST" enctype="multipart/form-data"
        class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        {{-- صورة واحدة --}}
        <div class="col-span-2">
            <label for="image" class="block text-gray-700 font-medium mb-2">Branch Image</label>
            <div onclick="document.getElementById('image').click();"
                class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 bg-white hover:bg-gray-50 transition"
                ondragover="event.preventDefault();" ondrop="handleDrop(event);">
                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 32l7-7 7 7M12 20v12a2 2 0 002 2h20a2 2 0 002-2V20M20 12h8m-4-4v16" />
                </svg>
                <span class="text-gray-500">Drag & drop or <span class="text-primary font-semibold underline">browse</span> to upload</span>
                <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                <img id="preview" class="mt-4 max-h-48 rounded shadow hidden" />
            </div>
        </div>

        {{-- اسم الفرع --}}
        <div>
            <label for="name" class="block text-gray-700 font-medium mb-2">Branch Name</label>
            <input type="text" name="name" id="name" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        {{-- الحالة --}}
        <div>
            <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" id="status"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        {{-- عدد الطاولات --}}
        <div>
            <label for="tables" class="block text-gray-700 font-medium mb-2">Number of Tables</label>
            <input type="number" name="tables" id="tables" required min="1"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        {{-- السعر لكل ساعة --}}
        <div>
            <label for="hour_price" class="block text-gray-700 font-medium mb-2">Hourly Price (SAR)</label>
            <input type="number" name="hour_price" id="hour_price" required min="0"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        {{-- وقت الفتح --}}
        <div>
            <label for="open_at" class="block text-gray-700 font-medium mb-2">Opening Time</label>
            <input type="time" name="open_at" id="open_at" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        {{-- وقت الإغلاق --}}
        <div>
            <label for="close_at" class="block text-gray-700 font-medium mb-2">Closing Time</label>
            <input type="time" name="close_at" id="close_at" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        {{-- الموقع --}}
        <div class="col-span-2">
            <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
            <input type="text" name="location" id="location" required
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        {{-- معرض الصور (أكثر من صورة) --}}
        <div class="col-span-2">
            <label for="gallery" class="block text-gray-700 font-medium mb-2">Branch Gallery (Multiple Images)</label>
            <div onclick="document.getElementById('gallery').click();"
                class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 bg-white hover:bg-gray-50 transition"
                ondragover="event.preventDefault();">
                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 32l7-7 7 7M12 20v12a2 2 0 002 2h20a2 2 0 002-2V20M20 12h8m-4-4v16" />
                </svg>
                <span class="text-gray-500">Drag & drop or <span class="text-primary font-semibold underline">browse</span> to upload</span>
                <input type="file" name="gallery[]" id="gallery" multiple accept="image/*" class="hidden" onchange="previewImages(event)">
                <div id="preview-container" class="flex flex-wrap gap-4 mt-4"></div>
            </div>
        </div>

        {{-- زر الإرسال --}}
        <div class="col-span-2 text-center">
            <button type="submit"
                class="gradient-button text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                Create Branch
            </button>
        </div>
    </form>
</div>

{{-- JavaScript --}}
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = ""; // تصفير الصور القديمة

        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = "h-32 w-32 rounded shadow object-cover";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('image').files = files;
            previewImage({ target: { files } });
        }
    }
</script>
@endsection
