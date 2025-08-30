<div class="flex h-screen overflow-hidden bg-gray-100">
    <!-- Sidebar -->
    @php
if($merchantid){
    $hasChatingPermession = has_Permetion(Auth::id(),'messages_send', $merchantid);
    $hasAcceptChatsPermission = has_Permetion(Auth::id(),'accept_chats', $merchantid);
}else {
    $hasChatingPermession = true;
    $hasAcceptChatsPermission = true;
}
@endphp

    <div class="w-full md:w-1/3 max-w-xs bg-white border-r shadow p-4 flex flex-col">
        <h2 class="text-lg font-bold mb-4 text-blue-600 border-b pb-2">قائمة المحادثات</h2>
        <ul class="space-y-2 flex-1 overflow-y-auto">

            @forelse ($chats as $chat)
                @php
                    $user = $chat->user;
                    $name = $user->f_name . ' ' . ($user->l_name ?? '');
                    $profilePicture = $user->additional_data['profile_picture'] ?? 'default.png';
                    $profilePictureUrl = asset('storage/' . $profilePicture);
                    $lastMessage = $chat->messages->sortByDesc('created_at')->first()->message ?? 'لا توجد رسائل بعد';
                @endphp
                <li>
                    <button wire:click="$set('chat_id', {{ $chat->id }})"
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
            <div id="chatBox" wire:poll.2s class="flex-1 overflow-y-auto space-y-4 p-2 bg-gray-50 rounded shadow-inner">
                @forelse ($messages as $msg)
                    @php
                        $isSender = $msg->user_id === $finalID;
                        $isImage = $msg->type === 'image';
                        $isFile = $msg->type === 'file';
                        $profilePicture = $msg->user->additional_data['profile_picture'] ?? 'default.png';
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
                                    <a href="{{ asset('storage/' . $msg->additional_data['path']) }}" download
                                       class="text-blue-500 underline break-all block mb-2">
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
                                                <button wire:click="deleteMessage({{ $msg->id }})"
                                                        class="block w-full text-left px-3 py-1 text-sm text-red-600 hover:bg-red-50">حذف
                                                </button>
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

            <!-- Input -->
            @if ($hasChatingPermession)
                <form wire:submit.prevent="send" class="mt-4 border rounded-lg overflow-hidden shadow relative">
                    <div class="flex items-center gap-2 p-2">
                        <button type="button" onclick="document.getElementById('attachment').click()" class="text-gray-500 hover:text-gray-700">📎</button>
                        <input type="file" id="attachment" wire:model="attachment" class="hidden">
                        @if ($previewAttachment)
                            <div class="flex items-center gap-2 bg-gray-100 rounded p-2 border">
                                @if(str_starts_with($attachment->getMimeType(), 'image'))
                                    <img src="{{ $previewAttachment }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-sm text-gray-700">{{ $attachment->getClientOriginalName() }}</span>
                                @endif
                                <button type="button" wire:click="$set('attachment', null)" class="text-red-500">✕</button>
                            </div>
                        @endif
                        <input type="text" wire:model.defer="newMessage" placeholder="اكتب رسالتك..."
                               class="flex-1 p-2 text-sm focus:outline-none bg-transparent">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 text-sm rounded">إرسال</button>
                    </div>
                </form>
            @endif

        @else
            <div class="flex items-center justify-center h-full text-gray-400">
                <p class="text-lg">اختر محادثة لعرض الرسائل</p>
            </div>
        @endif
</div>

<script>
    $wire.on('scrollDown', () => {
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
