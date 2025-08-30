<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create\Components;

use Livewire\Component;
use App\Models\Offering;
use Livewire\WithFileUploads;


class Portfolio extends Component
{
    use WithFileUploads;

    public Offering $offering;
    public $Portfolio = null;
    public $portfolioEditingIndex = null;



    public function mount(Offering $offering){
        $this->offering = $offering;
        if (isset($this->offering->features['Portfolio'])) {
            $this->Portfolio = $this->offering->features['Portfolio'];
        } else {
            $this->Portfolio = [

            ];
        }

    }

    public function addPortfolio()
    {
        $this->Portfolio[] = [
            'title' => '',
            'description' => '',
            'link' => '',
            'image' => '',
            'date' => '',
            'tools' => '',
        ];
        $this->portfolioEditingIndex = count($this->Portfolio) - 1;
    }
    
    public function editPortfolioRow($index)
    {
        $this->portfolioEditingIndex = $index;
    }
    
    public function savePortfolioRow($index)
    {
        if (isset($this->Portfolio[$index]['image']) && is_object($this->Portfolio[$index]['image'])) {
            $path = $this->Portfolio[$index]['image']->store('portfolio', 'public');
            $this->Portfolio[$index]['image'] = $path;
        }
    
        $this->portfolioEditingIndex = null;
    }
    
    public function removePortfolio($index)
    {
        unset($this->Portfolio[$index]);
        $this->Portfolio = array_values($this->Portfolio);
    
        if ($this->portfolioEditingIndex === $index) {
            $this->portfolioEditingIndex = null;
        } elseif ($this->portfolioEditingIndex > $index) {
            $this->portfolioEditingIndex--;
        }
    }
    
    public function savePortfolio()
    {
        //$this->validateAllUploadedImages();

        foreach ($this->Portfolio as $i => $item) {
            if (isset($item['image']) && is_object($item['image'])) {
                $path = $item['image']->store('portfolio', 'public');
                $this->Portfolio[$i]['image'] = $path;
            }
        }
    
        $this->offering->features = array_merge(
            $this->offering->features ?? [],
            ['Portfolio' => $this->Portfolio]
        );
    
        $this->offering->save();
    
        session()->flash('success', 'تم حفظ البورتفوليو بنجاح');
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.offers.create.components.portfolio');
    }
}
