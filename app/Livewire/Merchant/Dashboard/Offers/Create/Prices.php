<?php

namespace App\Livewire\Merchant\Dashboard\Offers\Create;

use Livewire\Component;
use App\Models\Offering;

class Prices extends Component
{
    public Offering $offering;

    // Toggles
    public bool $enable_base_price = false;
    //public bool $enable_hourly_pricing = false;
    public bool $enable_coupons = false;
    public bool $enable_discounts = false;
    public bool $enable_cancellation = false;
    //public bool $enable_cancellation_fee = false;
    //public bool $enable_cancellation_deadline = false;
    public bool $enable_pricing_packages = false;

    // Inputs
    public $base_price = 0.0;
    //public $hourly_rate = 0.0;
    public $cancellation_fee = 0.0;
    public $cancellation_deadline_minutes = '';

    public array $pricing_packages = [
        ['label' => 'شخص واحد', 'price' => 0],
    ];

    public array $coupons = [
        ['code' => '', 'discount' => 0, 'expires_at' => '']
    ];
    public $discount_start = '';
    public $discount_end = '';
    public $discount_percent = null;

    public function mount(Offering $offering)
    {
        $this->offering = $offering;

        $features = $offering->features ?? [];
        //dd($this->base_price);
        $this->fill(array_merge([
            //'base_price' => false,
            //'base_price' => 0.0,
            'enable_hourly_pricing' => false,
            //'hourly_rate' => 0.0,
            'enable_coupons' => false,
            'enable_discounts' => false,

            'discount_start' => '',
            'discount_end' => '',
            'discount_percent' => null,

            'enable_cancellation' => false,
            //'enable_cancellation_fee' => false,
            'cancellation_fee' => 0.0,
            //'enable_cancellation_deadline' => false,
            'cancellation_deadline_minutes' => '',
            'enable_pricing_packages' => false,
            'pricing_packages' => [
                ['label' => 'شخص واحد', 'price' => 0],
            ],
            'coupons' => [
                ['code' => '', 'discount' => 0, 'expires_at' => '']
            ]
            //'enable_discounts' => false,

        ], $features));
        $this->base_price = $this->offering->price ?? 0.0;

    }



    public function savePricingSettings()
    {
        $this->offering->update([

            'features' => array_merge($this->offering->features ?? [], [
                //'base_price' => (float) $this->base_price,
                //'enable_hourly_pricing' => $this->enable_hourly_pricing,
                //'hourly_rate' => (float) $this->hourly_rate,
                'enable_coupons' => $this->enable_coupons,
                'coupons' => $this->coupons,
                'enable_discounts' => $this->enable_discounts,
                'enable_cancellation' => $this->enable_cancellation,
                //'enable_cancellation_fee' => $this->enable_cancellation_fee,
                'cancellation_fee' => (float) $this->cancellation_fee,
                //'enable_cancellation_deadline' => $this->enable_cancellation_deadline,
                'cancellation_deadline_minutes' => (int) $this->cancellation_deadline_minutes,
                'enable_pricing_packages' => $this->enable_pricing_packages,
                'pricing_packages' => $this->pricing_packages,
                'discount_start' => $this->discount_start,
                'discount_end' => $this->discount_end,
                'discount_percent' => $this->discount_percent,

            ]),
            'status' => 'inactive'
        ]);
        $this->offering->price = (float) $this->base_price;
        $this->offering->save();

        $this->dispatch('ServiceUpdated');

        session()->flash('success', 'تم حفظ إعدادات التسعير بنجاح');
    }
    public function removePackage($index)
    {
        unset($this->pricing_packages[$index]);
        $this->pricing_packages = array_values($this->pricing_packages); // لإعادة ترتيب المؤشرات
        $this->savePricingSettings(); // حفظ تلقائي بعد الحذف
    }
    public function addPackage()
    {
        $this->pricing_packages[] = ['label' => '', 'price' => 0];
        $this->savePricingSettings();
    }

    public function addCoupon()
    {
        $this->coupons[] = ['code' => '', 'discount' => 0, 'expires_at' => ''];
        $this->savePricingSettings();
    }


    public function removeCoupon($index)
    {
        unset($this->coupons[$index]);
        $this->coupons = array_values($this->coupons);
        $this->savePricingSettings();
    }

    public function updated($propertyName)
    {
        $this->savePricingSettings();
    }


    public function render()
    {
        //dd($this->base_price);
        return view('livewire.merchant.dashboard.offers.create.prices');
    }
}
