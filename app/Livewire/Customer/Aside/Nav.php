<?php

namespace App\Livewire\Customer\Aside;

use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        return view('livewire.customer.aside.nav');
    }
    public function intended($url){
        $this->redirectIntended($url,true);
    }
}
