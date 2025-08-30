@extends('visitor.layouts.app')
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

    .gradient-button {
        background: linear-gradient(to right, #6a5acd, #8a2be2);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(106, 90, 205, 0.3);
    }

    .gradient-button:hover {
        background: linear-gradient(to right, #8a2be2, #6a5acd);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(106, 90, 205, 0.4);
    }
</style>
@endpush
@section('sub_content')

<!-- Alpine.js للقائمة المنسدلة -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">تذاكرك</h1>
        <a href="{{ route('visitor.support.create') }}" class="gradient-button text-white px-4 py-2 rounded-md font-semibold shadow-md">
            + إضافة تذكرة جديدة
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($tickets as $ticket)
            <div class="relative glassmorphism rounded-xl p-6 shadow-md card-hover transition duration-300 cursor-pointer" x-data="{ open: false }">

                <!-- النقاط الثلاث في الزاوية اليسرى -->
                <div class="absolute top-4 right-4 z-10">
                    <button @click="open = !open" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        <i class="ri-more-2-fill text-xl"></i>
                    </button>

                    <!-- القائمة المنسدلة -->
                    <div x-show="open" @click.outside="open = false"
                        class="absolute left-0 mt-2 w-36 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50"
                        style="display: none;">
                        {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View</a> --}}
                        <a href="{{route('visitor.support.edit',$ticket->id)}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                        <form method="POST" action="{{route('visitor.support.destroy',$ticket->id)}}" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-100">Delete</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('visitor.support_chat.show', $ticket->id) }}">

                <!-- محتوى التذكرة -->
                <h2 class="text-xl font-bold mb-2 text-indigo-700">
                    {{ $ticket->title ?? 'No Title' }}
                </h2>

                <p class="text-gray-700 mb-4">
                    {{ \Illuminate\Support\Str::limit($ticket->content, 30, '...') ?? 'No description' }}
                </p>

                <div class="text-sm text-gray-500 mb-2">
                    <span class="font-semibold">Email:</span>
                    {{ $ticket->user->email ?? 'N/A' }}
                </div>

                <div class="text-sm text-gray-400">
                    <span class="font-semibold">Created:</span>
                    {{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">No tickets to display.</p>
        @endforelse
    </div>
</div>

@endsection
