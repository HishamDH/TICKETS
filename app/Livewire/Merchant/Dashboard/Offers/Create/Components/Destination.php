<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Destination extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $Destenations = null;
    public $DestenationsEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['Destenations'])) {
            $this->Destenations = $this->offering->features['Destenations'];
        } else {
            $this->Destenations = [

            ];
        }

    }
    public function addDestination()
    {
        $this->Destenations[] = [
            'name' => '',
            'description' => '',
            'image' => null,
        ];
        $this->DestenationsEditingIndex = count($this->Destenations) - 1;
    }

    public function editDestination($index)
    {
        $this->DestenationsEditingIndex = $index;
    }

    public function saveDestination($index)
    {
        $this->DestenationsEditingIndex = null;
    }

    public function removeDestination($index)
    {
        unset($this->Destenations[$index]);
        $this->Destenations = array_values($this->Destenations);

        if ($this->DestenationsEditingIndex === $index) {
            $this->DestenationsEditingIndex = null;
        } elseif ($this->DestenationsEditingIndex > $index) {
            $this->DestenationsEditingIndex--;
        }
    }

    public function saveDestenations()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->Destenations as $i => $destination) {
            if (isset($destination['image']) && is_object($destination['image'])) {
                $path = $destination['image']->store('destenations', 'public');
                $this->Destenations[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['Destenations' => $this->Destenations]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ الوجهات السياحية بنجاح');
    }


    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.destination');
    }
}
