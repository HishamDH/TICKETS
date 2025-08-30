<?php

namespace App\Livewire\Merchant\Dashboard;

use App\Models\Offering;
use App\Models\PaidReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class Pos extends Component
{
    public $offerings;
    public $selectedOfferingId;
    public $selectedOffering;
    public $pricingPackages = [];
    public $selectedPackage;
    public $showPackage = false;

    public $tickets = 1;
    public $manualPrice = 0;
    public $paymentMethod;

    public $customerEmail;
    public $customerName;
    public $customerPhone;
    public $foundUser = null;

    public $selectedDate;
    public $selectedTime;
    public $selectedDay;


    public $allowedDates = [];
    public $allowedTimes = [];
    public $finalID ,$merchantid;

    public function mount($merchantid = null)
    {
        //dd($merchantid);
        $this->merchantid = $merchantid;
        $this->finalID = can_enter($merchantid, "pos_create");
        $this->offerings = Offering::where('user_id', $this->finalID)->where('status', 'active')->get();
    }

    public function updatedSelectedOfferingId($value)
    {
        $offering = $this->offerings->firstWhere('id', $value);
        $this->selectedOffering = $offering;
        if (!$offering) {
            $this->pricingPackages = [];
            return;
        }

        $features = $offering->features ?? [];

        $this->pricingPackages = collect($features['pricing_packages'] ?? [])
            ->filter(fn($pkg) => !empty($pkg['label']) && isset($pkg['price']) && $pkg['price'] > 0)
            ->values()
            ->toArray();
    }

    public function updatedCustomerPhone($value)
    {
        $phone = (substr($value, 0, 1) === '0') ? substr($value, 1) : $value;
        $user = User::where('phone', $value)->orWhere('phone', '+966' . $phone)->first();
        if ($user) {
            $this->foundUser = [
                'id' => $user->id,
                'name' => $user->f_name,
                'email' => $user->email,
                'profile_image' => $user->additional_data['profile_image'] ?? $user->additional_data['profile_picture'] ?? null,
            ];
            $this->customerName = $user->f_name;
            $this->customerEmail = $user->email ?? '';
            return;
        }

        $this->foundUser = null;
    }

    public function createBooking()
    {
        $this->validate([
            'selectedOfferingId' => 'required|exists:offerings,id',
            'selectedTime' => 'required|date_format:H:i',
            'paymentMethod' => 'required|in:cash,free',
            'customerPhone' => 'required|string',
        ]);

        $offering = $this->offerings->firstWhere('id', $this->selectedOfferingId);
        if (!$offering) {
            session()->flash('error', 'الخدمة غير موجودة');
            // return;
        }

        $features = $offering->features ?? [];
        $daySchedule = $features['work_schedule'][$this->selectedDay] ?? null;

        if ($offering->type == 'service') {
            if (!$daySchedule || !$daySchedule['enabled']) {
                session()->flash('error', 'اليوم غير مفعّل لهذه الخدمة');
                // return;
            }
        }

        $price = 0;
        if ($this->paymentMethod === 'cash') {
            if ($this->showPackage && $this->selectedPackage) {
                $package = collect($this->pricingPackages)->firstWhere('label', $this->selectedPackage);
                $price = $package['price'] ?? 0;
            } else {
                $price = $this->manualPrice;
            }
        }
        //dd($this->selectedTime, $this->selectedDate, $this->selectedOfferingId, $price);

        PaidReservation::create([
            'item_id' => $this->selectedOfferingId,
            'item_type' => Offering::class,
            'user_id' => $this->finalID,
            'quantity' => $this->tickets,
            'price' => $price,
            'discount' => 0,
            'code' => uniqid('code_'),
            'additional_data' => json_encode([
                'customerName' => $this->customerName,
                'customerPhone' => $this->customerPhone,
                'customerEmail' => $this->customerEmail ?? '',
                'paymentMethod' => $this->paymentMethod,
                'selling_type' => 'pos',
                'selected_day' => $this->selectedDate,
                'selected_time'  => $this->selectedTime
                    ? Carbon::createFromFormat('H:i', $this->selectedTime)->format('h:i A')
                    : null,
            ]),
        ]);

        session()->flash('success', 'تم إنشاء الحجز بنجاح!');
        $this->reset([
            'selectedOfferingId',
            'pricingPackages',
            'selectedPackage',
            'showPackage',
            'tickets',
            'manualPrice',
            'paymentMethod',
            'customerEmail',
            'customerName',
            'customerPhone',
            'foundUser',
            'selectedDay',
            'selectedTime',
        ]);
        if ($this->merchantid) {
            //dd($this->merchantid);
            $this->redirectIntended(route('merchant.dashboard.m.pos.index', ['merchant' => $this->finalID]), true);


        }else{
            $this->redirectIntended(route('merchant.dashboard.pos.index'), true);

        }
    }

    public function updatedTickets($value)
    {
        if ($this->paymentMethod == 'cash') {
            $offer = Offering::find($this->selectedOfferingId);
            $this->manualPrice = $offer->price * $value;
        }
    }
    public function updatedPaymentMethod($value)
    {
        if ($value == 'cash') {
            $offer = Offering::find($this->selectedOfferingId);
            $this->manualPrice = $offer->price * $this->tickets;
        }
    }

    public function render()
    {
        return view('livewire.merchant.dashboard.pos');
    }
}
