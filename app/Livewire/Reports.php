<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PaysHistory;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\MerchantWallet;
use App\Models\User;
use App\Models\Support_chat;
use App\Models\Supports;
use App\Models\Role;
use App\Models\MerchantChat;
use App\Models\MerchantMessage;
use App\Models\withdraws_log;
use App\Models\Offering;
use App\Models\page_views;
use App\Models\Presence;
use App\Models\Merchant\Branch;
use App\Models\PaidReservation;

class Reports extends Component
{
    public $startDate;
    public $endDate;
    public $pays;

    public function mount()
    {
        $this->startDate = Carbon::now()->subMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->loadPays();
    }

    public function updated($property)
    {
        if (in_array($property, ['startDate', 'endDate'])) {
            $this->loadPays();
        }
    }

    public function loadPays()
    {
        $this->pays = PaysHistory::with(['user', 'item'])
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->get();
    }

    public function render()
    {
        // Wallet
        $topOffers = Offering::withCount([
            'Reservations as totalSales' => function ($query) {
                $query->select(DB::raw("SUM(price)")); 
            },
            'Reservations as totalBuyers' => function ($query) {
                $query->select(DB::raw("COUNT(DISTINCT user_id)"));
            }
        ])
        ->orderByDesc('totalSales') 
        ->take(4)
        ->get();

        $paidReservations = PaidReservation::selectRaw('DATE(created_at) as day,  COUNT(*) as total')
        ->groupBy('day')
        ->orderBy('day', 'asc')
        ->get();

        $dates = $paidReservations->pluck('day');
        $totals = $paidReservations->pluck('total');
        //dd($topOffers);
        $totalBalance   = MerchantWallet::sum('balance');
        $totalLocked    = MerchantWallet::sum('locked_balance');
        $totalWithdrawn = MerchantWallet::sum('withdrawn_total');
        $walletTotal    = $totalBalance + $totalLocked + $totalWithdrawn;
        $averageWallet  = MerchantWallet::avg('balance');
    
        // Users & Roles
        $totalMerchants = MerchantWallet::count();
        $totalUsers     = User::where("role", "user")->count();
        $totalAdmins    = User::where("role", "admin")->count();
        $totalRoles     = Role::count();
    
        // Offerings & Branches
        $totalOffers    = Offering::count();
        $totalBranches  = Branch::count();
    
        // Transactions & Payments
        $totalTransactions = PaysHistory::count();
        $totalPay          = PaysHistory::sum('amount');
    
        // Support
        $totalSupportMessages = Support_chat::count();
        $totalSupportTickets  = Supports::count();
    
        // Merchant chats & messages
        $totalMerchantChats    = MerchantChat::count();
        $totalMerchantMessages = MerchantMessage::count();
    
        // Withdraws & presence
        $totalWithdraws   = withdraws_log::count();
        $totalPageViews   = page_views::count();
        $totalPresence    = Presence::count();
    
        return view('livewire.reports', [
            'totalBalance' => $totalBalance,
            'totalLocked' => $totalLocked,
            'totalWithdrawn' => $totalWithdrawn,
            'walletTotal' => $walletTotal,
            'averageWallet' => $averageWallet,
            'totalMerchants' => $totalMerchants,
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalRoles' => $totalRoles,
            'totalOffers' => $totalOffers,
            'totalBranches' => $totalBranches,
            'totalTransactions' => $totalTransactions,
            'totalPay' => $totalPay,
            'totalSupportMessages' => $totalSupportMessages,
            'totalSupportTickets' => $totalSupportTickets,
            'totalMerchantChats' => $totalMerchantChats,
            'totalMerchantMessages' => $totalMerchantMessages,
            'totalWithdraws' => $totalWithdraws,
            'totalPageViews' => $totalPageViews,
            'totalPresence' => $totalPresence,
            "topOffers" => $topOffers,
            "paidReservations" => $paidReservations,
            "dates" => $dates,
            "totals" => $totals,
        ]);
    }
    
}
