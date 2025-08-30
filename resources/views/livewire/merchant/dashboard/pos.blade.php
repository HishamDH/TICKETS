<div class="flex justify-center mt-8">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl p-10 space-y-8" dir="rtl">
        <h2 class="text-3xl font-bold text-center text-slate-800">نظام البيع الداخلي - إنشاء حجز</h2>

        {{-- اختيار الخدمة --}}
        <div>
            <label class="block mb-2">الخدمة <span class="text-red-600"><b>*</b></span></label>
            <select wire:model.lazy="selectedOfferingId" class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
                <option value="">اختر الخدمة...</option>
                @foreach($offerings as $offering)
                <option value="{{ $offering->id }}">{{ $offering->name }}</option>
                @endforeach
            </select>
        </div>

        @if($selectedOfferingId)

        {{-- التاريخ --}}
        @if(count($allowedDates))
        <div>
            <label class="block mb-2">تاريخ الحجز <span class="text-red-600"><b>*</b></span></label>
            <select wire:model.lazy="selectedDate" class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
                <option value="">اختر تاريخ</option>
                @foreach($allowedDates as $date)
                <option value="{{ $date }}">{{ $date }}</option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- الوقت --}}
        @php
        $times = fetch_time($this->selectedOfferingId);
        //dd($times['data'][0]['end_date']);

        @endphp
        
        @if ($selectedOffering->type == 'events')
        
        <div class="space-y-4">
            <div>
                <label class="block mb-2 font-semibold">تاريخ الحجز <span class="text-red-600"><b>*</b></span></label>
                <input type="date"
                    wire:model.lazy="selectedDate"
                    @if( isset($times['data'][0]) && $times['data'][0]['start_date']??false) min="{{ $times['data'][0]['start_date'] }}" @endif
                    @if(isset($times['data'][0]) && $times['data'][0]['end_date']??false) max="{{ $times['data'][0]['end_date'] }}" @endif
                    class="w-full rounded-md border border-slate-300 px-4 py-2" required>
                @if(isset($times['data'][0]) && $times['data'][0]['start_date']??false && $times['data'][0]['end_date']??false)
                <p class="text-xs text-slate-500 mt-1">
                    متاح من {{ $times['data'][0]['start_date'] }} إلى {{ $times['data'][0]['end_date'] }}
                </p>
                @endif
            </div>

            <div>
                <label class="block mb-2 font-semibold">وقت الحجز <span class="text-red-600"><b>*</b></span></label>
                <input type="time"
                    wire:model.lazy="selectedTime"
                    @if( isset($times['data'][0]) && $times['data'][0]['start_time']??false) min="{{ $times['data'][0]['start_time'] }}" @endif
                    @if(isset($times['data'][0]) && $times['data'][0]['end_time']??false) max="{{ $times['data'][0]['end_time'] }}" @endif
                    class="w-full rounded-md border border-slate-300 px-4 py-2" required>
                @if(isset($times['data'][0]) && $times['data'][0]['start_time']??false && $times['data'][0]['end_time']??false)
                <p class="text-xs text-slate-500 mt-1">
                    متاح بين {{ $times['data'][0]['start_time'] }} و {{ $times['data'][0]['end_time'] }}
                </p>
                @endif
            </div>
        </div>
        @endif

        @if ($selectedOffering->type == 'services')
        <div class="space-y-4">

            <div>
                <label class="block mb-2 font-semibold">اختر اليوم <span class="text-red-600"><b>*</b></span></label>
                <select wire:model.lazy="selectedDay" class="w-full rounded-md border border-slate-300 px-4 py-2" required>
                    <option value="">-- اختر يوم --</option>
                    @foreach($times['data'] as $day => $data)
                    @if($data['enabled'])
                    <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            @if ($selectedDay && isset($times['data'][$selectedDay]))
            <div>
                <label class="block mb-2 font-semibold">وقت الحجز لـ {{ ucfirst($selectedDay) }}</label>
                <input
                    type="time"
                    wire:model.lazy="selectedTime"
                    min="{{ $times["data"][$selectedDay]['from'] }}"
                    max="{{ $times['data'][$selectedDay]['to'] }}"
                    class="w-full rounded-md border border-slate-300 px-4 py-2" required>

                <p class="text-sm text-slate-500 mt-1">
                    الوقت المسموح: {{ $times['data'][$selectedDay]['from'] }} - {{ $times['data'][$selectedDay]['to'] }}
                </p>
            </div>
            @endif
        </div>

        @endif

        {{-- toggle slide للباقة --}}
        @if(count($pricingPackages))
        <div class="flex items-center justify-between mt-4">
            <span class="text-sm font-medium">تفعيل الباقة</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="showPackage" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-orange-500 peer-focus:ring-2 peer-focus:ring-orange-300 transition duration-300"></div>
                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full shadow transition duration-300 peer-checked:translate-x-5"></div>
            </label>
        </div>
        @endif

        {{-- الباقات (تظهر فقط لو مفعّل toggle) --}}
        @if($showPackage)
        <div class="mt-4">
            <label class="block mb-2">اختر الباقة <span class="text-red-600"><b>*</b></span></label>
            <select wire:model.lazy="selectedPackage" class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
                <option value="">اختر باقة</option>
                @foreach($pricingPackages as $package)
                <option value="{{ $package['label'] }}">
                    {{ $package['label'] }} - {{ $package['price'] }} ريال
                </option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- عدد الأشخاص (يختفي لو الباقة مفعّلة) --}}
        @if(!$showPackage)
        <div class="mt-4">
            <label class="block mb-2">عدد التذاكر / الأشخاص <span class="text-red-600"><b>*</b></span></label>
            <input type="number" wire:model.lazy="tickets" min="1"
                class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
        </div>
        @endif

        {{-- طريقة الدفع --}}
        <div class="mt-4">
            <label class="block mb-2">طريقة الدفع <span class="text-red-600"><b>*</b></span></label>
            <select wire:model.lazy="paymentMethod" class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
                <option value="">اختر طريقة الدفع</option>
                <option value="cash">نقدًا عند الحضور</option>
                <option value="free">مجاني</option>
            </select>
        </div>

        {{-- السعر (يظهر فقط لو الدفع نقداً + ما في باقة) --}}
        @if($paymentMethod === 'cash' && !$showPackage)
        <div class="mt-4">
            <label class="block mb-2">السعر <span class="text-red-600"><b>*</b></span></label>
            <input type="number" wire:model.lazy="manualPrice" min="0"
                class="w-full rounded-lg border border-slate-300 px-4 py-3" required>
        </div>
        @endif

        <div class="mt-4">
            <label class="block mb-2">رقم الجوال <span class="text-red-600"><b>*</b></span></label>
            <input type="email" wire:model.lazy="customerPhone"
                class="w-full rounded-lg border border-slate-300 px-4 py-3"
                placeholder="05xxxxxxxx" required>
        </div>

        @if($foundUser)
        <div class="flex items-center gap-4 bg-slate-100 p-4 rounded-lg mt-2">
            <img src="{{ Storage::url($foundUser['profile_image']) }}" class="w-12 h-12 rounded-full">
            <div>
                <div class="font-bold">{{ $foundUser['name'] }}</div>
                <div class="text-slate-500">{{ $foundUser['email'] }}</div>
            </div>
        </div>
        @endif

        {{-- الاسم والجوال --}}
        @if($customerPhone)
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block mb-2">اسم الزبون <span class="text-red-600"><b>*</b></span></label>
                <input type="text" wire:model.lazy="customerName"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3">
            </div>
            <div>
                <label class="block mb-2">الايميل</label>
                <input type="text" wire:model.lazy="customerEmail"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3"
                    placeholder="email@example.com">
            </div>
        </div>
        @endif

        <button wire:click="createBooking"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white rounded-lg py-3 font-bold mt-4">
            إنشاء الحجز
        </button>

        @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 rounded-lg p-4 text-center mt-4">
            {{ session('success') }}
        </div>
        @endif

        @if (session()->has('error'))
        <div class="bg-red-100 text-red-800 rounded-lg p-4 text-center mt-4">
            {{ session('error') }}
        </div>
        @endif

        @endif
    </div>
</div>
