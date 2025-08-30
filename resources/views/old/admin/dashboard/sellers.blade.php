@extends('admin.layouts.app')
@section('title', 'Merchants - ')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<style>
    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }
</style>
@endpush

@section('sub_content')
<div class="py-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-6">Merchants</h2>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="shadow-lg rounded-lg glassmorphism overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-100 to-purple-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Shop Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">City</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    @foreach ($sellers as $seller)
                    @php
                        $data = json_decode($seller->additional_data);
                    @endphp

                    <tbody class="bg-white divide-y divide-gray-100 text-gray-800">
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4">{{$seller->id ?? null }}</td>
                            <td class="px-6 py-4">{{$seller->role ?? null }}</td>
                            <td class="px-6 py-4">{{$seller->name ?? null }}</td>
                            <td class="px-6 py-4">{{$data->phone ?? null}}</td>
                            <td class="px-6 py-4">{{$data->location ?? null}}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{route('admin.sellers.update',$seller->id)}}" method="POST">
                                    @method('PUT')
                            <button title="accept" class="inline-flex items-center justify-center text-sm hover:text-white text-green-500 hover:bg-green-600 px-2 py-1 rounded-full transition">
                                <i class="ri-check-line text-base"></i>
                            </button>
                                @csrf
                                </form>
                                <a href="{{ route('admin.sellers.show', $seller->id) }}" class="inline-flex items-center justify-center text-sm hover:text-white text-blue-500 hover:bg-blue-600 px-2 py-1 rounded-full transition">
                                    
                                    
                                <button title="view" class="inline-flex items-center justify-center text-sm hover:text-white text-red-500 hover:bg-red-600 px-2 py-1 rounded-full transition">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </a>

                                <button title="deny" class="inline-flex items-center justify-center text-sm hover:text-white text-red-500 hover:bg-red-600 px-2 py-1 rounded-full transition">
                                    <i class="ri-close-line text-base"></i>
                                </button>


                                
                            </td>
                        </tr>
                        <!-- مزيد من التجار -->
                    </tbody>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
