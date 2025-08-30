<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;

class Session extends Component
{
    public Offering $offering;

    public $sessions = [];
    public $editingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['sessions'])) {
            $this->sessions = $this->offering->features['sessions'];
        } else {
            $this->sessions = [

            ];
        }
    }
    public function editRow($index)
    {
        $this->editingIndex = $index;
    }
    
    public function saveRow($index)
    {
        $this->editingIndex = null;
    }
    public function addSession()
    {
        $this->sessions[] = [
            'speaker' => '',
            'date' => '',
            'time' => '',
            'location' => '',
            'description' => '',
            'image' => ''
        ];
    }

    public function removeSession($index)
    {
        unset($this->sessions[$index]);
        $this->sessions = array_values($this->sessions);
    }

    public function saveSessions()
    {
        $features = $this->offering->features ?? [];

        if (!is_array($features)) {
            $features = json_decode($features, true);
        }

        $features['sessions'] = $this->sessions;

        $this->offering->features = $features;
        $this->offering->save();

        session()->flash('success', 'تم حفظ الجلسات بنجاح.');
    }
    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.session');
    }
}
