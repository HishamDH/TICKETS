<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Speakers extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $speakers = [];
    public $SpeakereditingIndex = null;




    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['speakers'])) {
            $this->speakers = $this->offering->features['speakers'];
        } else {
            $this->speakers = [

            ];
        }

    }

    public function addSpeaker()
    {
        $this->speakers[] = [
            'name' => '',
            'title' => '',
            'cv' => '',
            'image' => '',
            'shortDescreption' => '',
        ];
        
    }
        public function editSpeaker($index)
    {
        $this->SpeakereditingIndex = $index;
    }

    public function removeSpeaker($index)
    {
        unset($this->speakers[$index]);
        $this->speakers = array_values($this->speakers);
    }

    public function saveSpeaker($index)
    {
        $this->SpeakereditingIndex = null;
    }

    public function saveSpeakers()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->speakers as $i => $speaker) {
            if (isset($speaker['image']) && is_object($speaker['image'])) {
                $path = $speaker['image']->store('speakers', 'public');
                $this->speakers[$i]['image'] = $path;
            }
        }

        //$this->offering->speakers = $this->speakers;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['speakers' => $this->speakers]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ المتحدثين بنجاح');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.speakers');
    }
}
