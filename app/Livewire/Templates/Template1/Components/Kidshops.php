<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Kidshops extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $workshops = [];
    public $workshopEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['workshops']) ) {
            $this->workshops = $this->offering->features['workshops'];
        } else {
            $this->workshops = [

            ];
        }

    }
    
    
    
    
    


    public function render()
    {
        return view('livewire.templates.template1.components.kidshops');
    }
}
