<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class OfferSettings extends Component
{
    use WithFileUploads;
    public Offering $offering;
    public $category;
    public $type;
    
    public function validateAllUploadedImages()
    {
        $fieldsToCheck = [
            'sessions', 'sponsors', 'speakers', 'products', 'games', 'activities', 'services',
            'requirements', 'cartoons', 'workshops', 'links', 'trainingWorkshops', 'Portfolio',
            'supportedDevices', 'availableTools', 'Offerfeatures', 'Destenations', 'plats',
        ];
    
        $rules = [];
    
        foreach ($fieldsToCheck as $field) {
            $value = $this->$field;
    
            if (is_array($value)) {
                foreach ($value as $key => $item) {
                    if ($item instanceof \Illuminate\Http\UploadedFile) {
                        $rules["$field.$key"] = 'image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048';
                    }
                }
            } else {
                if ($value instanceof \Illuminate\Http\UploadedFile) {
                    $rules[$field] = 'image|mimes:jpeg,png,jpg,gif,bmp,webp|max:2048';
                }
            }
        }
    
        if (!empty($rules)) {
            $this->validate($rules);
        }
    }
    

    public function mount()
    {
        $this->category = $this->offering->category;
        $this->type = $this->offering->type;

    }








    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.offer-settingsb');
    }
}
