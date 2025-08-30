<?php

namespace App\Livewire\Tepmlates\Template1;

use App\Models\Offering;
use Carbon\Carbon;
use Livewire\Component;

class Item extends Component
{
    public $offer;
    public $merchant;
    public function mount(Offering $offer, $merchant)
    {
        $this->offer = $offer;
        $this->merchant = $merchant;
    }

    function calcPrice($offer)
    {
        $price = $offer->price ?? 0;

        // Check for discount
        if (!empty($offer->features['enable_discounts']) && $offer->features['enable_discounts'] && isset($offer->features['discount_start']) && isset($offer->features['discount_end']) && isset($offer->features['discount_percent'])) {
            $now = now();
            $start = Carbon::parse($offer->features['discount_start']);
            $end = Carbon::parse($offer->features['discount_end']);
            if ($now->between($start, $end)) {
                $discount = (float) $offer->features['discount_percent'];
                $price -= ($price * $discount / 100);
            }
        }

        return max(0, $price);
    }

    public function render()
    {
        return view('livewire.tepmlates.template1.item');
    }
    public function fullView()
    {
        $this->redirectIntended(route('template1.item', ['id' => $this->merchant->id, 'offering' => $this->offer->id]),true);
        // return redirect()->route('merchant.dashboard.offer.edit', $this->offer->id);
    }
}
