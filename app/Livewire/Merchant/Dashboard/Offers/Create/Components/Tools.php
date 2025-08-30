<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Tools extends Component
{
    use WithFileUploads;

    public Offering $offering;

    public $availableTools = null;
    public $availableToolsEditingIndex = null;

    public function mount(Offering $offering){
        $this->offering = $offering;
                    if (isset($this->offering->features['availableTools'])) {
                $this->availableTools = $this->offering->features['availableTools'];
            } else {
                $this->availableTools = [
  
                ];
            }

    }

    public function addAvailableTool()
    {
        $this->availableTools[] = [
            'name' => '',
            'category' => '',
            'description' => '',
            'model' => '',
            'image' => null,
            'availability' => '',
            'features' => '',
        ];
        $this->availableToolsEditingIndex = count($this->availableTools) - 1; 
    }
    public function editAvailableTool($index)
    {
        $this->availableToolsEditingIndex = $index;
    }
    public function saveAvailableTool($index)
    {
        // if (isset($this->availableTools[$index]['image']) && is_object($this->availableTools[$index]['image'])) {
        //     $path = $this->availableTools[$index]['image']->store('available_tools', 'public');
        //     $this->availableTools[$index]['image'] = $path;
        // }
        $this->availableToolsEditingIndex = null;
    }
    public function removeAvailableTool($index)
    {
        unset($this->availableTools[$index]);
        $this->availableTools = array_values($this->availableTools);
    
        if ($this->availableToolsEditingIndex === $index) {
            $this->availableToolsEditingIndex = null;
        } elseif ($this->availableToolsEditingIndex > $index) {
            $this->availableToolsEditingIndex--;
        }
    }
    public function saveAvailableTools()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->availableTools as $i => $tool) {
            if (isset($tool['image']) && is_object($tool['image'])) {
                $path = $tool['image']->store('available_tools', 'public');
                $this->availableTools[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['availableTools' => $this->availableTools]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الأدوات المتاحة بنجاح');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.tools');
    }
}
