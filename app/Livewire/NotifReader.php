<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\notifications;
use Illuminate\Support\Facades\Auth;

class NotifReader extends Component
{
    public $notifications;
    public $unreadCount;

    public function loadNotifications()
    {
        $userId = Auth::id();

        $this->notifications = notifications::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $this->unreadCount = notifications::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function mount()
    {
        $this->loadNotifications();
    }

    public function render()
    {
        $this->loadNotifications();

        return view('livewire.notif-reader');
    }
}
