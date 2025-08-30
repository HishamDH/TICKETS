<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Products extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $products = [];
    public $productsEditingIndex = null;




    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['products'])) {
            $this->products = $this->offering->features['products'];
        } else {
            $this->products = [

            ];
        }

    }
        
    
        

    public function render()
    {
        return view('livewire.templates.template1.components.products');
    }
}
