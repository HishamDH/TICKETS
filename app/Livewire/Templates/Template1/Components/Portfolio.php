<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Portfolio extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $Portfolio = null;
    public $portfolioEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['Portfolio'])) {
            $this->Portfolio = $this->offering->features['Portfolio'];
        } else {
            $this->Portfolio = [

            ];
        }

    }

        
        
        
        
    
    public function render()
    {
        return view('livewire.templates.template1.components.portfolio');
    }
}
