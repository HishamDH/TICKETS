<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

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
     
            ];
        }

    }

    public function addSupportedDevice()
    {
        $this->supportedDevices[] = [
            'device_name' => '',
            'model' => '',
            'description' => '',
            'image' => '',
        ];
        $this->supportedDevicesEditingIndex = count($this->supportedDevices) - 1; 
    }
    
    public function editSupportedDevice($index)
    {
        $this->supportedDevicesEditingIndex = $index;
    }
    
    public function saveSupportedDevice($index)
    {
        $this->supportedDevicesEditingIndex = null;
    }
    
    public function saveSupportedDevices()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->supportedDevices as $i => $device) {
            if (isset($device['image']) && is_object($device['image'])) {
                $path = $device['image']->store('supported_devices', 'public');
                $this->supportedDevices[$i]['image'] = $path;
            }
        }
    
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['supportedDevices' => $this->supportedDevices]
        );
        $this->offering->save();
    
        session()->flash('success', 'تم حفظ الأجهزة المدعومة بنجاح');
    }
    
    
    public function removeSupportedDevice($index)
    {
        unset($this->supportedDevices[$index]);
        $this->supportedDevices = array_values($this->supportedDevices);
    
        if ($this->supportedDevicesEditingIndex === $index) {
            $this->supportedDevicesEditingIndex = null;
        } elseif ($this->supportedDevicesEditingIndex > $index) {
            $this->supportedDevicesEditingIndex--;
        }
    }
    



    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.support-devices');
    }
}
