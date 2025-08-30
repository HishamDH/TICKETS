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

    {{-- Balance Summary --}}
    <a href="#">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 mb-12 glassmorphism p-12 rounded-3xl text-center card-hover">
            <div class="">
                <h3 class="text-xl font-semibold mb-3 text-indigo-900">الرصيد القابل للسحب</h3>
                <p class="text-5xl font-bold text-indigo-900">${{ number_format($withdraw_balance, 2) }}</p>
                <p class="mt-4 text-sm text-gray-600">الرصيد المعلق: <strong>${{ number_format($hold_balance, 2) }}</strong></p>
            </div>

            <div class="">
                <h3 class="text-xl font-semibold mb-3 text-green-600">الرصيد الكلي</h3>
                <p class="text-5xl font-bold text-green-600">${{ number_format($total_balance, 2) }}</p>
                <p class="mt-4 text-sm text-gray-600">الرصيد المتاح: <strong>${{ number_format($available_balance, 2) }}</strong></p>
            </div>
        </div>
    </a>

    {{-- Performance Overview --}}
    <div class="glassmorphism p-10 rounded-3xl">
        <h2 class="text-3xl font-bold text-indigo-900 mb-10 text-center">تحليل الأداء العام</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-6 text-center">
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">عدد الفعاليات</h4>
                <p class="text-4xl font-bold text-primary">{{ $total_events }}</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">إجمالي الحجوزات</h4>
                <p class="text-4xl font-bold text-primary">{{ $total_bookings }}</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">الحجوزات الملغاة</h4>
                <p class="text-4xl font-bold text-red-400">{{ $total_canceled }}</p>
            </div>
        </div>

    </div>

</div>

@endsection