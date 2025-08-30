@extends('seller.layouts.app')
@section('title', 'Dashboard - ')

@push('styles')
    <style>
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

    <div class="max-w-7xl mx-auto py-12">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Create Event</h1>
            <a href="{{ route('seller.events.index') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
                <i class="ri-arrow-left-line"></i> Back to Events
            </a>
        </div>

        <form action="{{ route('seller.events.store') }}" method="POST"
            class="glassmorphism p-10 rounded-lg shadow-lg grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3 col-span-2">
                <label for="image" class="block text-gray-700 font-medium mb-2">Event Image</label>
                <div class="col-span-2">
                    <div onclick="document.getElementById('image').click();"
                        class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed @error('image') border-red-400 @else border-gray-300 @enderror rounded-lg p-6 bg-white hover:bg-gray-50 transition"
                        ondragover="event.preventDefault();" ondrop="handleDrop(event);">
                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 32l7-7 7 7M12 20v12a2 2 0 002 2h20a2 2 0 002-2V20M20 12h8m-4-4v16" />
                        </svg>
                        <span class="text-gray-500">Drag & drop or <span
                                class="text-primary font-semibold underline">browse</span> to upload</span>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden" required
                            onchange="previewImage(event)">
                        <img id="preview" class="mt-4 max-h-48 rounded shadow hidden" />
                    </div>
                    @error('image')
                        <span class="text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            {{-- معرض الصور (أكثر من صورة) --}}
            <div class="mb-3 col-span-2">
                <label for="gallery" class="block text-gray-700 font-medium mb-2">event Gallery (Multiple Images)</label>
                <div onclick="document.getElementById('gallery').click();"
                    class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed @error('gallery') border-red-400 @else border-gray-300 @enderror rounded-lg p-6 bg-white hover:bg-gray-50 transition"
                    ondragover="event.preventDefault();">
                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 32l7-7 7 7M12 20v12a2 2 0 002 2h20a2 2 0 002-2V20M20 12h8m-4-4v16" />
                    </svg>
                    <span class="text-gray-500">Drag & drop or <span
                            class="text-primary font-semibold underline">browse</span> to upload</span>
                    <input type="file" name="gallery[]" id="gallery" multiple accept="image/*" class="hidden"
                        onchange="previewImages(event)">
                    <div id="preview-container" class="flex flex-wrap gap-4 mt-4"></div>
                </div>
                @error('gallery')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="block text-gray-700 font-medium mb-2">Event Name</label>
                <input type="text" name="name" id="name"
                    class="w-full p-3 border @error('name') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                @error('name')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="date" class="block text-gray-700 font-medium mb-2">Event Date</label>
                <!-- <input type="datetime-local" name="" id=""> -->
                <input type="datetime-local" name="date" id="date" min="{{ now()->format('Y-m-d\TH:i') }}"
                    class="w-full p-3 border @error('date') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                @error('date')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 col-span-2">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full p-3 border @error('description') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required></textarea>
                @error('description')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <!-- categories -->
            <div class="mb-3">
                <label for="category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full p-4 border @error('category_id') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                    <option value="" @selected(old('category_id',-1) == -1) disabled>Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id',-1)==$category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                <input type="text" name="location" id="location"
                    class="w-full p-3 border @error('location') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                @error('location')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <!-- total tickets -->
            <div class="mb-3">
                <label for="total_tickets" class="block text-gray-700 font-medium mb-2">Total Tickets</label>
                <input type="number" name="total_tickets" id="total_tickets" min="1"
                    class="w-full p-3 border @error('total_tickets') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                @error('total_tickets')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ticket_price" class="block text-gray-700 font-medium mb-2">Ticket Price</label>
                <div class="relative">
                    <span class="absolute left-4 top-6 -translate-y-1/2 text-gray-500 font-semibold">SAR</span>
                    <input type="number" name="ticket_price" id="ticket_price" min="0"
                        class="w-full p-3 pl-16 border @error('ticket_price') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                        style="direction: ltr; padding-left: 4rem;" required>
                    @error('ticket_price')
                        <span class="text-red-400">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- status -->
            <div class="mb-3 col-span-2">
                <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                <select name="status" id="status"
                    class="w-full p-3 border @error('status') border-red-400 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="gradient-button text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300 me-auto col-span-2">
                Create Event
            </button>
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
                previewImage({
                    target: {
                        files
                    }
                });
            }
        }
    </script>
@endsection
