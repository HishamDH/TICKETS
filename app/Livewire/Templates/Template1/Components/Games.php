<?php

namespace App\Livewire\Templates\Template1\Components;


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
        if (isset($this->offering->features['games']) ) {
            $this->games = $this->offering->features['games'];
        } else {
            $this->games = [

            ];
        }


    }



    public function render()
    {
        return view('livewire.templates.template1.components.games');
    }
}
