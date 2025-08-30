<div class="max-w-7xl mx-auto grid grid-cols-1
@if ($selectedDate != null)
lg:grid-cols-3
@else
lg:grid-cols-2
@endif
 gap-6 py-10 px-4">

    <!-- تفاصيل العرض -->
    <div class="col-span-1">
        <img src="{{ Storage::url($offer->image ?? '/img/ad-placeholder.jpg') }}" alt="عرض" class="rounded-lg w-full h-40 object-cover">
        <h2 class="text-xl font-bold">{{ $offer->name }}</h2>
        <p class="text-sm text-gray-600">{{ $offer->description }}</p>

        <!-- عدد الأشخاص -->
        <div class="flex items-center gap-2 mt-4">
            <span>عدد:</span>
            <button wire:click="subNumber" class="px-3 py-1 border rounded">-</button>
            <input wire:model="count" type="number" min="1" class="w-12 text-center border rounded" value="1">
            <button wire:click="addNumber" class="px-3 py-1 border rounded">+</button>
        </div>

        <!-- كود الكوبون -->
        @if ($offer->features['enable_coupons'] ?? false)
        <div class="mt-4">
            <label class="block text-sm">كود الخصم:</label>
            <input type="text" wire:model.lazy="couponCode" wire:change="calcPrice" class="w-full border rounded px-3 py-2 mt-1">
        </div>
        @endif

        <!-- السعر -->
        <div class="text-right mt-4">

            <p class="text-2xl font-bold text-orange-600"><apsn class="text-sm text-gray-500 line-through">{{ $offer->price }} ريال</apsn> {{ $price }} ريال</p>
        </div>
    </div>

    <!-- التقويم -->
    <div class="text-center">
        <div class="flex justify-between items-center mb-4">
            <button wire:click="prevMonth" class="px-3 py-1 bg-gray-100 rounded">الشهر السابق</button>
            <span class="text-xl font-bold">{{ $date->translatedFormat('F Y') }}</span>
            <button wire:click="nextMonth" class="px-3 py-1 bg-gray-100 rounded">الشهر التالي</button>
        </div>

        <div class="grid grid-cols-7 gap-2 text-sm">
            <div>سبت</div>
            <div>أحد</div>
            <div>إثنين</div>
            <div>ثلاثاء</div>
            <div>أربعاء</div>
            <div>خميس</div>
            <div>جمعة</div>

            @php $shift = ($firstDayIndex + 1) % 7; @endphp
            @for($i = 0; $i < $shift; $i++) <div>
        </div> @endfor

        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
            $fullDate=\Carbon\Carbon::create($date->year, $date->month, $day)->toDateString();
            $isAvailable = $availableDays !=[]?in_array($fullDate, $availableDays):($fullDate >= now()->toDateString()? true : false);
            @endphp
            <button wire:click="selectDate({{ $day }})"
                class="p-2 rounded {{ $isAvailable ? (isset($selectedDate) && \Carbon\Carbon::parse($selectedDate)->format('d') == $day ? 'bg-black text-white cursor-pointer' : 'bg-white hover:bg-black hover:text-white cursor-pointer') : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
                {{ $day }}
            </button>
            @endfor
    </div>
</div>

<!-- أوقات الحجز -->
@if ($selectedDate != null)
<div class="col-span-1">
    <h3 class="font-bold text-lg mt-4">
        {{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->translatedFormat('l d') : 'اختر تاريخ أولاً' }}
    </h3>
    <div class="grid grid-cols-2 gap-2 mt-2">
        @foreach($timeSlots as $time)
            @php $isAvailable = $this->checkTime($time); @endphp
        <button wire:click="selectTime('{{ $time }}')"
        class="{{ $time == $selectedTime ? 'bg-black text-white' : ($isAvailable ? 'hover:bg-gray-100' : 'bg-gray-200 text-gray-400 cursor-not-allowed') }} border px-4 py-2 rounded">
            {{ Carbon\Carbon::parse(now()->format('Y-m-d ').$time)->translatedFormat("h:i A") }}
        </button>
        @endforeach
    </div>

    <button wire:click="addToCart" class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-full font-bold">
        احجز الآن
    </button>
</div>
@endif

</div>
