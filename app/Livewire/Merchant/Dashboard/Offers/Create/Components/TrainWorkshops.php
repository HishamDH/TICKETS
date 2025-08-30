<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class TrainWorkshops extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $trainingWorkshops = [];
    public $trainingWorkshopsEditingIndex = null;


    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['trainingWorkshops']) ) {
            $this->trainingWorkshops = $this->offering->features['trainingWorkshops'];
        } else {
            $this->trainingWorkshops = [

            ];
        }

    }



    

    public function addTrainingWorkshop()
    {
        $this->trainingWorkshops[] = [
            'title' => '',          
            'description' => '',           
            'duration' => '',       
            'location' => '',      
            'instructor' => '',      
            'image' => '',         
            'certificate' => false, 
        ];
    }
    public function editTrainingWorkshop($index)
    {
        $this->trainingWorkshopsEditingIndex = $index;
    }

    public function saveTrainingWorkshop($index)
    {
        if (isset($this->trainingWorkshops[$index]['image']) && is_object($this->trainingWorkshops[$index]['image'])) {
            $path = $this->trainingWorkshops[$index]['image']->store('workshops', 'public');
            $this->trainingWorkshops[$index]['image'] = $path;
        }

        $this->trainingWorkshopsEditingIndex = null;
    }

    public function removeTrainingWorkshop($index)
    {
        array_splice($this->trainingWorkshops, $index, 1);
        if ($this->trainingWorkshopsEditingIndex === $index) {
            $this->trainingWorkshopsEditingIndex = null;
        } elseif ($this->trainingWorkshopsEditingIndex > $index) {
            $this->trainingWorkshopsEditingIndex--;
        }
    }

    public function saveTrainingWorkshops()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->trainingWorkshops as $i => $w) {
            if (isset($w['image']) && is_object($w['image'])) {
                $path = $w['image']->store('workshops', 'public');
                $this->trainingWorkshops[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['trainingWorkshops' => $this->trainingWorkshops]
        );

        $this->offering->save();

        session()->flash('success', 'تم حفظ الدورات والورش بنجاح');
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.train-workshops');
    }
}
