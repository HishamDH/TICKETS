<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;

class NotifBell extends Component
{
    public $showList = false;

    public function toggleList()
    {
        $this->showList = !$this->showList;
    
        if ($this->showList) {
            notifications::where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
    }
    

    public function render()
    {
        $userId = Auth::id();

        $notifications = notifications::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $unreadCount = notifications::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return view('livewire.notif-bell', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'showList' => $this->showList
        ]);
    }
}
