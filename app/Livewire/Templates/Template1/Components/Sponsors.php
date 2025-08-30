<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Sponsors extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $sponsors = [];
    public $sponsorEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['sponsors'])) {
            $this->sponsors = $this->offering->features['sponsors'];
        } else {
            $this->sponsors = [

            ];
        }
    }
    
    
    
    
        public function render()
    {
        return view('livewire.templates.template1.components.sponsors');
    }
}
