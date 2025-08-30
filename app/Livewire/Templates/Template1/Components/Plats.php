<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Plats extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $plats = null;
    public $platsEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['plats'])) {
            $this->plats = $this->offering->features['plats'];
        } else {
            $this->plats = [

            ];
        }

    }


    
    
    
    
        public function render()
    {
        return view('livewire.templates.template1.components.plats');
    }
}
