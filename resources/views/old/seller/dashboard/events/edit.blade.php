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

    /* الحاوية الكبيرة للـ form */
    .form-container {
        max-width: 720px;
        margin-top: 2rem;
        padding: 2rem;
        background-color: white;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* الحاوية للصورة والنص جنب بعض */
    .profile-section {
        display: flex;
        gap: 2rem;
        align-items: center;
        margin-bottom: 2rem;
    }

    /* الصورة: مستطيل يأخذ نصف عرض الأب */
    .image-container {
        flex: 1 1 50%;
        /* 50% من عرض الحاوية الأب */
        height: 180px;
        /* ارتفاع ثابت */
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
        /* border-radius: 0.75rem; */
    }

    /* أيقونة تعديل الصورة */
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
        transition: background-color 0.3s ease;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-container label:hover {
        background-color: #4f46e5;
    }

    /* نصوص البروفايل تاخذ النصف الثاني */
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

    /* شبكات الفورم */
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
    input[type="datetime-local"],
    select,
    textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="datetime-local"]:focus,
    select:focus,
    textarea:focus {
        border-color: #6366F1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
    }

    button[type="submit"] {
        background-color: #6366F1;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    button[type="submit"]:hover {
        background-color: #4F46E5;
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
        filter: brightness(1.1);
    }
</style>
@endpush

@section('sub_content')
<div class="form-container mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i class="ri-edit-line text-primary text-3xl"></i> Edit Event
    </h2>

    <form action="{{ route('seller.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- قسم الصورة والنص مع بعض --}}
        <div class="profile-section">
            <div class="image-container">
                <div class="event-image-bg @error('image') border-red-400 @enderror" style="background-image: url('{{ Storage::url($event->image) }}');"></div>
                <label for="image" title="Change Image">
                    <i class="ri-pencil-line"></i>
                </label>
            </div>
            @error('image')
            <span class="text-red-400">{{ $message }}</span>
            @enderror
            <input type="file" name="image" id="image" class="hidden" />
            <div class="profile-details">
                <h3>{{ $event->name }}</h3>
                <p>Click pencil icon to change image</p>
                <a href="{{ route('seller.events.gallery',['event'=>$event->id]) }}">change gallery</a>
            </div>
        </div>

        {{-- باقي حقول الفورم --}}
        <div class="form-grid">
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="@error('name') border-red-400 @enderror" value="{{ old('name', $event->name) }}" />
                @error('name')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="category_id">Category</label>
                <select name="category_id" class="@error('category_id') border-red-400 @enderror" id="category_id">
                    <option value="" disabled>Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="date">Date</label>
                <input type="datetime-local" name="date" id="date" class="@error('date') border-red-400 @enderror" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i')) }}" />
                @error('date')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="total_tickets">Total Tickets</label>
                <input type="number" name="total_tickets" id="total_tickets" class="@error('total_tickets') border-red-400 @enderror" value="{{ old('total_tickets', $event->total_tickets) }}" />
                @error('total_tickets')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="ticket_price">Ticket Price</label>
                <input type="number" step="0.01" name="ticket_price" id="ticket_price" class="@error('ticket_price') border-red-400 @enderror" value="{{ old('ticket_price', $event->ticket_price) }}" />
                @error('ticket_price')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="status">Status</label>
                <select name="status" class="@error('status') border-red-400 @enderror" id="status">
                    <option value="active" {{ $event->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $event->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mt-6">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="@error('location') border-red-400 @enderror" value="{{ old('location', $event->location) }}" />
            @error('location')
            <span class="text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-6">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="@error('description') border-red-400 @enderror" rows="4">{{ old('description', $event->description) }}</textarea>
            @error('description')
            <span class="text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-8">
            <button type="submit"
                class="gradient-button px-6 py-3 text-white rounded-lg shadow-md transition hover:translate-y-[-2px] hover:brightness-110 flex items-center gap-2">
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
                // غير خلفية الديف للصورة الجديدة
                document.querySelector('.event-image-bg').style.backgroundImage = `url('${e.target.result}')`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>

@endpush
