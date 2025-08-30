<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Cartoons extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $cartoons = [];
    public $cartoonEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['cartoons']) && $this->category =="children_event") {
            $this->cartoons = $this->offering->features['cartoons'];
        } else {
            $this->cartoons = [

            ];
        }
        

    }
    public function addCartoon()
    {
        $this->cartoons[] = [
            'name' => '',
            'description' => '',
            'image' => '',
        ];
    }

    public function editCartoon($index)
    {
        $this->cartoonEditingIndex = $index;
    }

    public function saveCartoon($index)
    {

        if (isset($this->cartoons[$index]['image']) && is_object($this->cartoons[$index]['image'])) {
            $path = $this->cartoons[$index]['image']->store('cartoons', 'public');
            $this->cartoons[$index]['image'] = $path;
        }

        $this->cartoonEditingIndex = null;
    }

    public function removeCartoon($index)
    {
        array_splice($this->cartoons, $index, 1);
        if ($this->cartoonEditingIndex === $index) {
            $this->cartoonEditingIndex = null;
        }
    }

    public function saveCartoons()
    {
        //$this->validateAllUploadedImages();

        $cartoons = $this->cartoons;

        // حفظ الصور إن وجدت (تأكدت من ذلك داخل saveCartoon أيضاً)
        foreach ($cartoons as $i => $cartoon) {
            if (isset($cartoon['image']) && is_object($cartoon['image'])) {
                $path = $cartoon['image']->store('cartoons', 'public');
                $cartoons[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['cartoons' => $cartoons]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الشخصيات الكرتونية بنجاح');
    }


    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.cartoons');
    }
}
