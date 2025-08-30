<?php

namespace App\Livewire\Merchant\Aside;

use Livewire\Component;

class Nav3 extends Component
{
    public $merchant,$workerNotActive;


    public function render()
    {
        return view('livewire.merchant.aside.nav3');
    }
    public function intended($url){
        $this->redirectIntended($url,true);
    }
}
