@extends('admin.layouts.app')
@section('title', 'Dashboard - ')

@push('styles')
<style>
    h2 {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 700;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
        padding: 2.5rem;
        border-radius: 2rem;
    }

    .profile-card {
        display: flex;
        flex-direction: row-reverse; /* RTL: الصورة يسار، النص يمين */
        align-items: flex-start;
        gap: 2rem;
    }

    .profile-image img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 1rem;
        border: 2px solid #ccc;
    }

    .profile-info {
        flex: 1;
    }

    .profile-item {
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .profile-item span {
        font-weight: bold;
        color: #4b5563;
        margin-inline-end: 0.5rem;
    }

    .back-btn {
        display: inline-block;
        margin-top: 2rem;
        padding: 0.6rem 1.5rem;
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        width: 100%;
        color: white;
        border-radius: 0.5rem;
        transition: 0.3s ease;
        text-align: center;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }
</style>
@endpush

@section('sub_content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <div class="glassmorphism">
        <div class="profile-card">
            <!-- صورة البائع -->
            <div class="profile-image">
                <img src="{{ Storage::url($data['image'] ?? 'default.jpg') }}" alt="صورة البائع">
            </div>

            <!-- معلومات البائع -->
            <div class="profile-info">
                <h2 class="text-2xl mb-6 text-center">Seller Information</h2>

                <div class="profile-item">
                    <span>Name:</span> {{ $seller->name }}
                </div>

                <div class="profile-item">
                    <span>Email:</span> {{ $seller->email }}
                </div>

                <div class="profile-item">
                    <span>Phone:</span> {{ $data['phone'] ?? 'غير متوفر' }}
                </div>

                <div class="profile-item">
                    <span>Location:</span> {{ $data['location'] ?? 'غير متوفر' }}
                </div>

                @if(isset($data['address']))
                <div class="profile-item">
                    <span>العنوان:</span> {{ $data['address'] }}
                </div>
                @endif

                <a href="{{ route('admin.dashboard') }}" class="back-btn">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
