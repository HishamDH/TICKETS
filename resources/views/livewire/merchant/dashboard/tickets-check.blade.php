<div class="grid lg:grid-cols-2 gap-8">

    {{-- Manual Verification --}}

    @php
        if($merchantid){
            $hasTicketsCheckPermission = has_Permetion(Auth::id(),'check_tickets', $merchantid);

        }else {
            $hasTicketsCheckPermission = true;
        }
    @endphp
    <div class="rounded-2xl border border-slate-200 bg-white shadow-lg p-6">
        <h3 class="text-xl font-semibold mb-2">التحقق اليدوي</h3>
        <p class="text-sm text-slate-500 mb-4">أدخل رقم التذكرة أو الحجز للتحقق من صلاحيته.</p>
        <input wire:model.defer="code"
            class="w-full rounded-lg border border-slate-300 px-4 py-2 mb-2 focus:ring-2 focus:ring-orange-500"
            placeholder="أدخل رقم التذكرة...">
        @if ($hasTicketsCheckPermission)
            <button wire:click="check"
                class="w-full bg-orange-500 text-white rounded-lg py-2 font-bold hover:bg-orange-600 transition">
                تحقق الآن
            </button> 
        @else
            <button
                class="w-full bg-gray-300 text-gray-600 rounded-lg py-2 font-bold cursor-not-allowed">
                لا تملك صلاحية التحقق
            </button>
        @endif

        @if($reservation)
        @php
            $arr = json_decode($reservation->additional_data, true) ?? [];
            //dd($arr);
        @endphp
        <div class="lg:col-span-2 mt-8 bg-white border rounded-lg shadow p-6">
            <h4 class="text-lg font-bold text-orange-600 mb-4">بيانات التذكرة</h4>
            <p><span class="font-semibold">الكود:</span> {{ $reservation->code }}</p>
            <p><span class="font-semibold">الخدمة:</span> {{ $reservation->offering->name ?? 'غير متوفر' }}</p>
            <p><span class="font-semibold">السعر:</span> {{ $reservation->price }} ريال</p>
            <p><span class="font-semibold">الكمية:</span> {{ $reservation->quantity }}</p>
            <p><span class="font-semibold">الحالة:</span> {{ $arr['paymentMethod'] ?? 'غير محدد' }}</p>
        
            <hr class="my-4">


            {{-- عرض بيانات إضافية --}}
    <h5 class="font-bold text-gray-700 mb-2">بيانات إضافية:</h5>
    <p><span class="font-semibold">التاريخ:</span> {{ $arr['selected_date'] ?? '-' }}</p>
    <p><span class="font-semibold">الوقت:</span> {{ $arr['selected_time'] ?? '-' }}</p>
    <p><span class="font-semibold">كود الخصم:</span> {{ $arr['coupon_code'] ?: 'لا يوجد' }}</p>
    <p><span class="font-semibold">الفرع:</span> {{ $arr['branch'] ?? 'غير محدد' }}</p>

    {{-- عرض مصفوفة Qa بشكل مرتب --}}
@if(!empty($arr['Qa']) && is_array($arr['Qa']))
    <div class="mt-2">
        <span class="font-semibold">أسئلة إضافية:</span>
        <ul class="list-disc list-inside ml-4">
            @foreach($arr['Qa'] as $qaItem)
                <li>
                    <span class="font-semibold">{{ $qaItem['question'] ?? '-' }}:</span>
                    {{ $qaItem['answer'] ?? '-' }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

        </div>
        @endif
        @if ($error)
        <div class="mt-4 text-red-600">{{ $error }}</div>
        @endif
    </div>

    {{-- QR Code Scanner --}}
    <div class="rounded-2xl border border-slate-200 bg-slate-50 border-dashed shadow-lg p-6 text-center">
        <h3 class="text-xl font-semibold mb-4">مسح الكود</h3>

        <div id="qr-reader" class="w-full rounded-lg bg-black aspect-video mb-4"></div>
        <div id="qr-result" class="hidden text-green-600 font-semibold mb-2">تم مسح الكود بنجاح!</div>
        @if ($hasTicketsCheckPermission)
            <button id="start-scanner"
                class="border bg-white hover:bg-slate-100 rounded-lg py-2 px-4 font-bold">
                فتح الكاميرا للمسح
            </button>
            <button id="stop-scanner"
                class="hidden border bg-red-500 text-white hover:bg-red-600 rounded-lg py-2 px-4 font-bold">
                إيقاف المسح
            </button>
        @else
            <button
                class="border bg-gray-300 text-gray-600 rounded-lg py-2 px-4 font-bold cursor-not-allowed">
                لا تملك صلاحية المسح
            </button>
        @endif


    </div>

    {{-- Display verification results --}}


</div>

@push('scripts')
{{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

<script src="https://unpkg.com/html5-qrcode"></script>


<script>
    let qrScanner = null;

    function setupScanner() {
        const startBtn = document.getElementById('start-scanner');
        const stopBtn = document.getElementById('stop-scanner');
        const qrResult = document.getElementById('qr-result');

        startBtn?.removeEventListener('click', startScanner);
        stopBtn?.removeEventListener('click', stopScanner);

        startBtn?.addEventListener('click', startScanner);
        stopBtn?.addEventListener('click', stopScanner);

        function startScanner() {
            if (qrScanner) return;

            qrScanner = new Html5Qrcode("qr-reader");

            qrScanner.start({
                        facingMode: "environment"
                    }, {
                        fps: 60,
                        qrbox: 250
                    },
                    (decodedText) => {
                        qrResult?.classList.remove('hidden');
                        stopScanner();
                        Livewire.dispatch('qr-scanned', {
                            code: decodedText
                        });
                    },
                    (errorMessage) => {
                        console.log(errorMessage);
                    })
                .then(() => {
                    startBtn?.classList.add('hidden');
                    stopBtn?.classList.remove('hidden');
                })
                .catch((err) => {
                    console.error(err);
                });
        }

        function stopScanner() {
            if (qrScanner) {
                qrScanner.stop().then(() => {
                    qrScanner = null;
                    startBtn?.classList.remove('hidden');
                    stopBtn?.classList.add('hidden');
                }).catch(console.error);
            }
        }
    }
    document.addEventListener('DOMContentLoaded', setupScanner);

    document.addEventListener('livewire:init', setupScanner);
    document.addEventListener('livewire:navigated', setupScanner);
    document.addEventListener('livewire:navigating', () => {
        if (qrScanner) {
            qrScanner.stop().catch(console.error);
            qrScanner = null;
        }
    });
</script>
@endpush
