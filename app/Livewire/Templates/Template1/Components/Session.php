<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;

class Session extends Component
{
    public Offering $offering;

    public $sessions = [];
    public $editingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['sessions'])) {
            $this->sessions = $this->offering->features['sessions'];
        } else {
            $this->sessions = [

            ];
        }
    }
        
        
    
        public function render()
    {
        return view('livewire.templates.template1.components.session');
    }
}
