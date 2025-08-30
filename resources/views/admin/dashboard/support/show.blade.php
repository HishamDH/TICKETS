@extends('admin.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-gray-900 text-white rounded-2xl shadow-lg border border-gray-800 p-8">
        <!-- Header -->
        <div class="mb-6 border-b border-gray-700 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <h2 class="text-3xl font-bold">🎫 تفاصيل التذكرة</h2>
                <span class="px-3 py-1 text-sm rounded-full bg-green-700/20 border border-green-600 text-green-300">
                    {{ ucfirst($ticket->status) }}
                </span>
            </div>

            @if ($ticket->status === 'pending')
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.dashboard.support.edit', $ticket->id) }}"
                   class="inline-block px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium shadow transition text-center">
                    💬 الدخول إلى الدردشة مع المستخدم
                </a>
        
                <a href="{{ route('admin.dashboard.support.destroy', $ticket->id) }}"
                   class="inline-block px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow transition text-center">
                    ❌ حذف التذكرة
                </a>
            </div>
        @else
            <a href="{{ route('admin.dashboard.support.edit', $ticket->id) }}">
                <button type="submit"
                        class="inline-block px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium shadow transition">
                    ✅ قبول التذكرة
                </button>
            </a>
        @endif
        
        </div>

        <!-- User Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-800 rounded-lg p-5 border border-gray-700">
                <p class="text-xs uppercase text-gray-400 mb-1">User ID</p>
                <p class="text-lg font-semibold">{{ $ticket->user_id }}</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-5 border border-gray-700">
                <p class="text-xs uppercase text-gray-400 mb-1">User Name</p>
                <p class="text-lg font-semibold">{{ $ticket->user->f_name . ' ' . $ticket->user->l_name }}</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-5 border border-gray-700">
                <p class="text-xs uppercase text-gray-400 mb-1">Subject</p>
                <p class="text-lg font-semibold">{{ $ticket->subject }}</p>
            </div>

            <div class="bg-gray-800 rounded-lg p-5 border border-gray-700">
                <p class="text-xs uppercase text-gray-400 mb-1">Category</p>
                <p class="text-lg font-semibold">{{ $ticket->category }}</p>
            </div>
        </div>

        <!-- Message -->
        <div class="mt-8 bg-gray-800 rounded-lg p-5 border border-gray-700">
            <p class="text-xs uppercase text-gray-400 mb-2">Message</p>
            <p class="text-base leading-relaxed whitespace-pre-wrap break-words">{{ $ticket->message }}</p>
        </div>

        <!-- Attachment -->
        @if ($ticket->attachment)
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-3 border-b border-gray-700 pb-1">📎 Attachment Preview</h3>
                <div class="overflow-hidden rounded-lg border border-gray-700 shadow hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $ticket->attachment) }}" alt="Attachment" class="w-full h-auto object-cover">
                </div>
            </div>
        @else
            <div class="mt-8 bg-gray-800 rounded-lg p-5 border border-gray-700">
                <p class="text-xs uppercase text-gray-400 mb-1">Attachment</p>
                <p class="text-base">None</p>
            </div>
        @endif
    </div>
</div>
@endsection
