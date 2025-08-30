@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])

@section('content')
<div class="flex-1 p-6 md:p-10 bg-orange-50 min-h-screen">

    <!-- زر الرجوع -->
    <div class="mb-6">
        <a href="{{ isset($merchantid) ? route('merchant.dashboard.m.pos.index',["merchant" => $merchantid]) :route('merchant.dashboard.pos.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow-md transition duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            رجوع
        </a>
    </div>

    <!-- كارت العرض الرئيسي -->
    <div id="reservation-details" class="max-w-4xl mx-auto bg-white border-4 border-orange-400 rounded-3xl shadow-2xl p-8 space-y-10">

        <!-- العنوان -->
        <div class="text-center space-y-2">
            <h2 class="text-4xl font-extrabold text-orange-700 animate-pulse">تفاصيل الحجز</h2>
            <p class="text-slate-500">عرض جميع التفاصيل الخاصة بالحجز</p>
        </div>

        <!-- بيانات المستخدم -->
        <div class="flex flex-col md:flex-row items-center gap-8 border-b border-orange-200 pb-8">
            <div>
                @php
                    $userImage = $reservation->user->additional_data["profile_picture"] ?? null;
                @endphp
                @if($userImage)
                    <img src="{{ asset('storage/' . $userImage) }}" alt="صورة المستخدم"
                         class="w-40 h-40 rounded-full object-cover shadow-lg ring-4 ring-orange-300">
                @else
                    <div class="w-40 h-40 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-6xl font-bold shadow-lg ring-4 ring-orange-300">
                        {{ mb_substr($reservation->user->f_name ?? '؟', 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 space-y-2 text-center md:text-right">
                <h3 class="text-3xl font-bold text-orange-800">{{ $reservation->user->f_name ?? 'غير متوفر' }}</h3>
                <p class="text-slate-500">📞 {{ $reservation->user->phone ?? 'غير متوفر' }}</p>
                <p class="text-slate-500">📧 {{ $reservation->user->email ?? 'غير متوفر' }}</p>
            </div>
        </div>

        <!-- بيانات العرض / الخدمة -->
        <div class="space-y-4 border-b border-orange-200 pb-8">
            <h4 class="text-2xl font-bold text-orange-700">معلومات العرض / الخدمة</h4>
            <div class="flex flex-col md:flex-row gap-6">
                @if($reservation->offering && $reservation->offering->image)
                <img src="{{ asset('storage/' . $reservation->offering->image) }}" alt="صورة العرض"
                     class="w-full md:w-64 h-40 object-cover rounded-xl shadow-md ring-2 ring-orange-200">
                @endif
                <div class="flex-1 space-y-1 text-slate-700">
                    <p><span class="font-semibold text-orange-600">الاسم:</span> {{ $reservation->offering->name ?? 'غير متوفر' }}</p>
                    <p><span class="font-semibold text-orange-600">الوصف:</span> {{ $reservation->offering->description ?? 'لا يوجد وصف' }}</p>
                    <p><span class="font-semibold text-orange-600">السعر الأساسي:</span> {{ $reservation->offering->price ?? 'غير متوفر' }} ريال</p>

                    @php
                        $features = $reservation->offering->features ?? [];
                    @endphp

                    @if($features)
                        <ul class="list-disc list-inside space-y-1 text-slate-600 mt-2">
                            <li>المدة المحجوزة: {{ $features['booking_duration'] ?? 'غير محددة' }} دقيقة</li>
                            <li>الحد الأقصى للمستخدمين: {{ $features['user_limit'] ?? 'غير متوفر' }}</li>
                            <li>السعر الأساسي: {{ $reservation->offering->price?? 'غير متوفر' }} ريال</li>
                        </ul>

                        @if(!empty($features['pricing_packages']))
                        <div class="mt-2">
                            <p class="font-semibold text-orange-600">الباقات:</p>
                            <ul class="list-disc list-inside">
                                @foreach($features['pricing_packages'] as $pkg)
                                    <li>{{ $pkg['label'] ?? 'بلا اسم' }} - {{ $pkg['price'] ?? '0' }} ريال</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(!empty($features['work_schedule']))
                        <div class="mt-2">
                            <p class="font-semibold text-orange-600">مواعيد العمل:</p>
                            <ul class="list-disc list-inside">
                                @foreach($features['work_schedule'] as $day => $schedule)
                                    @if($schedule['enabled'])
                                    <li>{{ ucfirst($day) }}: {{ $schedule['start'] ?? '?' }} - {{ $schedule['end'] ?? '?' }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- بيانات الحجز -->
        <div class="space-y-4">
            <h4 class="text-2xl font-bold text-orange-700 mb-4">معلومات الحجز</h4>
            
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- QR CODE -->
                <div id="qrcode" class="flex-shrink-0"></div>
                
                <!-- بيانات الحجز -->
                <div class="flex-1 text-slate-700 space-y-2">
                    <p><span class="font-semibold text-orange-600">رقم الحجز:</span> {{ $reservation->id }}</p>
                    <p><span class="font-semibold text-orange-600">المبلغ:</span> {{ $reservation->price ?? '0.00' }} ريال</p>
                    <p><span class="font-semibold text-orange-600">رمز القسيمة :</span> {{ $reservation->code }}</p>
                    <p><span class="font-semibold text-orange-600">تاريخ الإنشاء:</span> {{ $reservation->created_at->format('Y-m-d H:i') }}</p>
        
                    @php
                        $add = json_decode($reservation->additional_data, true);
                    @endphp
        
                    <p><span class="font-semibold text-orange-600">التاريخ المحجوز:</span> {{ $add['selected_day'] }}</p>
                    <p><span class="font-semibold text-orange-600">الوقت المحجوز:</span> {{ $add['selected_time']  }}</p>
                </div>
            </div>
        </div>
        
    <!-- زر تحميل PDF -->
    <div class="mb-4 text-right">
        <button
            onclick="downloadPDF()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white text-sm font-semibold shadow-md transition duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            تحميل كـ PDF
        </button>
    </div>

    </div>
</div>
<script>
    function downloadPDF() {
        const element = document.getElementById('reservation-details');


        html2pdf()
    .set({
        margin: 0.5,
        filename: "{{ $reservation->code }}.pdf",
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    })
    .from(document.getElementById('reservation-details'))
    .save();

    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $reservation->code }}",
            width: 200,
            height: 200
        });
    });
</script>


@endsection
