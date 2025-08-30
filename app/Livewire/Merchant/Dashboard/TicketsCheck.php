<?php

namespace App\Livewire\Merchant\Dashboard;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\PaidReservation;
use Illuminate\Support\Facades\Auth;

class TicketsCheck extends Component

{
    public $code = '';
    public $reservation = null;
    public $error = null;
    public $finalID;
    public $merchantid;
    public function mount($finalID,$merchantid){
        $this->finalID = $finalID;
        $this->merchantid = $merchantid;
    }
    public function check()
    {
        $this->finalID = can_enter($this->finalID, "check_tickets");
        $this->reset(['reservation', 'error']);

        $this->validate([
            'code' => 'required|string'
        ]);

        $res = PaidReservation::where('code', $this->code)->first();
        //dd($res->offering);
        if ($res) {
            if (set_presence($res->id) !== true) {
                $this->error = 'تذكرة بالفعل مسجلة كحاضرة.';

                return;
            }
            $this->reservation = $res;


        } else {
            $this->error = 'لم يتم العثور على تذكرة بهذا الرقم.';
        }
        //dd($this->reservation);
        //set_presence($this->reservation);
    }
    #[On('qr-scanned')]
    public function scanned($code){
        $this->code = $code;
        $this->check();
    }


    public function render()
    {
        return view('livewire.merchant.dashboard.tickets-check');
    }
}
