<?php

namespace App\Livewire\Templates;

use Livewire\Component;
use App\Models\User;
use App\Models\Offering;
use App\Models\Merchant\Branch;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Cart;
use Livewire\Attributes\On;
use App\Models\MerchantChat;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;





class TemplateRouter extends Component
{
    use WithFileUploads;

    public $loginError;
    public $merchant;
    public $offers_collection;
    public $selectedOffer;

    public $step = 0;
    public $times;
    public $selectedTime;

    public $calendarDate;
    public $selectedDate;

    public $price = 0;
    public $quantity = 1;
    public $couponCode = '';
    public $coupon;
    public $finalPrice;
    public $discount = 0;
    public $stock = 10;
    public $branch;
    public $enableNext = false;
    public $selectedBranch = null;
    public $branchDetails;
    
    public $tickets;
    public $ticketTitle;
    public $ticketImage;
    public $ticketDescription;
    public $savedTicket;
    public $newTicket = null;
    public $Qa = [];
    public $f_name, $l_name, $email, $password, $password_confirmation, $country_code, $phone;

    public $LoginStep = 0;
    public $EnableLogin,$errors;

    public $Offerdiscount;
    public $PiceforView;
    //public $selectedTime;
    public $selectedHour;
    public $selectedMinute;

    public $reviews;

    public function updatedSelectedBranch($branchId)
    {
        $this->branchDetails = Branch::find($branchId);
        if ($this->branchDetails) {
            $this->enableNext = true;
        }


    }


    public function previousMonth()
    {
        $this->calendarDate = Carbon::parse($this->calendarDate)->subMonth()->toDateString();
    }

    public function nextMonth()
    {
        $this->calendarDate = Carbon::parse($this->calendarDate)->addMonth()->toDateString();
    }

    public function selectDate($date)
    {
        $date = Carbon::parse($date)->startOfDay();

        if ($this->selectedOffer->type == 'services') {
            $maxDate = isset($this->times['max_reservation_date'])
                ? Carbon::parse($this->times['max_reservation_date'])->startOfDay()
                : null;

            $today = now()->startOfDay();

            if ($date->lt($today) || ($maxDate && $date->gt($maxDate))) {
                dd('التاريخ خارج النطاق المسموح.');
                return;
            }

            $dayName = strtolower($date->format('l')); // مثل "tuesday"
            if (!array_key_exists($dayName, $this->times['data'])) {
                dd('هذا اليوم غير متاح في الجدول الزمني.');
                return;
            }

            $this->selectedDate = $date->toDateString();
            $this->enableNext = true;

            return;
        }

        // if ($this->selectedOffer->type == 'events') {
        //     $start = Carbon::parse($this->times['data'][0]["start_date"])->startOfDay();
        //     $end = Carbon::parse($this->times['data'][0]["end_date"])->startOfDay();

        //     if ($date->lt($start) || $date->gt($end)) {
        //         dd('التاريخ خارج النطاق المحدد للفعالية.');
        //         return;
        //     }

        //     $this->selectedDate = $date->toDateString();
        // }
        $this->enableNext = true; // Enable next step when a date is selected
    }


    public function selectDateE($D, $T)
    {
    
        $this->selectedDate = $D;
        $this->selectedTime = $T;

        $found = false;

        foreach ($this->times["data"] as $time) {
            
            $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $time['start_date'] . ' ' . $time['start_time']);
            $endDateTime   = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $time['end_date'] . ' ' . $time['end_time']);
            $selectedDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $D . ' ' . $T);

            if ($selectedDateTime->between($startDateTime, $endDateTime)) {
                $found = true;
                break;
            }
        }

        $this->enableNext = $found;

        if (!$found) {
            $this->addError('selectedTime', 'الوقت غير متاح ضمن الفترات المحددة.');
        }
    }


    public function loadReviews()
    {
       // $user = User::find($this->merchant->id);

        // $this->reviews = Customer_Ratings::whereHas('offer', function($q) use ($user) {
        //     $q->where('user_id', $user->id);
        // })
        // ->where('is_visible', true)
        // ->orderByDesc('created_at')
        // ->get();
        // $this->reviews = Customer_Ratings::where('is_visible', true)
        //     ->orderByDesc('created_at')
        //     ->get();
        $this->reviews = $this->merchant->reviews()
        ->where('is_visible', true)
        ->orderByDesc('created_at')
        ->take(5)
        ->get();
    }

    public function mount($merchant, $offers_collection = null)
    {
        //dd($this->merchant);
        //dd(fetch_time(33));
        //get_quantity(33);
        //dd(can_booking_now(33,1));
        //dd(get_coupons(33));
        $this->calendarDate = now()->toDateString();
        $this->loadReviews();
        //dd($this->reviews);
        $this->offers_collection = Offering::where('user_id', $this->merchant->id)->where('status', 'active')->get();
        //dd(translate("هل تود الحصول على عرض اضافي","auto" ,$target = "en"));
        //dd($this->offers_collection, $this->merchant);
    }
    public function loadQ()
    {
        if ($this->step == 5 && empty($this->Qa)) {

            $data = $this->selectedOffer->additional_data;
            $this->Qa = collect($data['questions'] ?? [])->map(function ($q) {
                return [
                    'question' => $q['question'],
                    'answer' => '',
                ];
            })->toArray();
            $this->enableNext = true;
        }
    }
    public function selectOffer($value)
    {
        // if (!Auth::guard('customer')->check()) {
        //     // dd(!Auth::guard('customer')->check());
        //     //$this->dispatch('login-error', message: 'يجب تسجيل الدخول للبدء في الحجز والشراء.');
        //     if (!(isset($this->selectedOffer) && isset($this->selectedOffer->id) && $value == $this->selectedOffer->id)) {
        //         $this->resetForm();
        //         $this->step = 0;
        //         $this->selectedOffer = Offering::find($value);
        //     }
        // } else {

            if (!(isset($this->selectedOffer) && isset($this->selectedOffer->id) && $value == $this->selectedOffer->id)) {
                $this->resetForm();
                $this->step = 0;
                $this->selectedOffer = Offering::find($value);

                //dd(can_booking_now($this->selectedOffer->id));
                $now = \Carbon\Carbon::now();
                $start = \Carbon\Carbon::parse($this->selectedOffer->features['discount_start'] ?? null);
                $end = \Carbon\Carbon::parse($this->selectedOffer->features['discount_end'] ?? null);
                $discountActive = ($this->selectedOffer->features['enable_discounts'] ?? false) 
                                  && $start && $end 
                                  && $now->between($start, $end);
                if ($discountActive) {
                    $this->Offerdiscount = $this->selectedOffer->features["discount_percent"] ?? 0;
                }
                else {
                    $this->Offerdiscount = 0;
                }
                $this->PiceforView = $this->selectedOffer->price - ($this->selectedOffer->price * ($this->Offerdiscount / 100)) ;
                //dd($this->PiceforView, $this->Offerdiscount);

            }
        //}
    }
    #[On('stepNext')]
    public function stepNext()
    {
        if ($this->step == 0 && !($this->selectedOffer->type == "services" && $this->selectedOffer->features["center"] == "place")) {
            $this->step = 2;
        } else if ($this->step == 4 && empty($this->Qa)) {
            $this->step = 5;
        } else {
            $this->step++;
        }
        if ($this->step != 4 && empty($this->Qa) ) {
            $this->enableNext = false; 
        }
        if ($this->step != 5 && !empty($this->Qa) ) {
            $this->enableNext = true; 
        }
        if ($this->step ==3 && $this->selectedOffer->type == "events"){
            $this->step +=1;
            $this->enableNext = true;

        }
        $this->Get_time();
        $this->pricing();
        $this->is_ready();
        $this->Get_Branches();
        $this->loadQ();
        if ($this->step == 7) {
            $this->save();
        }


        //logger('Current step: ' . $this->step);
    }
    public function resetForm()
    {

        $this->selectedOffer = null;
        $this->step = 0;
        $this->selectedTime = null;
        $this->selectedDate = null;
        $this->price = null;
        $this->quantity = 0;
        $this->couponCode = '';
        $this->coupon = null;
        $this->finalPrice = null;
        $this->discount = 0;
        $this->stock = null;
        $this->branch = null;
        $this->selectedBranch = null;
        $this->branchDetails = null;
        $this->selectedHour = null;
        $this->selectedMinute = null;
        $this->PiceforView = null;

        $this->times = null;
        $this->calendarDate = now()->toDateString();
    }
    public function stepBack()
    {
        if ($this->step > 0) {
            if ($this->step == 2 && !($this->selectedOffer->type == "services" && $this->branch->isNotEmpty())) {
                $this->step = 0;
                $this->enableNext = true;

            } else if ($this->step == 6 && empty($this->Qa)) {
                $this->step = 4;
            } else {
                $this->step--;
            }
            if ($this->step < 3) {
                $this->selectedTime = null;
                $this->selectedHour = null;
                $this->selectedMinute = null;
            }
            if ($this->step < 2) {
                $this->selectedDate = null;

            }
            if ($this->step == 2 && $this->selectedDate != null) {
                $this->enableNext = true; // Enable next step when a date is selected
            }
            if ($this->step == 3 && $this->selectedTime != null) {
                $this->enableNext = true; // Enable next step when a date is selected
            }
            if ($this->step == 4) {
                $this->enableNext = true; // Enable next step when a date is selected
            }
            if ($this->step ==3 && $this->selectedOffer->type == "events"){
            $this->step -=1;
            //$this->enableNext = true;

            }
            $this->Get_time();
            $this->pricing();
            $this->Get_Branches();
            $this->loadQ();
        }
    }
    public function increaseQuantity()
    {
        if ($this->quantity >= $this->stock) {
            return;
        }
        $this->quantity++;
        $this->updatePricing();
    }


    public function decreaseQuantity()
    {
        if ($this->quantity > 1 && $this->quantity <= $this->stock) {
            $this->quantity--;
            $this->updatePricing();
        }
    }
    public function updatedSelectedTime($time)
    {
        //$this->selectedTime = $time;
        $this->enableNext = true; // Enable next step when a time is selected
    }
    public function updatedSelectedHour()
    {
        $this->generateSelectedTime();
    }

    public function updatedSelectedMinute()
    {
        $this->generateSelectedTime();
    }

    public function generateSelectedTime()
    {
        if (!is_null($this->selectedHour) && !is_null($this->selectedMinute)) {
            $this->selectedTime = str_pad($this->selectedHour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($this->selectedMinute, 2, '0', STR_PAD_LEFT);
            $this->enableNext = true; 
        }
    }
    public function applyCoupon()
    {
        $coupons = collect(get_coupons($this->selectedOffer->id));

        if ($coupons->isEmpty()) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'لا توجد كوبونات متاحة لهذا العرض.',
            ]);
            return;
        }
        $coupon = $coupons->first(fn($item) => $item['code'] === $this->couponCode);

        //dd($coupon, $this->couponCode);
        if (!$coupon) {
            $this->discount = 0;
            $this->couponCode = '';

            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'الكوبون غير صالح.',
            ]);
            return;
        }

        if (\Carbon\Carbon::parse($coupon['expires_at'])->isPast()) {
            $this->discount = 0;
            $this->couponCode = '';
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'الكوبون منتهي الصلاحية.',
            ]);
            return;
        }
        $this->coupon = $coupon;
        $this->couponCode = $coupon['code'];
        $this->discount = (float) $coupon['discount'];
    }
    public function UpdateCopoun()
    {
        $this->applyCoupon();
        $this->updatePricing();
    }

    public function updatePricing()
    {

        $this->applyCoupon();
        if ($this->quantity <= 0) {
                $this->enableNext = false;
            }
        else {
            $this->enableNext = true;
        }
        $this->finalPrice = ($this->price * $this->quantity) * (1 - $this->discount / 100);
    }

    public function pricing()
    {
        if ($this->selectedOffer && $this->step === 4) {
            if ($this->quantity <= 0) {
                $this->enableNext = false;
            }
            else {
                $this->enableNext = true;
            }
            $this->price = $this->PiceforView;//$this->selectedOffer->price;
            $this->stock = get_quantity($this->selectedOffer->id, $this->selectedBranch);
            //dd(get_quantity($this->selectedOffer->id, $this->selectedBranch));
            $this->finalPrice = $this->price * $this->quantity;
        }
    }

    public function Get_time()
    {
        if ($this->step === 2) {
            $this->times = fetch_time($this->selectedOffer->id);
        }
        //dd($offer_time);
    }

    public function Get_Branches()
    {
        if ($this->step === 1) {
            $this->branch = get_branches($this->selectedOffer->id);
            if ($this->branch->count() == 1){
                $this->selectedBranch = $this->branch->first()->id;
                $this->branchDetails = Branch::find($this->selectedBranch);
                if ($this->branchDetails) {
                    $this->enableNext = true;
                }
            }
            //dd($this->branch);
        }
        //dd($offer_time);
    }
    public function ready()
    {
        // dd($this->selectedOffer ,
        // $this->selectedTime ,
        // $this->selectedDate,
        // $this->quantity ,
        // $this->finalPrice);
        if (
            $this->selectedOffer &&
            $this->selectedTime &&
            $this->selectedDate &&
            $this->quantity &&
            $this->finalPrice
        ) {
            if ($this->selectedOffer->type == 'services') {
                if ($this->selectedOffer->features["center"] == "place" && get_branches($this->selectedOffer->id)->isNotEmpty()) {
                    if (!$this->selectedBranch) {
                        $this->dispatch('alert', [
                            'type' => 'error',
                            'message' => 'يرجى اختيار فرع قبل المتابعة.',
                        ]);
                        return false;
                    }

                    if (!can_booking_now($this->selectedOffer->id, $this->selectedBranch)) {
                        $this->dispatch('alert', [
                            'type' => 'error',
                            'message' => 'لا يمكن الحجز الآن لهذا العرض.',
                        ]);
                        return false;
                    }
                } else {
                    if (!can_booking_now($this->selectedOffer->id)) {
                        $this->dispatch('alert', [
                            'type' => 'error',
                            'message' => 'لا يمكن الحجز الآن لهذا العرض.',
                        ]);
                        return false;
                    }
                }
            }

            if ($this->selectedOffer->type == 'events') {
                if (!can_booking_now($this->selectedOffer->id)) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => 'لا يمكن الحجز الآن لهذا العرض.',
                    ]);
                    return false;
                }
            }

            return true;
        }

        return false; // مهم جداً
    }

    public function is_ready()
    {
        if ($this->step == 6) {
            //dd(can_booking_now($this->selectedOffer->id, $this->selectedBranch));

            return $this->ready();
        } else {
            return false;
        }
    }
    public function save()
    {
        if ($this->ready() && $this->step == 7) {
            $user = Auth::user();
            $branchId = $this->selectedBranch ? $this->selectedBranch : null;

            // $reservation = $user->reservations()->create([
            //     'offering_id' => $this->selectedOffer->id,
            //     'branch_id' => $branchId,
            //     'quantity' => $this->quantity,
            //     'price' => $this->finalPrice,
            //     'discount' => $this->discount,
            //     'additional_data' => json_encode([
            //         'selected_date' => $this->selectedDate,
            //         'selected_time' => $this->selectedTime,
            //         'coupon_code' => $this->couponCode,
            //         'branch' => $this->selectedBranch,
            //     ])

            // ]);
            //dd(Auth::guard('merchant')->id());
            $cart = Cart::create([
                'item_id' => $this->selectedOffer->id,
                'item_type' => $this->selectedOffer->type,
                'user_id' => Auth::guard('customer')->id(),
                'quantity' => $this->quantity,
                'price' => $this->finalPrice,
                'discount' => $this->discount,
                'additional_data' => [
                    'selected_date' => $this->selectedDate,
                    'selected_time' => $this->selectedTime,
                    'coupon_code' => $this->couponCode,
                    'branch' => $branchId,
                    'Qa' => $this->Qa
                ],
            ]);


            //$this->resetForm();

            session()->flash('message', 'تم الحجز بنجاح!');
        } else {
            session()->flash('error', 'يرجى التأكد من ملء جميع الحقول المطلوبة.');
        }
    }

    public function load_chats(){
        //dd(Auth::guard('merchant')->id());
        $this->tickets = MerchantChat::where("user_id",Auth::guard('customer')->id())
        ->where("merchant_id",$this->merchant->id)
        ->get();

        //dd($tickets);

        //dd($this->merchant->additional_data);
    }
    public function add_ticket(){

        // if(!Auth::guard("customer")->user()){
        //     return;
        // }
        $this->newTicket = new MerchantChat;
    }
    public function deleteTicket($id){
        $ticket = MerchantChat::find($id);
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }

        $ticket->delete();
        $this->load_chats();

    }
    public function save_ticket(){
        if(!Auth::guard("customer")->user()){
            return;
        }
            $this->validate([
                'ticketTitle' => 'required|string|max:255',
                'ticketDescription' => 'required|string',
                'ticketImage' => 'nullable|image|max:2048', 
            ]);

            if ($this->ticketImage) {
                $imagePath = $this->ticketImage->store('tickets', 'public');
                $this->newTicket->attachment = $imagePath;
            }
            $this->newTicket->merchant_id = $this->merchant->id;
            $this->newTicket->user_id = Auth::guard('customer')->id();
            $this->newTicket->subject = $this->ticketTitle;
            //$this->newTicket->image = $this->ticketImage;
            $this->newTicket->description = $this->ticketDescription;
            // $this->newTicket->additional_data = [
            //     'status' => 'open',
            //     'priority' => 'normal',
            // ];
            $this->newTicket->save();
            $userName = Auth::guard('customer')->user()->name;
            //dd(function_exists('notifcate'));

            notifcate(
                $this->merchant->id,
                "إشعار جديد",
                "قام {$userName} بإنشاء تذكرة دعم بعنوان: {$this->ticketTitle}",
                []
            );
            notifcate(
                Auth::guard('customer')->id(),
                "تم إنشاء التذكرة بنجاح",
                "لقد أنشأت تذكرة بعنوان: {$this->ticketTitle}",
                []
            );
            $this->savedTicket = true;
            $this->load_chats();
        
    }
    public function reset_ticket(){
        $this->newTicket = null;
        $this->ticketTitle = null;
        $this->ticketImage = null;
        $this->ticketDescription = null;
        $this->savedTicket = null;
    }

    public function store()
    {
        $rules = [
            'f_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
            ],
            'l_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],

            'phone' => ['required', 'regex:/^[0-9\s-]{7,20}$/'],
        ];


        $this->validate($rules);

        $cleanPhone = preg_replace('/\D/', '', $this->phone);
        $fullPhone = $cleanPhone;


        $user = User::create([
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'phone' => $fullPhone,
            'password' => Hash::make($this->password),
            'role' => 'user',
        ]);

        //Auth::login($user);
        Auth::guard('customer')->login($user);

    }

    public function NextStepLogin(){
        if ($this->LoginStep >= 0){
            $this->LoginStep++;
            $this->CheckenableNext();
        }
        if ($this->LoginStep == 4){
            $this->store();

        }

    }

    public function BackStepLogin(){
        if ($this->LoginStep > 0){
            $this->LoginStep--;
            $this->CheckenableNext();

        }
    }


    public function CheckenableNext()
    {
        $EnableLogin = false;

        if ($this->LoginStep == 1) {
            $data = [
                'f_name' => $this->f_name,
                'l_name' => $this->l_name,
            ];

            $rules = [
                'f_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s\-]+$/u',
                ],
                'l_name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s\-]+$/u',
                ],
            ];
            $validator = Validator::make($data, $rules);

if ($validator->fails()) {
    $this->errors = $validator->errors()->toArray();
    $this->EnableLogin = false;
} else {
    $this->errors = [];
    $this->EnableLogin = true;
}
        }

        if ($this->LoginStep == 2) {
            $data = [
                'email' => $this->email,
                'phone' => $this->phone,
                //'country_code' => $this->country_code,
            ];

            $rules = [
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'max:255',
                    'unique:users,email',
                ],
                'phone' => ['required', 'regex:/^[0-9\s-]{7,20}$/'],
                // 'country_code' => [
                //     'required',
                //     'string',
                //     'regex:/^\+\d{1,4}$/',
                // ],
            ];
                    $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->toArray();
            $this->EnableLogin = false;
        } else {
            $this->errors = [];
            $this->EnableLogin = true;
        }
        }

        if ($this->LoginStep == 3) {
            $data = [
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ];

            $rules = [
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:20',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                    'confirmed',
                ],
            ];
            $validator = Validator::make($data, $rules);

if ($validator->fails()) {
    $this->errors = $validator->errors()->toArray();
    $this->EnableLogin = false;
} else {
    $this->errors = [];
    $this->EnableLogin = true;
}
        }



        //return $EnableLogin;
    }
    public function updated($propertyName)
    {
        $this->CheckenableNext();
    }

    public function render()
    {
        //dd($this->merchant);
        if ($this->step == 4) {
            $this->updatePricing();
        }
        //$this->CheckenableNext();

        //$this->load_chats();

        return view('livewire.templates.template1.index');
    }
}
