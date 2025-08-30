<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Kidshops extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $workshops = [];
    public $workshopEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['workshops']) && $this->category =="children_event") {
            $this->workshops = $this->offering->features['workshops'];
        } else {
            $this->workshops = [

            ];
        }

    }
    public function addWorkshop()
    {
        $this->workshops[] = [
            'title' => '',
            'description' => '',
            'image' => '',
        ];
    }

    public function editWorkshop($index)
    {
        $this->workshopEditingIndex = $index;
    }

    public function saveWorkshop($index)
    {
        if (isset($this->workshops[$index]['image']) && is_object($this->workshops[$index]['image'])) {
            $path = $this->workshops[$index]['image']->store('workshops', 'public');
            $this->workshops[$index]['image'] = $path;
        }

        $this->workshopEditingIndex = null;
    }

    public function removeWorkshop($index)
    {
        array_splice($this->workshops, $index, 1);
        if ($this->workshopEditingIndex === $index) {
            $this->workshopEditingIndex = null;
        }
    }

    public function saveWorkshops()
    {
        //$this->validateAllUploadedImages();

        $workshops = $this->workshops;

        foreach ($workshops as $i => $workshop) {
            if (isset($workshop['image']) && is_object($workshop['image'])) {
                $path = $workshop['image']->store('workshops', 'public');
                $workshops[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['workshops' => $workshops]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الورش بنجاح');
    }



    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.kidshops');
    }
}
