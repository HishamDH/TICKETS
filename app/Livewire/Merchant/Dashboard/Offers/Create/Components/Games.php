<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Games extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $games = [];
    public $gamesEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['games']) && $this->category =="children_event") {
            $this->games = $this->offering->features['games'];
        } else {
            $this->games = [

            ];
        }


    }

    public function addGame()
    {
        $this->games[] = [
            'name' => '',
            'description' => '',
            'age_range' => '',
            'image' => '',
            'location' => '',
            'supervisor' => '',
            'rules' => '',
        ];
        $this->gamesEditingIndex = count($this->games) - 1;
    }
    
    public function editGame($index)
    {
        $this->gamesEditingIndex = $index;
    }
    
    public function saveGame($index)
    {
        $this->gamesEditingIndex = null;
    }
    
    public function removeGame($index)
    {
        array_splice($this->games, $index, 1);
    
        if ($this->gamesEditingIndex === $index) {
            $this->gamesEditingIndex = null;
        } elseif ($this->gamesEditingIndex > $index) {
            $this->gamesEditingIndex--;
        }
    }
    public function saveGames()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->games as $i => $game) {
            if (isset($game['image']) && is_object($game['image'])) {
                $path = $game['image']->store('games', 'public');
                $this->games[$i]['image'] = $path;
            }
        }

        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['games' => $this->games]
        );
        $this->offering->save();

        session()->flash('success', 'تم حفظ الألعاب بنجاح');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.games');
    }
}
