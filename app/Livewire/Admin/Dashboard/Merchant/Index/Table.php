<?php

namespace App\Livewire\Admin\Dashboard\Merchant\Index;

use App\Models\User;
use Livewire\Component;
use App\Models\MerchantWallet;
class Table extends Component
{
    // public $merchants;
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function acceptMerchant($merchantId)
    {
        if (!adminPermission("staff_approval")) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'You do not have permission to accept merchants.']);
            return;
        }
        $merchant = User::find($merchantId);
        if ($merchant) {
            $merchant->update(['status' => 'active']);

            $wallet = MerchantWallet::create([
                'merchant_id' => $merchant->id,
                'balance' => 0,
                'locked_balance' => 0,
                'withdrawn_total' => 0,
                'additional_data' => [],
            ]);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Merchant accepted successfully.']);
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Merchant not found.']);
        }
    }
    public function rejectMerchant($merchantId)
    {
        if (!adminPermission("staff_approval")) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'You do not have permission to reject merchants.']);
            return;
        }
        $merchant = User::find($merchantId);
        if ($merchant) {
            $merchant->update(['status' => 'rejected']);
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Merchant rejected successfully.']);
        } else {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Merchant not found.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.merchant.index.table',[
            'merchants' => User::where('role', 'merchant')
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(30),
        ]);
    }
}
