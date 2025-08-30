<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class TrainWorkshops extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $trainingWorkshops = [];
    public $trainingWorkshopsEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['trainingWorkshops']) ) {
            $this->trainingWorkshops = $this->offering->features['trainingWorkshops'];
        } else {
            $this->trainingWorkshops = [

            ];
        }

    }



    

        
    
    
        public function render()
    {
        return view('livewire.templates.template1.components.train-workshops');
    }
}
