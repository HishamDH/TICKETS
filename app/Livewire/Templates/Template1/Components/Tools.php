<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Tools extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $availableTools = null;
    public $availableToolsEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
                    if (isset($this->offering->features['availableTools'])) {
                $this->availableTools = $this->offering->features['availableTools'];
            } else {
                $this->availableTools = [

                ];
            }

    }

                    
    public function render()
    {
        return view('livewire.templates.template1.components.tools');
    }
}
