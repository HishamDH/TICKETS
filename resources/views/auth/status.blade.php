@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md text-center max-w-md w-full">
        @if ($status == 'pending')
            <svg class="mx-auto mb-4 w-20 h-20 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-2xl font-bold text-yellow-600 mb-2">الحساب قيد المراجعة</h1>
        @elseif ($status == 'rejected')
            <svg class="mx-auto mb-4 w-20 h-20 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
            <h1 class="text-2xl font-bold text-red-600 mb-2">تم رفض الحساب</h1>
        @else
            <svg class="mx-auto mb-4 w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>
            <h1 class="text-2xl font-bold text-green-600 mb-2">تم تفعيل الحساب بنجاح</h1>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <!-- <a href="{{ route('dashboard') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                الذهاب إلى اللوحة
            </a> -->
            <a href="{{ route('home') }}" class="border border-blue-500 text-blue-500 px-6 py-2 rounded hover:bg-blue-50">
                الرجوع للصفحة الرئيسية
            </a>
        </div>
    </div>
</div>
@endsection
