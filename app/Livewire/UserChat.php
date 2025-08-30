<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MerchantChat;
use App\Models\MerchantMessage as MerchantChatMessage;
use Illuminate\Support\Facades\Auth;

class UserChat extends Component
{
    use WithFileUploads;

    public $chat_id;
    public $newMessage = '';
    public $attachment;

    protected $rules = [
        'newMessage' => 'nullable|string|max:1000',
        'attachment' => 'nullable|file|max:10240',
    ];

    public function acceptChat($chatId)
    {
        $chat = MerchantChat::findOrFail($chatId);

        $data = $chat->additional_data ?? [];

        // تأكد من أنه عبارة عن مصفوفة
        if (is_string($data)) {
            $data = json_decode($data, true) ?? [];
        }

        $data['status'] = 'pending';

        $chat->update([
            'additional_data' => $data,
        ]);

        $this->chat_id = $chatId;

        $this->dispatch('$refresh');
    }

    public function send()
    {
        $this->validate();

        $data = [
            'merchant_chat_id' => $this->chat_id,
            'user_id' => Auth::id(),
            'message' => $this->newMessage,
            'type' => 'text',
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('chat_attachments', 'public');
            $mime = $this->attachment->getMimeType();
            $filename = $this->attachment->getClientOriginalName();

            $data['type'] = str_starts_with($mime, 'image') ? 'image' : 'file';
            $data['additional_data'] = [
                'path' => $path,
                'name' => $filename,
            ];
        }

        MerchantChatMessage::create($data);
        $this->newMessage = '';
        $this->attachment = null;
    }

    public function deleteMessage($id)
    {
        $msg = MerchantChatMessage::findOrFail($id);
        if ($msg->user_id === Auth::id()) {
            $msg->delete();
        }
    }

    public function render()
    {
        $chats = MerchantChat::with(['messages' => fn($q) => $q->latest()->limit(1), 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $messages = [];
        $currentChat = null;
        $currentChatStatus = null;

        if ($this->chat_id) {
            $currentChat = MerchantChat::find($this->chat_id);

            // معالجة additional_data لتكون مصفوفة
            $data = $currentChat?->additional_data;

            if (is_string($data)) {
                $data = json_decode($data, true) ?? [];
            }

            $currentChatStatus = $data['status'] ?? null;

            $messages = MerchantChatMessage::where('merchant_chat_id', $this->chat_id)
                ->with('user')
                ->oldest()
                ->get();
        }

        return view('livewire.user-chat', compact('chats', 'messages', 'currentChat', 'currentChatStatus'));
    }
}
