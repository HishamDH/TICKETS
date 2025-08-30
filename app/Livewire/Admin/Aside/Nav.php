<?php

namespace App\Livewire\Admin\Aside;

use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        return view('livewire.admin.aside.nav');
    }
    public function intended($url){
        $this->redirectIntended($url,true);
    }
}
