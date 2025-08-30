<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Eventlinks extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $links = [];
    public $linksEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['links']) ) {
            $this->links = $this->offering->features['links'];
        } else {
            $this->links = [

            ];
        }

    }

    public function addLink()
    {
        $this->links[] = [
            'platform' => '',
            'url' => '',
            'description' => '',
        ];
    }

    public function editLink($index)
    {
        $this->linksEditingIndex = $index;
    }

    public function saveLink($index)
    {
        $this->linksEditingIndex = null;
    }

    public function removeLink($index)
    {
        unset($this->links[$index]);
        $this->links = array_values($this->links);
    }

    public function saveLinks()
    {
        //$this->validateAllUploadedImages();

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['links' => $this->links]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ روابط الفعالية بنجاح');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.eventlinks');
    }
}
