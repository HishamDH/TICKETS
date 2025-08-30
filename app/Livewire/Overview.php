<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\PaysHistory;
use App\Models\Support_chat as SupportChat;
use App\Models\Supports as Support;
use App\Models\notifications as Notification;
use Carbon\Carbon;

class Overview extends Component
{
    public $salesCount;
    public $salesAmount;

    public $userCount;
    public $merchantCount;
    public $staffCount;

    public $newMerchants;

    public $ticketsCount;
    public $messagesCount;
    public $notificationsCount;

    public $notifications;

    public $recentTickets;
    public $recentMessages;

    public function mount()
    {
        $totalPayAmount = PaysHistory::where('additional_data->type', 'pay')->sum('amount');
        $totalRefundAmount = PaysHistory::where('additional_data->type', 'refund')->sum('amount');

        $payCount = PaysHistory::where('additional_data->type', 'pay')->count();
        $refundCount = PaysHistory::where('additional_data->type', 'refund')->count();

        $this->salesCount =  $payCount + $refundCount - $refundCount;
        $this->salesAmount = $totalPayAmount + $totalRefundAmount - $totalRefundAmount;
        

        $this->userCount = User::where('role', 'user')->count();
        $this->merchantCount = User::where('role', 'merchant')->count();
        $this->staffCount = User::where('role', 'admin')->count();

        $this->newMerchants = User::where('role', 'merchant')
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $this->ticketsCount = Support::count();
        $this->messagesCount = SupportChat::count();

        $this->notificationsCount = Notification::count();
        $this->notifications = Notification::orderBy('created_at', 'desc')->take(10)->get();

        $this->recentTickets = Support::orderBy('created_at', 'desc')->take(10)->get();
        $this->recentMessages = SupportChat::orderBy('created_at', 'desc')->take(10)->get();
    }

    public function render()
    {
        return view('livewire.overview');
    }
}
