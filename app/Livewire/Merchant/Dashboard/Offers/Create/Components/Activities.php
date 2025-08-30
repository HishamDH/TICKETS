<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Activities extends Component
{
    use WithFileUploads;
    public $activities = [];
    public $activityeditingIndex = null;

    public Offering $offering;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['activities'])) {
            $this->activities = $this->offering->features['activities'];
        } else {
            $this->activities = [

            ];
        }

    }

    public function addActivity()
    {
        $this->activities[] = [
            'title' => '',
            'description' => '',
            'time' => '',
            'location' => '',
            'image' => '',
        ];
        
    }
    
    public function editActivityRow($index)
    {
        $this->activityeditingIndex = $index;
    }

    public function saveActivityRow($index)
    {
        $this->activityeditingIndex = null;
    }

    public function removeActivity($index)
    {
        unset($this->activities[$index]);
        $this->activities = array_values($this->activities);
    }

    public function saveActivities()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->activities as $i => $activity) {
            if (isset($activity['image']) && is_object($activity['image'])) {
                $path = $activity['image']->store('activities', 'public');
                $this->activities[$i]['image'] = $path;
            }
        }

        //$this->offering->activities = $this->activities;
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['activities' => $this->activities]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الفعاليات بنجاح');
    }


    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.activities');
    }
}
