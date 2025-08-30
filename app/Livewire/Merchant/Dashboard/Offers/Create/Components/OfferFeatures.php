<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

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

    public function addOfferFeature()
    {
        $this->Offerfeatures[] = [
            'name' => '',
            'description' => '',
            'image' => null,
        ];
        $this->OfferfeaturesEditingIndex = count($this->Offerfeatures) - 1;
    }

    public function editOfferFeature($index)
    {
        $this->OfferfeaturesEditingIndex = $index;
    }

    public function saveOfferFeature($index)
    {
        $this->OfferfeaturesEditingIndex = null;
    }

    public function removeOfferFeature($index)
    {
        unset($this->Offerfeatures[$index]);
        $this->Offerfeatures = array_values($this->Offerfeatures);

        if ($this->OfferfeaturesEditingIndex === $index) {
            $this->OfferfeaturesEditingIndex = null;
        } elseif ($this->OfferfeaturesEditingIndex > $index) {
            $this->OfferfeaturesEditingIndex--;
        }
    }

    public function saveOfferFeatures()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->Offerfeatures as $i => $feature) {
            if (isset($feature['image']) && is_object($feature['image'])) {
                $path = $feature['image']->store('offerfeatures', 'public');
                $this->Offerfeatures[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['Offerfeatures' => $this->Offerfeatures]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ مزايا العرض بنجاح');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.offer-features');
    }
}
