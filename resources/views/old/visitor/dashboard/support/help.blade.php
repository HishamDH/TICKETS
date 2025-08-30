@extends('visitor.layouts.app')
@section('title', 'Dashboard - تعبئة النموذج')

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

    .gradient-btn {
        background: linear-gradient(to right, #667eea, #764ba2);
    }

    .gradient-btn:hover {
        background: linear-gradient(to right, #5a67d8, #6b46c1);
    }
</style>
@endpush

@section('sub_content')
<div class="px-4 py-12 max-w-3xl mx-auto">
    <form action="{{ route('visitor.support.store') }}" method="POST"
        class="glassmorphism p-8 rounded-2xl shadow-md w-full card-hover transition-all duration-300">
        @csrf

        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Support form</h2>

        <div class="mb-4">
            <label for="name" class="block mb-2 font-medium text-gray-700">Title </label>
            <input type="text" name="name" id="name" placeholder="Enter title : " required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" placeholder="example@example.com" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
        </div>

        <div class="mb-6">
            <label for="message" class="block mb-2 font-medium text-gray-700">Problem </label>
            <textarea name="message" id="message" rows="4" placeholder="Your message here..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition resize-none"></textarea>
        </div>

        <button type="submit"
            class="w-full gradient-btn text-white py-3 rounded-md font-semibold transition duration-200 shadow-md hover:shadow-lg">إرسال</button>
    </form>
</div>
@endsection
