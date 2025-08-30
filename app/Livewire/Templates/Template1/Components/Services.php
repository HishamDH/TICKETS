<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Services extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $services = [];
    public $servicesEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['services'])) {
            $this->services = $this->offering->features['services'];
        } else {
            $this->services = [

            ];
        }

    }


    
    
    
    
        public function render()
    {
        return view('livewire.templates.template1.components.services');
    }
}
