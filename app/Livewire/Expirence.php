<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer_Ratings;
use App\Models\PaidReservation;
use App\Models\Offering;
class Expirence extends Component
{
    public $offerings;
    public $finished;
    public $ratings;
    public $user;
    public $res;
    public $selectID;
    public $visible = false;
    
    public function openModal($id)
    {
        $this->selectID = $id;
        $this->visible = true;
    }
    
    public function closeModal()
    {
        $this->visible = false;
    }
    


    public function mount(){
        $this->user = auth()->user();
        $this->ratings = Customer_Ratings::where('user_id', $this->user->id)->get();
        $this->res = PaidReservation::where("user_id",$this->user->id)->get();
        $this->finished = pendingRes($this->res);
        $this->offerings = $this->finished->map(function ($reservation) {
            return $reservation->offering;
        })->unique('id')->values();
    }
    public function render()
    {
        return view('livewire.expirence');
    }
}
