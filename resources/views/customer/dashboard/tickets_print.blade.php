@extends('customer.layouts.app')

@section('content')
<div class="opacity-100">
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">تذاكري وبادجاتي</h1>
            <p class="text-slate-500 mt-1">عرض وطباعة تذاكرك الصالحة.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($Reservations as $reservation)
                @php
                    $offering = $reservation->offering;
                    $code = $reservation->code;
                    $name = $offering->name ?? '—';
                    $image = $offering->image ?? null;
                    $time = $offering->start_time ? \Carbon\Carbon::parse($offering->start_time)->format('Y-m-d H:i') : null;
                @endphp

                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="p-4 bg-slate-100 border-b">
                        <h3 class="font-bold text-lg text-center">{{ $name }}</h3>
                        <p class="text-sm text-slate-500 text-center">
                            {{ $reservation->item_type === 'event' ? 'تذكرة دخول' : 'تأكيد حجز' }}
                        </p>
                    </div>
                    <div class="p-4 space-y-4">
                        @if ($image)
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/' . $image) }}" alt="صورة العرض" class="w-full h-48 object-cover rounded-md shadow">
                            </div>
                        @endif

                        @if ($time)
                            <div class="text-sm text-center text-slate-700">
                                <span class="font-medium">الوقت:</span> {{ $time }}
                            </div>
                        @endif

                        <div class="flex gap-2 pt-2">
                            <button onclick="printTicket(`{{ $code }}`, `{{ $name }}`, `{{ $image ? asset('storage/' . $image) : '' }}`)"
                                class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 h-10 px-4 py-2 w-full shadow">
                                🖨️ طباعة
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
async function printTicket(code, serviceName) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(16);
    doc.text("Service: " + serviceName, 20, 30);
    doc.text("Code: " + code, 20, 40);

    const qrDiv = document.createElement('div');
    new QRCode(qrDiv, {
        text: code,
        width: 120,
        height: 120,
        correctLevel: QRCode.CorrectLevel.H
    });

    const canvas = qrDiv.querySelector('canvas');
    const imgData = canvas.toDataURL('image/png');

    doc.addImage(imgData, 'PNG', 20, 50, 60, 60); // يمكن تغيير الحجم حسب الحاجة

    doc.autoPrint();
    window.open(doc.output('bloburl'), '_blank');
}
</script>
@endsection