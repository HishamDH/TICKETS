<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Cartoons extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $cartoons = [];
    public $cartoonEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['cartoons']) ) {
            $this->cartoons = $this->offering->features['cartoons'];
        } else {
            $this->cartoons = [

            ];
        }
        

    }
    
    
    
    
    

    public function render()
    {
        return view('livewire.templates.template1.components.cartoons');
    }
}
