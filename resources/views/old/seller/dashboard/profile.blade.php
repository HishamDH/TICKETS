@extends('seller.layouts.app')
@section('title', 'Profile')

@push('styles')
<style>
    profile-section {
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

<div class="max-w-4xl mx-auto py-12">
    <div class="glassmorphism p-8 rounded-3xl">
        <h2 class="text-3xl font-bold mb-8 text-center">Edit @php if($user->role == "restaurant") echo "Restaurant"; elseif($user->role == "seller") echo "Seller"; @endphp Profile</h2>
        <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- صورة المطعم -->
            <div class="mb-6">
                <label class="block text-lg font-medium mb-2">@php if($user->role == "restaurant") echo "Restaurant"; elseif($user->role == "seller") echo "Seller"; @endphp Image</label>
                <div class="profile-section grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="image-container">
                        <div class="event-image-bg" style="background-image: url('{{ Storage::url($additional_data["image"]??'') }}');"></div>
                        <label for="image" title="Change Image">
                            <i class="ri-pencil-line"></i>
                        </label>
                    </div>
                    <input type="file" name="image" id="image" class="hidden" />
                    <div class="profile-details">
                        <h3>{{ $user->name }}</h3>
                        <p>Click pencil icon to change image</p>
                    </div>
                </div>
            </div>

            <!-- اسم المطعم -->
            <div class="mb-6">
                <label class="block text-lg font-medium mb-2">@php if($user->role == "restaurant") echo "Restaurant"; elseif($user->role == "seller") echo "Seller"; @endphp Name</label>
                <input type="text" name="name" value="{{ old('name', $user['name']) }}" class="w-full border rounded-lg p-3">
            </div>
            @if($user->role == 'restaurant')
            <!-- ساعات العمل -->
            <div class="mb-6 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-lg font-medium mb-2">Opening Hour</label>
                    <input type="time" name="open_at" value="{{ old('open_at', $additional_data['open_at']??'') }}" class="w-full border rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-lg font-medium mb-2">Closing Hour</label>
                    <input type="time" name="close_at" value="{{ old('close_at', $additional_data['close_at']??'') }}" class="w-full border rounded-lg p-3">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Max number of chairs</label>
                    <input type="number" min="1" name="chairs_count" value="{{ old('chairs_count', $additional_data['chairs_count']??'1') }}" class="w-full border rounded-lg p-3">
                </div>
                @endif

                <!-- رقم الهاتف -->
                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $additional_data['phone']??'') }}" class="w-full border rounded-lg p-3">
                </div>
                @if($user->role == 'restaurant')
            </div>
            @endif

                <div class="mb-6">
                    <label class="block text-lg font-medium mb-2">Location</label>
                    <input type="text" name="location" value="{{ old('location', $additional_data['location']??'') }}" class="w-full border rounded-lg p-3">
                </div>
                @if($user->role == 'restaurant')
            </div>
            @endif

            <!-- وصف المطعم -->
            <div class="mb-6">
                <label class="block text-lg font-medium mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg p-3">{{ old('description', $additional_data['description']??'') }}</textarea>
            </div>

            <!-- زر الحفظ -->
            <div class="text-center">
                <button type="submit" class="gradient-button text-white font-bold py-3 px-8 rounded-2xl text-lg">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
<!-- سكشن تغيير كلمة المرور -->
<div class="max-w-4xl mx-auto py-12">
    <div class="glassmorphism p-8 rounded-3xl">
        <h2 class="text-2xl font-bold mb-6 text-center">Change Password</h2>
        <form action="{{ route('seller.profile.changePassword') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-lg font-medium mb-2">Current Password</label>
                <input type="password" name="current_password" class="w-full border rounded-lg p-3" required>
            </div>

            <div class="mb-6">
                <label class="block text-lg font-medium mb-2">New Password</label>
                <input type="password" name="new_password" class="w-full border rounded-lg p-3" required>
            </div>

            <div class="mb-6">
                <label class="block text-lg font-medium mb-2">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" class="w-full border rounded-lg p-3" required>
            </div>

            <div class="text-center">
                <button type="submit" class="gradient-button text-white font-bold py-3 px-8 rounded-2xl text-lg">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>

<!-- سكشن حذف الحساب -->
<div class="max-w-4xl mx-auto py-12">
    <div class="glassmorphism p-8 rounded-3xl border border-red-300">
        <h2 class="text-2xl font-bold mb-6 text-center text-red-600">Delete Account</h2>
        <p class="text-center text-gray-700 mb-6">
            Warning: Once you delete your account, there is no going back. Please be certain.
        </p>
        <form id="deleteAccountForm" action="{{ route('seller.profile.delete') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="text-center">
                <button type="button" id="deleteButton" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-2xl text-lg">
                    Delete My Account
                </button>
            </div>
        </form>
    </div>
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

@push('scripts')
<script>
    document.getElementById('deleteButton').addEventListener('click', function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            // cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel', // أضفنا نص زر الإلغاء
            customClass: {
                popup: 'rounded-lg',
                title: 'text-lg font-bold',
                confirmButton: 'px-6 py-2 text-white bg-red-600 rounded-lg text-base font-semibold shadow',
                cancelButton: 'px-6 py-2 bg-gray-600 rounded-lg text-base font-semibold shadow',
            },
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAccountForm').submit();
            }
        });
    });
</script>
@endpush
