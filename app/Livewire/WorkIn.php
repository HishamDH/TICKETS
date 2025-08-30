<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class WorkIn extends Component
{
    public $work_in;
    public $work_in_id;
    public function mount(){
        $this->work_in_id = work_in(Auth::id());
        $this->work_in = User::whereIn('id', $this->work_in_id)->get();
        
        //dd($this->work_in);
        //dd($this->work_in);
    }
    public function render()
    {
        return view('livewire.work-in');
    }
}
