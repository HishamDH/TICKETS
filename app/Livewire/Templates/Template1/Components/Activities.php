<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Activities extends Component
{
    use WithFileUploads;
    public $activities = [];
    public $activityeditingIndex = null;

    public Offering $offering;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['activities'])) {
            $this->activities = $this->offering->features['activities'];
        } else {
            $this->activities = [

            ];
        }

    }

        
    
    
    
    

    public function render()
    {
        return view('livewire.templates.template1.components.activities');
    }
}
