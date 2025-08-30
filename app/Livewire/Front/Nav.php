<?php

namespace App\Livewire\Front;

use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        return view('livewire.front.nav');
    }
    public function checkAccess($url)
    {
        // if (!auth()->check()) {
        //     session(['url.intended' => $url]);
        //     return redirect()->route('login');
        // }

        // return redirect()->to($url);
        $this->redirectIntended($url,true);
    }
}
