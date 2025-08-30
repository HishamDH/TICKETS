<div class="max-w-5xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">سلة الحجز</h2>

    @if(session()->has('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(count($carts) > 0)
    <div class="space-y-4">
        @foreach($carts as $cart)
        @php
        $data = json_decode($cart->additional_data, true);
        $coupon = null;
        $offer = \App\Models\Offering::find($cart->item_id);
        $features = $offer?->features ?? [];
        if (!empty($data['coupon_code']) && isset($features['coupons'])) {
        foreach ($features['coupons'] as $c) {
        if (strtoupper($c['code']) === strtoupper($data['coupon_code']) && now()->lte($c['expires_at'])) {
        $coupon = $c;
        break;
        }
        }
        }
        $basePrice = $cart->price + $cart->discount;
        @endphp
        <div class="border rounded-lg p-4 flex justify-start gap-6 items-center bg-white shadow-sm">
            <div>
                <img class="max-w-48 max-h-48" src="{{ Storage::url($cart->item->image) }}" alt="">
            </div>
            <div class="flex justify-between w-full">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">الخدمة: {{ class_basename($cart->item_type) }}</h3>
                    <p class="text-sm text-gray-600">التاريخ: {{ $data['selected_date'] ?? '-' }}</p>
                    <p class="text-sm text-gray-600">الوقت: {{ $data['selected_time'] ?? '-' }}</p>
                    <p class="text-sm text-gray-600">الكمية: {{ $cart->quantity }}</p>
                    <p class="text-sm text-gray-600">السعر الأساسي: {{ $basePrice }} ر.س</p>
                    @if($coupon)
                    <p class="text-sm text-green-600">كود الخصم: {{ $coupon['code'] }} - خصم {{ $coupon['discount'] }}%</p>
                    <p class="text-sm text-gray-800 font-bold">السعر بعد الخصم: {{ $cart->price }} ر.س</p>
                    @else
                    <p class="text-sm text-gray-800 font-bold">السعر النهائي: {{ $cart->price }} ر.س</p>
                    @endif
                </div>
                <div>
                    <button wire:click="removeItem('{{ $cart->id }}')" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 font-semibold">حذف</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-right text-xl font-bold mt-6 text-gray-800">
        الإجمالي: <span class="text-green-600">{{ $totalPrice }}</span> ر.س
    </div>


    <div class="mt-6 text-right">
        <a href="{{ route('template1.checkout.paid',['id'=>$merchant->id]) }}"
            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-bold">إتمام الدفع
        </a>
    </div>

    @else
    <div class="text-center text-gray-600">
        لا توجد حجوزات في السلة حالياً.
    </div>
    @endif
</div>
