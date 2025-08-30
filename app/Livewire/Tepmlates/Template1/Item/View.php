<?php

namespace App\Livewire\Tepmlates\Template1\Item;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{
    public $offer;
    public $availableDays = [];
    public $currentMonth;
    public $currentYear;
    public $selectedDate = null;
    public $selectedTime = null;
    public $timeSlots = [];
    public $daysLimit = 3;

    public $count = 1;
    public $price = 0;
    public $couponCode = '';

    public function mount($offer, $daysLimit = 0)
    {
        // 'reservation' => [
        //         'offer' => $this->offer->id,
        //         'quantity' => $this->count,
        //         'price' => $this->price,
        //         'selected_date' => $this->selectedDate,
        //         'selected_time' => $this->selectedTime,
        //         'coupon_code' => $this->couponCode,
        //     ]
        $this->offer = $offer;
        if (isset($_GET['reservation']['quantity'])) {
            $this->count = $_GET['reservation']['quantity'];
        }
        if (isset($_GET['reservation']['price'])) {
            $this->price = $_GET['reservation']['price'];
        }
        if (isset($_GET['reservation']['selected_date'])) {
            $this->selectDate(Carbon::parse($_GET['reservation']['selected_date'])->format('d'));
            $this->currentMonth = Carbon::parse($_GET['reservation']['selected_date'])->format('m');
            $this->currentYear = Carbon::parse($_GET['reservation']['selected_date'])->format('Y');
        } else {
            $this->currentMonth = request()->get('month', now()->month);
            $this->currentYear = request()->get('year', now()->year);
        }
        if (isset($_GET['reservation']['selected_time'])) {
            $this->selectedTime = $_GET['reservation']['selected_time'];
        }
        if (isset($_GET['reservation']['coupon_code'])) {
            $this->couponCode = $_GET['reservation']['coupon_code'];
        }
        $this->daysLimit = $daysLimit;

        $this->generateAvailableDays();
        $this->calcPrice();
    }

    public function generateAvailableDays()
    {
        $raw = fetch_time($this->offer->id);

        $dates = [];

        if ($raw && $raw['type'] === 'events') {
            foreach ($raw['data'] as $event) {
                if (empty($event['start_date']) || empty($event['end_date'])) continue;

                $start = \Carbon\Carbon::parse($event['start_date']);
                $end = \Carbon\Carbon::parse($event['end_date']);

                while ($start->lte($end)) {
                    $dates[] = $start->toDateString();
                    $start->addDay();
                }
            }
        }

        $this->availableDays = $dates;
    }


    public function nextMonth()
    {
        $next = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $next->month;
        $this->currentYear = $next->year;
        $this->selectedDate = null;
        $this->generateTimeSlots();
    }

    public function prevMonth()
    {
        $prev = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $prev->month;
        $this->currentYear = $prev->year;
        $this->selectedDate = null;
        $this->generateTimeSlots();
    }

    public function selectDate($day)
    {
        $selected = Carbon::create($this->currentYear, $this->currentMonth, $day)->toDateString();

        if ($this->availableDays != []) {
            if (in_array($selected, $this->availableDays)) {
                $this->selectedDate = $selected;
                $this->generateTimeSlots();
            }
        } elseif ($selected > now()->subDay()->toDateString()) {
            $this->selectedDate = $selected;
            $this->generateTimeSlots();
        }
    }

    public function checkTime($time)
    {
        if (!in_array($time, $this->timeSlots)) return false;

        $selectedTime = Carbon::parse($this->selectedDate . ' ' . $time);
        $bookingDeadline = now()->addMinutes($this->offer->features['booking_minimum_time'] ?? 0);

        return $selectedTime->gte($bookingDeadline);
    }
    public function selectTime($time)
    {
        if (in_array($time, $this->timeSlots)) {
            if (Carbon::parse($this->selectedDate)->isSameDay(now())) {
                if (Carbon::parse(now()->format('Y-m-d') . ' ' . $time) >= now()->addMinutes($this->offer->features['booking_minimum_time'] ?? 0))
                    $this->selectedTime = $time;
            } else {
                $this->selectedTime = $time;
            }
        } else {
            $this->selectedTime = null;
        }
    }

    public function subNumber()
    {
        if ($this->count > 1) {
            $this->count--;
        }
        $this->calcPrice();
    }

    public function addNumber()
    {
        $this->count++;
        $this->calcPrice();
    }

    public function calcPrice()
    {
        $base = $this->offer->price ?? 0;
        $price = $base * $this->count;

        // Check for discount
        if (!empty($this->offer->features['enable_discounts']) && $this->offer->features['enable_discounts']) {
            $now = now();
            $start = Carbon::parse($this->offer->features['discount_start']);
            $end = Carbon::parse($this->offer->features['discount_end']);
            if ($now->between($start, $end)) {
                $discount = (float) $this->offer->features['discount_percent'];
                $price -= ($price * $discount / 100);
            }
        }

        // Apply coupon
        if (!empty($this->couponCode)) {
            $coupons = $this->offer->features['coupons'] ?? [];
            foreach ($coupons as $coupon) {
                if (strtoupper($coupon['code']) === strtoupper($this->couponCode) && now()->lte($coupon['expires_at'])) {
                    $discount = (float) $coupon['discount'];
                    $price -= ($price * $discount / 100);
                }
            }
        }
        $this->price = max(0, $price);
    }

    public function generateTimeSlots()
    {
        $this->selectedTime = null;
        $this->timeSlots = [];

        if (!$this->selectedDate) return;

        $raw = fetch_time($this->offer->id);
        if (!$raw || empty($raw['data'])) return;

        foreach ($raw['data'] as $time) {
            if (empty($time['start_date']) || empty($time['end_date'])) continue;

            $selectedDate = Carbon::parse($this->selectedDate)->startOfDay();
            $startDate = Carbon::parse($time['start_date'])->startOfDay();
            $endDate = Carbon::parse($time['end_date'])->endOfDay();

            // Skip if out of range
            if ($selectedDate->lt($startDate) || $selectedDate->gt($endDate)) {
                continue;
            }

            // Safe defaults
            $startTime = !empty($time['start_time']) ? $time['start_time'] : '00:00';
            $endTime = !empty($time['end_time']) ? $time['end_time'] : '23:59';

            if ($time['start_date'] == $time['end_date']) {
                $start = Carbon::parse("{$this->selectedDate} {$startTime}");
                $end = Carbon::parse("{$this->selectedDate} {$endTime}");
            } elseif ($this->selectedDate == $time['start_date']) {
                $start = Carbon::parse("{$this->selectedDate} {$startTime}");
                $end = Carbon::parse("{$this->selectedDate} 23:59");
            } elseif ($this->selectedDate == $time['end_date']) {
                $start = Carbon::parse("{$this->selectedDate} 00:00");
                $end = Carbon::parse("{$this->selectedDate} {$endTime}");
            } else {
                $start = Carbon::parse("{$this->selectedDate} 00:00");
                $end = Carbon::parse("{$this->selectedDate} 23:59");
            }

            // Make sure start is before end
            if ($start->gt($end)) continue;

            while ($start->lte($end)) {
                $this->timeSlots[] = $start->format('H:i');
                $start->addMinutes(30);
            }
        }
    }


    public function addToCart()
    {
        $user = Auth::guard('customer')->user();
        if (!Auth::guard('customer')->check()) {

            return redirect(route('customer.login', ['reservation' => [
                'offer' => $this->offer->id,
                'quantity' => $this->count,
                'price' => $this->price,
                'selected_date' => $this->selectedDate,
                'selected_time' => $this->selectedTime,
                'coupon_code' => $this->couponCode,
            ], 'redirect' => url()->previous()]), true);
        } else {
            // dd(route('customer.login', ['reservation-Cart' => [
            //         'item_id' => $this->offer->id,
            //         'item_type' => get_class($this->offer),
            //         'quantity' => $this->count,
            //         'price' => $this->price,
            //         'discount' => 0, // الخصم مُطبق مسبقًا ضمن السعر
            //         'additional_data' => json_encode([
            //             'selected_date' => $this->selectedDate,
            //             'selected_time' => $this->selectedTime,
            //             'coupon_code' => $this->couponCode,
            //         ]),
            //     ],'redirect'=>url()->previous()]));
            if (!$user || !$this->selectedDate || !$this->selectedTime) {
                session()->flash('error', 'يرجى اختيار التاريخ والوقت أولاً.');
                //dd("zbi");
                return;
            }

            Cart::create([
                'user_id' => $user->id,
                'item_id' => $this->offer->id,
                'item_type' => get_class($this->offer),
                'quantity' => $this->count,
                'price' => $this->price,
                'discount' => 0, // الخصم مُطبق مسبقًا ضمن السعر
                'additional_data' => json_encode([
                    'selected_date' => $this->selectedDate,
                    'selected_time' => $this->selectedTime,
                    'coupon_code' => $this->couponCode,
                ]),
            ]);

            session()->flash('success', 'تمت إضافة الحجز إلى السلة بنجاح.');
            // return redirect()->route('cart.index');
            $this->redirectIntended(route('template1.cart', ['id' => $this->offer->user_id]), true);
        }
    }

    public function render()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $date->daysInMonth;
        $firstDayIndex = $date->dayOfWeek;

        return view('livewire.tepmlates.template1.item.view', [
            'date' => $date,
            'daysInMonth' => $daysInMonth,
            'firstDayIndex' => $firstDayIndex,
        ]);
    }
}
