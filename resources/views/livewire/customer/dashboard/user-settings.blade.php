@php
    $image = auth()->user()->additional_data['profile_picture'] ?? null;
    $image = $image
        ? (Str::startsWith($image, 'http') ? $image : asset('storage/' . $image))
        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->f_name ?? 'U');
@endphp

<div class="space-y-8">

    <!-- صورة المستخدم -->
    <div class="flex items-center gap-4 mb-6">
        <img src="{{ $image }}" class="w-16 h-16 rounded-full border shadow">
        <div>
            <h2 class="text-lg font-semibold">{{ auth()->user()->f_name }}</h2>
            <p class="text-sm text-gray-500">إعدادات الحساب</p>
        </div>
    </div>

    <form wire:submit.prevent class="space-y-8">

        <!-- الإعدادات العامة -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-lg p-6 space-y-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">اللغة المفضلة</label>
                <select wire:model.lazy="language" class="w-full border rounded-md px-3 py-2 text-sm">
                    <option value="العربية">العربية</option>
                    <option value="English">English</option>
                </select>
            </div>

            @if(count($cards) > 0)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">بطاقة الدفع الحالية</label>
                    <select wire:model.lazy="payment_method_index" class="w-full border rounded-md px-3 py-2 text-sm">
                        @foreach($cards as $index => $card)
                            <option value="{{ $index }}">
                                {{ ($card['type'] ?? 'credit') === 'paypal' ? 'PayPal' : 'بطاقة' }}
                                •••• {{ substr($card['number'], -4) }} ({{ $card['name'] }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <label class="text-sm font-medium text-gray-700 mb-0">تنبيه عند توفر أماكن جديدة</label>
                <input type="checkbox" wire:model.lazy="availability_alert" class="form-checkbox h-5 w-5 text-blue-600" />
            </div>

            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <label class="text-sm font-medium text-gray-700 mb-0">تذكير قبل الحجز بـ 24 ساعة</label>
                <input type="checkbox" wire:model.lazy="reminder_alert" class="form-checkbox h-5 w-5 text-blue-600" />
            </div>
        </div>

        <!-- البطاقات -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-lg p-6 space-y-4">
            <h3 class="text-xl font-semibold">البطاقات المحفوظة</h3>

            <button type="button" wire:click="addEmptyCard" class="text-sm text-blue-600 hover:underline">
                + إضافة بطاقة جديدة
            </button>

            @if (!empty($cards))
                <div class="space-y-4 mt-4">
                    @foreach ($cards as $index => $card)
                        <div class="border rounded-lg p-4 bg-slate-50 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-sm">بطاقة {{ $index + 1 }}</span>
                                <button type="button" wire:click="removeCard({{ $index }})"
                                        class="text-red-500 text-xs hover:underline">حذف</button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <select wire:model.lazy="cards.{{ $index }}.type"
                                        class="border rounded px-3 py-2 text-sm">
                                    <option value="credit">بطاقة ائتمان (Visa / MasterCard)</option>
                                    <option value="paypal">PayPal</option>
                                </select>

                                <input type="text" wire:model.lazy="cards.{{ $index }}.number"
                                       placeholder="رقم البطاقة أو إيميل PayPal"
                                       class="border rounded px-3 py-2 text-sm" />

                                <input type="text" wire:model.lazy="cards.{{ $index }}.name"
                                       placeholder="اسم صاحب البطاقة" class="border rounded px-3 py-2 text-sm" />

                                <input type="date" wire:model.lazy="cards.{{ $index }}.expiry"
                                       class="border rounded px-3 py-2 text-sm sm:col-span-2" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </form>
</div>
