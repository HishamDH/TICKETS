<?php

namespace App\Livewire\Tepmlates\Template1;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart as CartModel;

class Cart extends Component
{
    public $carts = [];
    public $totalPrice = 0;
    public $merchant;

    public function mount($carts = [],$merchant)
    {
        $this->merchant = $merchant;
        $user = Auth::guard('customer')->user();
        $this->carts = $carts;
        $this->refreshPrices();
        $this->calculateTotal();
    }
    public function refreshPrices()
    {
        foreach ($this->carts as $cart) {
            $data = json_decode($cart->additional_data, true);
            $offer = $cart->item;
            $features = $offer?->features ?? [];
            $base = $offer->price ?? 0;
            $price = $base * $cart->quantity;
            $discount = 0;

            if (!empty($data['coupon_code']) && isset($features['coupons'])) {
                foreach ($features['coupons'] as $c) {
                    if (strtoupper($c['code']) === strtoupper($data['coupon_code']) && now()->lte($c['expires_at'])) {
                        $discount = ($price * floatval($c['discount']) / 100);
                        break;
                    }
                }
            }

            $cart->update([
                'price' => max(0, $price - $discount),
                'discount' => $discount,
            ]);
        }
    }
    public function calculateTotal()
    {
        if(empty($this->carts)){
            $this->totalPrice = 0;
            return;
        }else{
            $this->totalPrice = $this->carts->sum('price');
        }
    }

    public function removeItem($id)
    {
        CartModel::where('id', $id)->where('user_id', Auth::id())->delete();
        $this->mount(Auth::guard('customer')->user()->carts);
        session()->flash('success', 'تم حذف العنصر من السلة.');
    }

    public function render()
    {
        return view('livewire.tepmlates.template1.cart');
    }
}
