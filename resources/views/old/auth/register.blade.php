@extends('layouts.app')
@section('title','register - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(106, 90, 205, 0.1);
    }
</style>
@endpush

@section('content')

<body class="min-h-screen flex items-center justify-center px-4 py-10">
    <nav class="fixed top-0 left-0 w-full z-50 px-8 py-6 flex justify-between items-center">
        <h1 class="text-3xl font-['Pacifico'] text-primary">{{ LoadConfig()->setup->name ?? null  }}</h1>
    </nav>

    <div class="max-w-4xl w-full mx-auto">
        <div class="glassmorphism p-10 rounded-3xl">
            <h2 class="text-3xl font-bold text-indigo-900 mb-6">Create Account</h2>

            <form class="space-y-5" method="POST" action="{{ route('signup') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Full Name <span class="text-red-600">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('name')) border-red-600 @else border-blue-200 @endif" required />
                        @error('name')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Email <span class="text-red-600">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('email')) border-red-600 @else border-blue-200 @endif" required />
                        @error('email')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Password <span class="text-red-600">*</span></label>
                        <input type="password" name="password" class="w-full px-4 py-3 rounded-lg border @if($errors->has('password')) border-red-600 @else border-blue-200 @endif" required />
                        @error('password')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Password Confirmation <span class="text-red-600">*</span></label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-lg border border-blue-200" required />
                    </div>

                    <div class="col-span-2">
                        <label class="block mb-1 text-indigo-700 font-medium">type <span class="text-red-600">*</span></label>
                        <select id="role" name="role" class="w-full px-4 py-3 rounded-lg border border-blue-200" required>
                            <option value="visitor" @selected(old('role')=='visitor')>visitor</option>
                            <option value="seller" @selected(old('role')=='events')>events</option>
                            <option value="restaurant" @selected(old('role')=='restaurant')>restaurant </option>
                        </select>
                    </div>
                </div>

                <!-- Restaurant Only Fields -->
                <div id="restaurant-fields" @if (old('role')==='restaurant' || request()->input('role') === 'restaurant') style="display: grid;" @else style="display: none;" @endif class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('phone')) border-red-600 @else border-blue-200 @endif" />
                        @error('phone')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">max number of chairs on the table <span class="text-red-600">*</span></label>
                        <input type="text" name="chairs_count" value="{{ old('chairs_count') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('chairs_count')) border-red-600 @else border-blue-200 @endif" />
                        @error('chairs_count')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-1 text-indigo-700 font-medium">location</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('location')) border-red-600 @else border-blue-200 @endif" />
                        @error('location')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block mb-1 text-indigo-700 font-medium">Description</label>
                        <textarea name="description" value="{{ old('description') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('description')) border-red-600 @else border-blue-200 @endif"></textarea>
                        @error('description')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Open At <span class="text-red-600">*</span></label>
                        <input type="time" name="open_at" value="{{ old('open_at') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('open_at')) border-red-600 @else border-blue-200 @endif" />
                        @error('open_at')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 text-indigo-700 font-medium">Close At <span class="text-red-600">*</span></label>
                        <input type="time" name="close_at" value="{{ old('close_at') }}" class="w-full px-4 py-3 rounded-lg border @if($errors->has('close_at')) border-red-600 @else border-blue-200 @endif" />
                        @error('close_at')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="mb-3 col-span-2">
                        <label for="image" class="block text-indigo-700 font-medium mb-2">Image <span class="text-red-600">*</span></label>
                        <div class="col-span-2">
                            <div onclick="document.getElementById('image').click();"
                                class="cursor-pointer flex flex-col items-center justify-center border-2 border-dashed @if($errors->has('image')) border-red-600 @else border-gray-300 @endif rounded-lg p-6 bg-white hover:bg-gray-50 transition"
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
                        @error('image')
                            <label for="name" class="text-red-600">{{ $message }}</label>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg text-lg font-semibold mt-6">Sign Up</button>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-indigo-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span style="background-color: #EEF2FC;" class="bg-opacity-50 px-4 text-indigo-500 font-semibold">OR</span>
                    </div>
                </div>

                <a href="#" class="w-full flex items-center justify-center bg-white bg-opacity-80 border border-indigo-200 text-indigo-900 font-medium py-3 rounded-lg hover:bg-opacity-100 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-6 h-6 mr-3" alt="Google Logo">
                    Continue with Google
                </a>

                <p class="text-center text-indigo-700 mt-4">Already have an account?
                    <a href="{{ route('login') }}" class="text-primary font-semibold">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const restaurantFields = document.getElementById('restaurant-fields');

        roleSelect.addEventListener('change', function() {
            if (roleSelect.value === 'restaurant') {
                restaurantFields.style.display = 'grid';
            } else {
                restaurantFields.style.display = 'none';
            }
        });
    });
</script>
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
