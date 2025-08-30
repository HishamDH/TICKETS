<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Services extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $services = [];
    public $servicesEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['services'])) {
            $this->services = $this->offering->features['services'];
        } else {
            $this->services = [

            ];
        }

    }


    public function addService()
    {
        $this->services[] = [
            'title' => '',
            'description' => '',
            'time' => '',
            'location' => '',
            'image' => '',
        ];
        
    }

    public function editServiceRow($index)
    {
        $this->servicesEditingIndex = $index;
    }

    public function saveServiceRow($index)
    {
        $this->servicesEditingIndex = null;
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    public function saveServices()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->services as $i => $activity) {
            if (isset($activity['image']) && is_object($activity['image'])) {
                $path = $activity['image']->store('services', 'public');
                $this->services[$i]['image'] = $path;
            }
        }

        //$this->offering->activities = $this->activities;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['services' => $this->services]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الفعاليات بنجاح');
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.services');
    }
}
