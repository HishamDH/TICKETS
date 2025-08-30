<form  class="space-y-8">

    {{-- السعر الأساسي --}}
    <div>
        <label class="block text-sm font-medium mb-1">السعر الأساسي <span class="text-red-500" style="font-weight: bold;">*</span></label>
        <input type="number" step="0.01" wire:model.lazy="base_price" class="w-full border rounded-md p-2">
    </div>

    {{-- توجل: التسعير بالساعات --}}
    {{-- <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تفعيل التسعير بالساعات؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_hourly_pricing" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_hourly_pricing)
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">السعر لكل ساعة</label>
                <input type="number" step="0.01" wire:model.lazy="hourly_rate" class="w-full border rounded-md p-2">
            </div>
        @endif
    </div> --}}

    {{-- توجل: تفعيل الكوبونات --}}
    <div class="flex items-center justify-between">
        <label class="text-sm font-medium">السماح باستخدام كوبونات؟</label>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" wire:model.lazy="enable_coupons" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
        </label>

    </div>
    @if ($enable_coupons)
    <div class="mt-4 space-y-3">
        @foreach ($coupons as $index => $coupon)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                <input type="text" wire:model.lazy="coupons.{{ $index }}.code" placeholder="كود الكوبون" class="border p-2 rounded-md">
                <input type="number" wire:model.lazy="coupons.{{ $index }}.discount" max="100" placeholder="الخصم (%)" class="border p-2 rounded-md">
                <input type="date" wire:model.lazy="coupons.{{ $index }}.expires_at" class="border p-2 rounded-md">
                <button type="button" wire:click="removeCoupon({{ $index }})" class="text-red-500 hover:underline text-sm">حذف</button>
            </div>
        @endforeach
        <button type="button" wire:click="addCoupon" class="text-blue-600 hover:underline text-sm">+ إضافة كوبون</button>
    </div>
@endif

    {{-- توجل: تفعيل الخصومات --}}
    <div class="space-y-3">
        {{-- Toggle --}}
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">السماح باستخدام خصومات؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_discounts" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>

        {{-- إذا كان الخصم مفعل --}}
        @if ($enable_discounts)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">بداية الخصم</label>
                    <input type="datetime-local" wire:model.lazy="discount_start" class="w-full border rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">نهاية الخصم</label>
                    <input type="datetime-local" wire:model.lazy="discount_end" class="w-full border rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">نسبة الخصم (%)</label>
                    <input type="number" wire:model.lazy="discount_percent" class="w-full border rounded-md p-2" min="1" max="100">
                </div>
            </div>
        @endif
    </div>


    {{-- توجل: السماح بالإلغاء --}}
    {{-- <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">السماح بإلغاء الحجز؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_cancellation" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
    </div> --}}

    {{-- توجل: رسوم الإلغاء --}}
    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تفعيل الالغاء ؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_cancellation" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_cancellation)
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">رسوم الالغاء (با المئة ) %</label>
                <input type="number" step="0.01" wire:model.lazy="cancellation_fee" class="w-full border rounded-md p-2">
            </div>
            <label class="text-sm font-medium">تحديد آخر وقت للإلغاء؟</label>

            <div class="mt-2">
                {{-- <label class="block text-sm font-medium mb-1">عدد الدقائق قبل البدء</label> --}}
                <input type="number" wire:model.lazy="cancellation_deadline_minutes" placeholder="عدد الدقائق قبل البدء" class="w-full border rounded-md p-2">
            </div>
        @endif

    </div>

    {{-- توجل: الأجل الأخير للإلغاء --}}
    {{-- <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تحديد آخر وقت للإلغاء؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_cancellation_deadline" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_cancellation_deadline)
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">عدد الدقائق قبل البدء</label>
                <input type="number" wire:model.lazy="cancellation_deadline_minutes" class="w-full border rounded-md p-2">
            </div>
        @endif
    </div> --}}

    {{-- توجل: تسعير حسب عدد الأشخاص --}}
    <div>
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium">تفعيل الباقات ؟</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.lazy="enable_pricing_packages" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-full transition-all"></div>
            </label>
        </div>
        @if ($enable_pricing_packages)
            <div class="mt-4 space-y-3">
                @foreach ($pricing_packages as $index => $pkg)
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model.lazy="pricing_packages.{{ $index }}.label" placeholder="مثال: شخص واحد" class="flex-1 border p-2 rounded-md">
                        <input type="number" step="0.01" wire:model.lazy="pricing_packages.{{ $index }}.price" placeholder="السعر" class="w-32 border p-2 rounded-md">
                        <button type="button" wire:click="removePackage({{ $index }})" class="text-red-500 hover:underline text-sm">حذف</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addPackage" class="text-blue-600 hover:underline text-sm">+ إضافة باقة</button>
            </div>
        @endif
    </div>

</form>
