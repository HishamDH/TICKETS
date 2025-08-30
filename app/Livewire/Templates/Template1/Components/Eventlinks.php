<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Eventlinks extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $links = [];
    public $linksEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['links']) ) {
            $this->links = $this->offering->features['links'];
        } else {
            $this->links = [

            ];
        }

    }

    
    
    
    
    
    public function render()
    {
        return view('livewire.templates.template1.components.eventlinks');
    }
}
