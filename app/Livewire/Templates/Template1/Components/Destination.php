<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Destination extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $Destenations = null;
    public $DestenationsEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['Destenations'])) {
            $this->Destenations = $this->offering->features['Destenations'];
        } else {
            $this->Destenations = [

            ];
        }

    }
    
    
    
    
    

    public function render()
    {
        return view('livewire.templates.template1.components.destination');
    }
}
