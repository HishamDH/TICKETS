<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Sponsors extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $sponsors = [];
    public $sponsorEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['sponsors'])) {
            $this->sponsors = $this->offering->features['sponsors'];
        } else {
            $this->sponsors = [

            ];
        }
    }
    public function addSponsor()
    {
        $this->sponsors[] = [
            'name' => '',
            'level' => '',
            'logo' => '',
            'description' => '',
            'link' => ''
        ];
        $this->sponsorEditingIndex = array_key_last($this->sponsors);
    }

    public function removeSponsor($index)
    {
        unset($this->sponsors[$index]);
        $this->sponsors = array_values($this->sponsors); 
        if ($this->sponsorEditingIndex === $index) {
            $this->sponsorEditingIndex = null;
        }
    }

    public function editSponsorRow($index)
    {
        $this->sponsorEditingIndex = $index;
    }

    public function saveSponsorRow($index)
    {
        $this->sponsorEditingIndex = null;
    }

    public function saveSponsors()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->sponsors as $i => $sponsor) {
            if (isset($sponsor['logo']) && is_object($sponsor['logo'])) {
                $path = $sponsor['logo']->store('sponsors', 'public');
                $this->sponsors[$i]['logo'] = $path;
            }
        }
    
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['sponsors' => $this->sponsors]
        );
        $this->offering->save();
    
        session()->flash('success', 'تم حفظ الرعاة بنجاح');
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.sponsors');
    }
}
