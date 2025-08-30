<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Plats extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $plats = null;
    public $platsEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['plats'])) {
            $this->plats = $this->offering->features['plats'];
        } else {
            $this->plats = [

            ];
        }

    }


    public function addPlat()
    {
        $this->plats[] = [
            'name' => '',
            'description' => '',
            'image' => null,
            'price' => '',
            'allergens' => '',
            'calories' => '',
        ];
        $this->platsEditingIndex = count($this->plats) - 1;
    }

    public function editPlat($index)
    {
        $this->platsEditingIndex = $index;
    }

    public function savePlat($index)
    {
        $this->platsEditingIndex = null;
    }

    public function removePlat($index)
    {
        unset($this->plats[$index]);
        $this->plats = array_values($this->plats);

        if ($this->platsEditingIndex === $index) {
            $this->platsEditingIndex = null;
        } elseif ($this->platsEditingIndex > $index) {
            $this->platsEditingIndex--;
        }
    }

    public function savePlats()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->plats as $i => $plat) {
            if (isset($plat['image']) && is_object($plat['image'])) {
                $path = $plat['image']->store('plats', 'public');
                $this->plats[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['plats' => $this->plats]
        );

        $this->offering->save();
        

        session()->flash('success', 'تم حفظ الأطباق بنجاح');
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.plats');
    }
}
