<?php

namespace App\Livewire\Merchant\Aside;

use Livewire\Component;

class Nav2 extends Component
{
    public $merchant,$workerNotActive;

    public function render()
    {
        return view('livewire.merchant.aside.nav2');
    }
    public function intended($url){
        $this->redirectIntended($url,true);
    }
}
