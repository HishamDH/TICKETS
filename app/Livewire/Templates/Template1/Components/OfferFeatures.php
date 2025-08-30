<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class OfferFeatures extends Component
{
    use WithFileUploads;

    public Offering $offering;


    public $Offerfeatures = null;
    public $OfferfeaturesEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['Offerfeatures'])) {
            $this->Offerfeatures = $this->offering->features['Offerfeatures'];
        } else {
            $this->Offerfeatures = [

            ];
        }

    }

    
    
    
    
    
    public function render()
    {
        return view('livewire.templates.template1.components.offer-features');
    }
}
