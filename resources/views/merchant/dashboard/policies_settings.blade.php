@extends('merchant.layouts.app',["merchant" => $merchantid ?? false])
@section('content')

<div class="flex-1 p-8">
    <div class="space-y-8">
        <!-- العنوان والزر -->
        @php
        if($merchantid){
            $hasEditPermission = has_Permetion(Auth::id(),'policies_edit', $merchantid);

        }else {
            $hasEditPermission = true;
        }
        @endphp
        <form action="{{isset($merchantid) ? route('merchant.dashboard.m.policies_settings.store',["merchant"=>$merchantid]) : route('merchant.dashboard.policies_settings.store') }}" method="POST">
            @csrf
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-slate-800">السياسات والإعدادات</h2>
                @if ($hasEditPermission)
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 shadow-md transition">
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    حفظ الإعدادات
                </button>
                @else
                <button class="inline-flex items-center justify-center rounded-lg bg-gray-300 text-gray-500 font-semibold px-5 py-2.5 shadow-md transition cursor-not-allowed" disabled>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    لاتملك الصلاحية
                </button>

                @endif

            </div>

            <!-- سياسة الإلغاء -->
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16v16H4z" />
                        </svg>
                        سياسة الإلغاء والاسترجاع
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">حدد الشروط التي يمكن للعملاء بموجبها إلغاء حجوزاتهم واسترداد أموالهم.</p>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="cancellation-policy" class="block text-sm font-medium mb-2">نص السياسة</label>
                        <textarea id="cancellation-policy" wire:model="cancellationPolicy" name="policies" class="w-full rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 px-4 py-2 text-sm min-h-[120px]" placeholder="مثال: لا يمكن استرجاع المبلغ قبل 24 ساعة من موعد الفعالية...">{{ old('policies', $user->additional_data['policies'] ?? '') }}</textarea>
                    </div>
                    <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">السماح بالاسترجاع التلقائي</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="allow_refund" value="1" class="sr-only peer" id="allow-refund"
                                {{ old('allow_refund', $user->additional_data['allow_refund'] ?? false) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-orange-500 transition"></div>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full peer-checked:translate-x-5 transition"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- إعدادات الدفع -->
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl mt-6">
                <div class="p-6 border-b">
                    <h3 class="text-xl font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M2 7h20M2 11h20M2 15h20" />
                        </svg>
                        إعدادات الدفع
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">اختر وسائل الدفع التي ترغب في توفيرها لعملائك.</p>
                </div>
                <div class="p-6 space-y-4">
                    @php
                    $payments = [
                    ['id' => 'visa-mastercard', 'label' => 'بطاقات فيزا وماستركارد'],
                    ['id' => 'mada', 'label' => 'مدى'],
                    ['id' => 'apple-pay', 'label' => 'Apple Pay'],
                    ['id' => 'stc-pay', 'label' => 'STC Pay'],
                    ];
                    @endphp

                    @foreach ($payments as $payment)
                    <div class="flex items-center justify-between bg-slate-50 p-3 rounded-lg">
                        <span class="text-sm font-medium text-gray-700">{{ $payment['label'] }}</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="payments[]" value="{{ $payment['id'] }}" class="sr-only peer"
                                {{ in_array($payment['id'], old('payments', $user->additional_data['payments'] ?? [])) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-orange-500 transition"></div>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full peer-checked:translate-x-5 transition"></div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')

<script>
    document.addEventListener("livewire:navigated", () => {
        initTiny();
    });

    document.addEventListener("livewire:load", () => {
        initTiny();
    });

    function initTiny() {
        // if (!tinymce.get("cancellation-policy")) {
        //     tinymce.get("cancellation-policy").remove();
        // }

        tinymce.init({ selector: '#cancellation-policy', height: 300, menubar: false, plugins: 'lists link image preview code', toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | preview code' });
    
    }
</script>

@endpush
