<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Speakers extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $speakers = [];
    public $SpeakereditingIndex = null;




    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['speakers'])) {
            $this->speakers = $this->offering->features['speakers'];
        } else {
            $this->speakers = [

            ];
        }

    }

            
    
    
    
    public function render()
    {
        return view('livewire.templates.template1.components.speakers');
    }
}
