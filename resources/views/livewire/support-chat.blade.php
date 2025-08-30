
<div
    x-data="{
        scrollToBottom() {
            let el = $refs.messagesContainer;
            el.scrollTop = el.scrollHeight;
        },
        init() {
            this.scrollToBottom();

            // Listen to Livewire update
            Livewire.hook('message.processed', () => {
                this.scrollToBottom();
            });
        }
    }"
    x-init="init()"
    class="flex flex-col h-[80vh] max-w-4xl w-full mx-auto bg-white border border-gray-200 shadow rounded-xl overflow-hidden"
>


    <!-- Header -->
    <div class="bg-gray-100 text-gray-800 p-4 text-center font-semibold text-base sm:text-lg">
        💬 محادثة الدعم الفني
    </div>

    <!-- Messages -->
    <div x-ref="messagesContainer" class="flex-1 overflow-y-auto px-2 sm:px-4 py-4 space-y-4 bg-gray-50" wire:poll.1000ms    >
        @foreach($messages as $message)
            @php
                $isMine = $message->user_id === $finalID;
                $profileImagePath = $message->user->additional_data['profile_picture'] ?? null;
                $userName = $message->user->f_name ?? 'U';
                $userImage = $profileImagePath
                    ? (Str::startsWith($profileImagePath, 'http') ? $profileImagePath : asset('storage/' . $profileImagePath))
                    : 'https://ui-avatars.com/api/?name=' . urlencode($userName[0]) . '&background=0D8AFF&color=fff&size=128';
            @endphp

            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="flex items-start gap-2 max-w-[85%] sm:max-w-[70%] {{ $isMine ? 'flex-row-reverse' : '' }}">
                    <!-- صورة المستخدم -->
                    <img src="{{ $userImage }}" class="w-8 h-8 rounded-full border shadow-sm mt-1">

                    <!-- الرسالة + الوقت -->
                    <div class="flex items-end gap-2 {{ $isMine ? 'flex-row-reverse' : '' }}">
                        
                        <div class="{{ $isMine ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} px-4 py-2 rounded-2xl text-sm sm:text-base shadow-sm leading-snug break-words {{ $isMine ? 'rounded-br-none' : 'rounded-bl-none' }} max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl overflow-auto">
                            {{ $message->message }}
                        </div>

                        <span class="text-[10px] text-gray-500 mb-1 whitespace-nowrap">
                            {{ $message->created_at->format('H:i A') }}
                        </span>

                        @if ($isMine)
                            <!-- قائمة ⋮ باستخدام Alpine -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 text-lg">⋮</button>
                                <div x-show="open" @click.outside="open = false"
                                     x-transition
                                     class="absolute z-10 bg-white border rounded shadow text-sm right-0 top-6 w-24">
                                    <button wire:click="deleteMessage({{ $message->id }})"
                                            class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                        حذف
                                    </button>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input -->
    <form wire:submit.prevent="send" class="bg-white border-t p-3 sm:p-4" wire:ignore.self>
        <div class="flex items-center gap-2">
            <input wire:model.defer="newMessage" type="text"
                   class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="اكتب رسالتك...">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 sm:px-5 py-2 rounded-full hover:bg-blue-700 text-sm shadow-sm">
                إرسال
            </button>
        </div>
        @error('newMessage') 
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p> 
        @enderror
    </form>
</div>
