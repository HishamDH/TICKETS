<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\MerchantChat;
use App\Models\MerchantMessage as MerchantChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatCenter extends Component
{
    use WithFileUploads;

    public $chat_id;
    public $newMessage = '';
    public $attachment;
    public $finalID, $merchantid = null;
    public $previewAttachment = null;

    protected $rules = [
        'newMessage' => 'nullable|string|max:1000',
        'attachment' => 'nullable|file|max:10240',
    ];

    protected $listeners = ['refreshMessages' => '$refresh'];

    public function mount($finalID, $merchantid = null)
    {
        $this->finalID = $finalID;
        $this->merchantid = $merchantid;
    }

    public function updatedAttachment()
    {
        $this->previewAttachment = $this->attachment ? $this->attachment->temporaryUrl() : null;
    }

    public function acceptChat($chatId)
    {
        $chat = MerchantChat::findOrFail($chatId);
        $data = $chat->additional_data ?? [];
        if (is_string($data)) $data = json_decode($data, true) ?? [];
        $data['status'] = 'pending';
        $chat->update(['additional_data' => $data]);
        $this->chat_id = $chatId;
        $this->dispatchBrowserEvent('scrollDown');
    }

    public function send()
    {
        $this->validate();

        $data = [
            'merchant_chat_id' => $this->chat_id,
            'user_id' => $this->finalID,
            'message' => $this->newMessage,
            'type' => 'text',
            'additional_data' => [],
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('chat_attachments', 'public');
            $mime = $this->attachment->getMimeType();
            $filename = $this->attachment->getClientOriginalName();
            $data['type'] = str_starts_with($mime, 'image') ? 'image' : 'file';
            $data['additional_data'] = ['path' => $path, 'name' => $filename];
        }

        MerchantChatMessage::create($data);

        $this->newMessage = '';
        $this->attachment = null;
        $this->previewAttachment = null;
        $this->dispatch('scrollDown');
    }

    public function deleteMessage($id)
    {
        $msg = MerchantChatMessage::findOrFail($id);
        if ($msg->user_id === $this->finalID) $msg->delete();
    }

    public function render()
    {
        if (Auth::guard("merchant")->check() && Auth::guard("merchant")->user()->id == Auth::id()) {
            $chats = MerchantChat::with(['messages' => fn($q) => $q->latest()->limit(1), 'user'])
                ->where('merchant_id', $this->finalID)
                ->latest()
                ->get();
        } else {
            $chats = MerchantChat::with(['messages' => fn($q) => $q->latest()->limit(1), 'merchant'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }
        $messages = [];
        $currentChat = null;
        $currentChatStatus = null;

        if ($this->chat_id) {
            $currentChat = MerchantChat::find($this->chat_id);
            $data = $currentChat?->additional_data;
            if (is_string($data)) $data = json_decode($data, true) ?? [];
            $currentChatStatus = $data['status'] ?? null;

            $messages = MerchantChatMessage::where('merchant_chat_id', $this->chat_id)
                ->with('user')
                ->oldest()
                ->get();
        }

        return view('livewire.chat-center', compact('chats', 'messages', 'currentChat', 'currentChatStatus'));
    }
}
