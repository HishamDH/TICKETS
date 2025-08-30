<div class="relative" wire:poll.5s>
    <!-- Bell Button -->
    <button
        wire:click="toggleList"
        class="relative text-slate-600 hover:text-orange-500 focus:outline-none"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
        </svg>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex items-center justify-center h-5 w-5 text-[10px] font-bold rounded-full bg-red-500 text-white">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown List -->
    @if ($showList)
        <div class="absolute left-0 mt-2 w-80 bg-white border border-slate-200 rounded-lg shadow-lg z-50">
            <div class="p-3 border-b text-sm font-bold text-slate-700">
                📬 إشعاراتك
            </div>
            <ul class="max-h-64 overflow-y-auto divide-y">
                @forelse ($notifications as $notif)
                    <li class="p-3 hover:bg-gray-50">
                        <div class="font-semibold text-sm text-purple-700">{{ $notif->subject ?? 'بدون عنوان' }}</div>
                        <div class="text-gray-700 text-sm">{!! $notif->message !!}</div>
                        @if (isset($notif->additional_data['link']))
                            <a href="{{ $notif->additional_data['link'] }}" class="inline-block mt-1 text-blue-600 underline text-sm">تفاصيل</a>
                        @endif
                        <div class="text-[10px] text-gray-400">{{ $notif->created_at->diffForHumans() }}</div>
                    </li>
                @empty
                    <li class="p-3 text-gray-500 text-sm">لا توجد إشعارات جديدة.</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
