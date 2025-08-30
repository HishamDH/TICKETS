<?php


namespace App\Livewire;

use Livewire\Component;
use App\Models\Support_chat as SupportMessage;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SupportChat extends Component
{
    use WithPagination;

    public $support_id;
    public $newMessage = '';
    public $finalID,$merchantid = null;

    public function mount($support_id, $finalID=null, $merchantid = null)
    {
        $this->support_id = $support_id;
        $this->merchantid = $merchantid;
        $this->finalID = $finalID;

        if ($this->finalID === null) {
            $this->finalID = Auth::id();
        }
    }
    
    protected $rules = [
        'newMessage' => 'required|string|max:5000',
    ];

    public function deleteMessage($id)
    {
        $message = SupportMessage::findOrFail($id);

        if ($message->user_id === $this->finalID) {
            $message->delete();
        }
            
    }
    public function send()
    {
        //dd(Auth::guard('admin')->user(), $this->support_id, $this->newMessage, Auth::id());
        $this->validate();

        SupportMessage::create([
            'support_id' => $this->support_id,
            'user_id' => $this->finalID ?? Auth::id(),

            'message' => $this->newMessage,
            'type' => 'text',
        ]);

        $this->newMessage = '';
    }

    public function render()
    {
        $messages = SupportMessage::where('support_id', $this->support_id)
            ->orderBy('created_at')
            ->get();

        return view('livewire.support-chat', compact('messages'));
    }
}
