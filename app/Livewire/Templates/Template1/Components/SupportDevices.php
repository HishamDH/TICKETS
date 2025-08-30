<?php

namespace App\Livewire\Templates\Template1\Components;


use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class SupportDevices extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $supportedDevices = null;
    public $supportedDevicesEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['supportedDevices'])) {
            $this->supportedDevices = $this->offering->features['supportedDevices'];
        } else {
            $this->supportedDevices = [
                // [
                //     'device_name' => '',
                //     'model' => '',
                //     'description' => '',
                //     'image' => null,
                // ]
            ];
        }

    }

        
        
        
        
    
        



    public function render()
    {
        return view('livewire.templates.template1.components.support-devices');
    }
}
