<div class="flex h-screen overflow-hidden bg-gray-100">
    <!-- Sidebar -->
    <div class="w-full md:w-1/3 max-w-xs bg-white border-r shadow p-4 flex flex-col">
        <h2 class="text-lg font-bold mb-4 text-blue-600 border-b pb-2">قائمة المحادثات</h2>
        <ul class="space-y-2 flex-1 overflow-y-auto">
            @forelse ($chats as $chat)
                @php
                    $user = $chat->merchant;
                    $name = $user->f_name . ' ' . ($user->l_name ?? '');
                    $profilePicture = $user->additional_data['profile_picture'] ?? 'default.png';
                    $profilePictureUrl = asset('storage/' . $profilePicture);
                    $lastMessage = $chat->messages->sortByDesc('created_at')->first()->message ?? 'لا توجد رسائل بعد';
                @endphp
                <li>
                    <button
                        wire:click="$set('chat_id', {{ $chat->id }})"
                        class="flex items-center gap-3 w-full text-right p-3 rounded-lg transition {{ $chat_id === $chat->id ? 'bg-blue-50 border border-blue-300' : 'hover:bg-gray-100' }}">
                        <img src="{{ $profilePictureUrl }}" class="w-10 h-10 rounded-full object-cover border">
                        <div class="flex flex-col text-right flex-1">
                            <span class="font-bold text-slate-800 truncate">{{ $name }}</span>
                            <span class="text-sm text-gray-500 truncate">{{ $lastMessage }}</span>
                        </div>
                    </button>
                </li>
            @empty
                <li class="text-center text-gray-400 text-sm">لا توجد محادثات</li>
            @endforelse
        </ul>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col bg-white p-4">
        @if ($chat_id)
            <h2 class="text-lg font-bold text-blue-600 border-b pb-2 mb-4">المحادثة رقم #{{ $chat_id }}</h2>

            <!-- Messages -->
            <div id="chatBox" class="flex-1 overflow-y-auto space-y-4 p-2 bg-gray-50 rounded shadow-inner">

                @php
                    $chatData = $currentChat->additional_data;
                    if (is_string($chatData)) {
                        $chatData = json_decode($chatData, true);
                    }
                    $chatData = is_array($chatData) ? $chatData : [];
                @endphp

                @if (!empty($chatData))
                    <div class="mb-4 p-4 rounded-lg bg-white border shadow-sm space-y-3 animate-fade-in-down">
                        @if (!empty($currentChat->description))
                            <div>
                                <h3 class="font-bold text-gray-700 mb-1">الوصف:</h3>
                                <p class="text-sm text-gray-600 whitespace-pre-wrap">
                                    {{ $currentChat->description }}
                                </p>
                            </div>
                        @endif

                        @if (!empty($currentChat->attachment))
                            <div>
                                <h3 class="font-bold text-gray-700 mb-1">مرفق:</h3>
                                <a href="{{ asset('storage/' . $currentChat->attachment) }}"
                                   class="inline-block px-3 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm"
                                   target="_blank" download>
                                    تحميل المرفق
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                @forelse ($messages as $msg)
                    @php
                        $isSender = $msg->user_id === auth()->id();
                        $isImage = $msg->type === 'image';
                        $isFile = $msg->type === 'file';
                        $profilePicture = $msg->user->additional_data['profile_picture'] ?? $msg->user->additional_data['profile_picture'];
                        $profilePictureUrl = asset('storage/' . $profilePicture);
                    @endphp
                    <div class="flex {{ $isSender ? 'justify-end' : 'justify-start' }}">
                        <div class="flex gap-2 items-end max-w-sm">
                            @unless($isSender)
                                <img src="{{ $profilePictureUrl }}" class="w-8 h-8 rounded-full border object-cover">
                            @endunless
                            <div class="relative rounded-xl p-3 shadow text-sm border {{ $isSender ? 'bg-blue-100' : 'bg-gray-100' }}">
                                @if ($isImage)
                                    <img src="{{ asset('storage/' . $msg->additional_data['path']) }}" class="rounded mb-2 max-h-48 object-cover">
                                @elseif ($isFile)
                                    <a href="{{ asset('storage/' . $msg->additional_data['path']) }}" download class="text-blue-500 underline break-all block mb-2">
                                        {{ $msg->additional_data['name'] ?? 'ملف مرفق' }}
                                    </a>
                                @endif
                                @if ($msg->message)
                                    <div class="break-words mb-1">{{ $msg->message }}</div>
                                @endif
                                <div class="text-xs text-gray-400">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                                @if ($isSender)
                                    <div class="absolute left-2 top-2">
                                        <div class="relative group">
                                            <button class="text-gray-500 hover:text-gray-700">⋮</button>
                                            <div class="absolute left-0 mt-1 w-20 bg-white border rounded shadow hidden group-hover:block z-10">
                                                <button wire:click="deleteMessage({{ $msg->id }})" class="block w-full text-left px-3 py-1 text-sm text-red-600 hover:bg-red-50">حذف</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if($isSender)
                                <img src="{{ $profilePictureUrl }}" class="w-8 h-8 rounded-full border object-cover">
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 mt-10">لا توجد رسائل</div>
                @endforelse
            </div>


                <form wire:submit.prevent="send" class="mt-4 border rounded-lg overflow-hidden shadow relative">
                    <input type="file" wire:model="attachment" id="attachment" class="hidden">
                    <div class="flex items-center gap-2 p-2">
                        <button type="button" onclick="document.getElementById('attachment').click()" class="text-gray-500 hover:text-gray-700">📎</button>
                        <input type="text" wire:model.defer="newMessage" placeholder="اكتب رسالتك..." class="flex-1 p-2 text-sm focus:outline-none bg-transparent">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 text-sm rounded">إرسال</button>
                    </div>
                </form>

        @else
            <div class="flex items-center justify-center h-full text-gray-400">
                <p class="text-lg">اختر محادثة لعرض الرسائل</p>
            </div>
        @endif
    </div>
</div>

<script>
    function scrollToBottom() {
        const box = document.getElementById('chatBox');
        if (box) box.scrollTop = box.scrollHeight;
    }

    document.addEventListener('livewire:load', function () {
        scrollToBottom();
        window.livewire.on('messageSent', () => {
            scrollToBottom();
        });
    });
</script>
