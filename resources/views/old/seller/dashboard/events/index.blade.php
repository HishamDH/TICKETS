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

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Events</h1>
        <a href="{{ route('seller.events.create') }}" class="gradient-button text-white px-4 py-2 rounded-lg shadow-md">
            <i class="ri-add-line"></i> Create Event
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div class="card-hover glassmorphism p-3 rounded-lg shadow-lg transition-transform">
            <div>
                <div
                    class="absolute top-3 left-3 bg-orange-600 text-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $event->category->name }}
                </div>
                <img src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                <div
                    class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $event->total_tickets . ' ticket | '.$event->ticket_price }} SAR
                </div>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $event->name }}</h2>
            <p class="text-gray-600 mt-2">
                {{ Str::limit($event->description, 50) }}
            </p>
            <p class="text-gray-500 mt-1"><span class="text-black"><i class="ri-calendar-line ri-sm"></i></span> {{ Carbon\Carbon::create($event->date)->diffForHumans() }}</p>
            <p class="text-gray-500 mt-1"><span class="text-black"><i class="ri-map-pin-line ri-sm"></i></span> <span class="rounded-full px-2 bg-green-200">{{ $event->location }}</span></p>
            <div class="mt-4 flex justify-between items-center">
                <a href="{{ route('seller.events.edit', $event->id) }}" class="bg-blue-600 text-white rounded px-3 py-2 hover:bg-blue-900"><i class="ri-edit-line text-lg"></i></a>
                <form action="{{ route('seller.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white rounded px-3 py-2 hover:bg-red-900 hover:underline"><i class="ri-delete-bin-line text-lg"></i></button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection
