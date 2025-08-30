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

    .form-container {
        max-width: 720px;
        margin: 2rem auto;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border-radius: 1.5rem;
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .profile-section {
        display: flex;
        gap: 2rem;
        align-items: center;
        margin-bottom: 2rem;
    }

    .image-container {
        flex: 1 1 50%;
        height: 180px;
        position: relative;
        background-color: #f9fafb;
        border: 4px solid #6366F1;
        box-shadow: 0 4px 10px rgba(106, 90, 205, 0.15);
        overflow: hidden;
        border-radius: 0.75rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .event-image-bg {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .image-container label {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background-color: #6366F1;
        color: white;
        padding: 6px 8px;
        border-radius: 6px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        font-size: 1.2rem;
    }

    .image-container label:hover {
        background-color: #4f46e5;
    }

    .profile-details {
        flex: 1 1 50%;
    }

    .profile-details h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.25rem;
    }

    .profile-details p {
        font-size: 0.9rem;
        color: #6B7280;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    input[type="text"],
    input[type="number"],
    input[type="time"],
    select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s ease;
    }

    input:focus,
    select:focus {
        border-color: #6366F1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }
</style>
@endpush

@section('sub_content')
<div class="form-container">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i class="ri-edit-line text-primary text-3xl"></i> Edit Branch
    </h2>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong class="font-bold">Whoops!</strong>
        <span class="block sm:inline">There were some problems with your input.</span>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('seller.branch.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="profile-section">
            <div class="image-container">
                <div class="event-image-bg" style="background-image: url('{{ Storage::url($branch->image) }}');"></div>
                <label for="image" title="Change Image">
                    <i class="ri-pencil-line"></i>
                </label>
            </div>
            <input type="file" name="image" id="image" class="hidden" />
            <div class="profile-details">
                <h3>{{ $branch->name }}</h3>
                <p>Click pencil icon to change image</p>
                <a href="{{route('seller.branch.gallery',$branch)}}">change gallery</a>

            </div>
        </div>
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Gallery</h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                @php
                $gallery = json_decode($branch->gallery ?? '[]', true);
                @endphp

                @foreach ($gallery as $index => $image)
                <div class="relative border rounded-lg p-2 bg-gray-100">
                    <img src="{{ Storage::url($image) }}" class="rounded w-full h-32 object-cover mb-2">

                    <input type="file" name="updated_images[{{ $index }}]" class="block w-full mb-2">

                    <button type="button" onclick="removeImage(this, '{{ $index }}')" class="absolute top-1 right-1 bg-red-600 text-white py-1 px-3 rounded-full">
                        &times;
                    </button>

                    <input type="hidden" name="keep_images[]" value="{{ $image }}">
                </div>
                @endforeach
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">Add New Images:</label>
                <input type="file" name="new_images[]" multiple class="w-full border p-2 rounded">
            </div>
        </div>


        <div class="form-grid">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $branch->name) }}" />
            </div>
            <div>
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="active" {{ $branch->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $branch->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label for="tables">Tables</label>
                <input type="number" name="tables" id="tables" value="{{ old('tables', $branch->tables) }}" />
            </div>

            <div>
                <label for="hour_price">Hour Price</label>
                <input type="number" step="0.01" name="hour_price" id="hour_price" value="{{ old('hour_price', $branch->hour_price) }}" />
            </div>

            <div>
                <label for="open_at">Open At</label>
                <input type="time" name="open_at" id="open_at" value="{{ old('open_at', $branch->open_at) }}" />
            </div>

            <div>
                <label for="close_at">Close At</label>
                <input type="time" name="close_at" id="close_at" value="{{ old('close_at', $branch->close_at) }}" />
            </div>



            {{-- <div>
                <label for="restaurent_id">Restaurant</label>
                <select name="restaurent_id" id="restaurent_id">
                    @foreach($categories as $restaurent)
                    <option value="{{ $restaurent->id }}" {{ $branch->restaurent_id == $restaurent->id ? 'selected' : '' }}>
            {{ $restaurent->name }}
            </option>
            @endforeach
            </select>
        </div> --}}
</div>

<div class="mt-6">
    <label for="location">Location</label>
    <input type="text" name="location" id="location" value="{{ old('location', $branch->location) }}" />
</div>

<div class="mt-8">
    <button type="submit" class="gradient-button">
        <i class="ri-save-line"></i> Save Changes
    </button>
</div>
</form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.event-image-bg').style.backgroundImage = `url('${e.target.result}')`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>
<script>
    function removeImage(button, index) {
        // نخفي العنصر بالكامل من الواجهة
        button.closest('div').remove();

        // نحذف قيمة الصورة من الحقول المرسلة للسيرفر
        const input = document.querySelector(`input[name="keep_images[]"][value="${index}"]`);
        if (input) {
            input.remove();
        }
    }
</script>
@endpush