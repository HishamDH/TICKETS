@extends('admin.layouts.app')
@section('title', 'Dashboard - ')

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
</style>
@endpush

@section('sub_content')

<div class="max-w-7xl mx-auto py-12">

    {{-- الرصيد العام --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 mb-12 glassmorphism p-12 rounded-3xl text-center card-hover">
        <div>
            <h3 class="text-xl font-semibold mb-3 text-indigo-900">الرصيد المتاح</h3>
            <p class="text-5xl font-bold text-indigo-900">$10,200</p>
            <p class="mt-4 text-sm text-gray-600">الرصيد المعلّق: <strong>$3,500</strong></p>
        </div>
        <div>
            <h3 class="text-xl font-semibold mb-3 text-green-600">الرصيد الكلي</h3>
            <p class="text-5xl font-bold text-green-600">$13,700</p>
            <p class="mt-4 text-sm text-gray-600">آخر تحديث: <strong>قبل 5 دقائق</strong></p>
        </div>
    </div>

    {{-- الأقسام الإحصائية --}}
    <div class="glassmorphism grid p-10 rounded-3xl">
        <h2 class="text-3xl font-bold text-indigo-900 mb-10 text-center">إحصائيات النظام</h2>

        <div class="grid grid-cols-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 text-center">
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">عدد المستخدمين</h4>
                <p class="text-4xl font-bold text-indigo-700">1260</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">عدد المشترين</h4>
                <p class="text-4xl font-bold text-blue-600">874</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">عدد التذاكر</h4>
                <p class="text-4xl font-bold text-purple-700">3,420</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">عدد الطلبات</h4>
                <p class="text-4xl font-bold text-green-700">1,538</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">المستخدمين الجدد</h4>
                <p class="text-4xl font-bold text-teal-700">92</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">طلبات معلقة</h4>
                <p class="text-4xl font-bold text-yellow-600">47</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">فعاليات نشطة</h4>
                <p class="text-4xl font-bold text-pink-600">23</p>
            </div>
            <div class="p-6 rounded-2xl bg-white bg-opacity-60 shadow-md">
                <h4 class="text-lg font-semibold mb-3 text-gray-700">الحجوزات الملغاة</h4>
                <p class="text-4xl font-bold text-red-500">19</p>
            </div>
        </div>
    </div>

</div>

@endsection
