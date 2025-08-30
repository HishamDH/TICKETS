@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])

@section('content')
<div class="flex-1 p-6 md:p-10 bg-orange-50 min-h-screen">

    <!-- Back button -->
    <div class="mb-6">
        
        <a href="{{ route($merchantid ? 'merchant.dashboard.m.reservations.index' : 'merchant.dashboard.reservations.index', $merchantid ? ['merchant' => $merchantid] : []) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold shadow-md transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            رجوع
        </a>
    </div>

    <!-- Main Card -->
    <div  id="reservation-card" class="max-w-4xl mx-auto bg-white border-4 border-orange-400 rounded-3xl shadow-2xl p-8 space-y-10 transition-all duration-500 hover:shadow-orange-300">

        <!-- Header -->
        <div class="text-center space-y-3">
            <h2 class="text-4xl font-extrabold text-orange-700 animate-pulse">ملف حجز العميل</h2>
            <p class="text-slate-500">جميع التفاصيل مرتبة بشكل واضح للتاجر</p>
        </div>

        <!-- User Section -->
        <div class="flex flex-col md:flex-row items-center gap-8 border-b border-orange-200 pb-8">
            <div class="relative">
                @php
                $userImage = $reservation->user->additional_data["profile_picture"] ?? null;
            @endphp
            
            @if($userImage)
                <img src="{{ asset('storage/' . $userImage) }}" alt="User Image"
                     class="w-40 h-40 rounded-full object-cover shadow-lg ring-4 ring-orange-300 transition duration-300 hover:scale-105">
            @else
                <div class="w-40 h-40 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-6xl font-bold shadow-lg ring-4 ring-orange-300">
                    {{ mb_substr($reservation->user->f_name ?? '؟', 0, 1) }}
                </div>
            @endif
            
            </div>
            <div class="flex-1 space-y-2">
                <h3 class="text-3xl font-bold text-orange-800">{{ $reservation->user->f_name ?? 'غير متوفر' }}</h3>
                <p class="text-slate-500">رقم الهاتف: {{ $reservation->user->phone ?? 'غير متوفر' }}</p>
                <p class="text-slate-500">الإيميل: {{ $reservation->user->email ?? 'غير متوفر' }}</p>
            </div>
        </div>

        <!-- Service Section -->
        <div class="space-y-4 border-b border-orange-200 pb-8">
            <h4 class="text-2xl font-bold text-orange-700 border-b-2 border-orange-300 inline-block pb-1">معلومات الخدمة</h4>
            <div class="flex flex-col md:flex-row gap-6">
                @if($reservation->offering->image ?? null)
                <img src="{{ asset('storage/' . $reservation->offering->image) }}" alt="Service Image" class="w-full md:w-64 h-40 object-cover rounded-xl shadow-md ring-2 ring-orange-200">
                @endif
                <div class="flex-1 space-y-2 text-slate-700">
                    <p><span class="font-semibold text-orange-600">اسم الخدمة:</span> {{ $reservation->offering->name ?? 'غير متوفر' }}</p>
                    <!-- <p><span class="font-semibold text-orange-600">وصف:</span> {{ $reservation->offering->description ?? 'لا يوجد وصف متاح' }}</p> -->
                    <p><span class="font-semibold text-orange-600">المدة:</span> {{ $reservation->offering->duration ?? 'غير محدد' }}</p>
                    <p><span class="font-semibold text-orange-600">السعر الأساسي:</span> {{ $reservation->offering->price ?? 'غير متوفر' }}</p>

                    @php
                        $features = $reservation->offering->features ?? [];
                    @endphp

                    @if($features)
                        <div class="space-y-1 mt-4">
                            <p class="text-orange-600 font-semibold">تفاصيل إضافية:</p>
                            <p>المدة المحجوزة: {{ $features['booking_duration'] ?? 'غير محددة' }} دقيقة</p>
                            <p>الحد الأقصى للمستخدمين: {{ $features['user_limit'] ?? 'غير متوفر' }}</p>
                            <p>السعر الأساسي: {{ $features['base_price'] ?? 'غير متوفر' }}</p>

                            @if(!empty($features['pricing_packages']))
                                <div>
                                    <p class="font-semibold text-orange-600">الباقات:</p>
                                    <ul class="list-disc list-inside text-slate-600">
                                        @foreach($features['pricing_packages'] as $package)
                                            <li>{{ $package['label'] ?? 'بلا اسم' }} - {{ $package['price'] ?? '0' }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(!empty($features['work_schedule']))
                                <div>
                                    <p class="font-semibold text-orange-600">مواعيد العمل:</p>
                                    <ul class="list-disc list-inside text-slate-600">
                                        @foreach($features['work_schedule'] as $day => $schedule)
                                            @if($schedule['enabled'])
                                                <li>{{ ucfirst($day) }}: {{ $schedule['start'] ?? '?' }} - {{ $schedule['end'] ?? '?' }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reservation Section -->

        <div class="space-y-4" id="customer-card">
            <h4 class="text-2xl font-bold text-orange-700 border-b-2 border-orange-300 inline-block pb-1">
                معلومات الحجز
            </h4>
        
            <div  class="flex flex-col md:flex-row md:items-start md:justify-between gap-8 text-slate-700">
                
                <!-- النصوص -->
                <div class="flex-1 space-y-2">
                    <p><span class="font-semibold text-orange-600">رقم الحجز:</span> {{ $reservation->id ?? '#' }}</p>
                    <p><span class="font-semibold text-orange-600">كود الحجز:</span> {{ $reservation->code ?? "." }}</p>
                    <p><span class="font-semibold text-orange-600">المبلغ المدفوع:</span> {{ $reservation->price ?? '0.00' }}</p>
                    <p><span class="font-semibold text-orange-600">تاريخ الإنشاء:</span> {{ $reservation->created_at->format('Y-m-d') ?? 'غير متوفر' }}</p>
        
                    <p class="flex items-center gap-2">
                        <span class="font-semibold text-orange-600">الحالة:</span>
                        @if(($reservation->additional_data['type'] ?? 1) == 'pay')
                            <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold">دفع</span>
                        @elseif(($reservation->additional_data['type'] ?? 1) == 'refund')
                            <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold">إلغاء</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">معلق</span>
                        @endif
                    </p>
        
                    @php
                        $additional = json_decode($reservation->additional_data,true) ?? [];
                    @endphp
        
                    <p><span class="font-semibold text-orange-600">التاريخ المحجوز:</span> {{ $additional['selected_date'] ?? 'غير محدد' }}</p>
                    <p><span class="font-semibold text-orange-600">الوقت المحجوز:</span> {{ $additional['selected_time'] ?? 'غير محدد' }}</p>
                    <p><span class="font-semibold text-orange-600">الكمية المحددة:</span> {{ (int) $reservation->quantity ?? 'غير محدد' }}</p>
                    <p><span class="font-semibold text-orange-600">كوبون الخصم:</span> {{ $additional['coupon_code'] ?? 'لا يوجد' }}</p>
        
                    @if(!empty($additional['Qa']))
                        <div class="mt-6">
                            <h4 class="text-2xl font-bold text-orange-700 border-b-2 border-orange-300 inline-block pb-1">
                                الأسئلة والإجابات
                            </h4>
                            <table class="w-full mt-3 border border-orange-200 rounded-lg overflow-hidden">
                                <thead class="bg-orange-100 text-orange-800">
                                    <tr>
                                        <th class="px-4 py-2 text-right">السؤال</th>
                                        <th class="px-4 py-2 text-right">الإجابة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($additional['Qa'] as $qa)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">{{ $qa['question'] ?? '-' }}</td>
                                            <td class="px-4 py-2">{{ $qa['answer'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
        
                <!-- QR Code -->
                <div class="flex-shrink-0 flex justify-center md:justify-end">
                    <div class="p-4 border rounded-xl shadow-md bg-white">
                        <div id="qrcode"></div>
                    </div>
                </div>
            </div>
        </div>
        


        
    </div>

    <div class="mt-6 text-center">
        <button onclick="downloadPdf()"
            class="px-6 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold shadow-md">
            تحميل كـ PDF
        </button>
    </div>

    <div class="mt-6 text-center">
        <button onclick="downloadPdfC()"
            class="px-6 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold shadow-md">
            تحميل كـ PDF (معلومات الحجز)
        </button>
    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    function downloadPdf() {
        const element = document.getElementById('reservation-card');
        const opt = {
            margin:       0.5,
            filename:     'reservation-details.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
    </script>

<script>
    function downloadPdfC() {
        const element = document.getElementById('customer-card');
        const opt = {
            margin:       0.5,
            filename:     'reservation-details_customer.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var qrCodeText = @json($reservation->code ?? 'N/A');
            new QRCode(document.getElementById("qrcode"), {
                text: qrCodeText,
                width: 160,
                height: 160,
            });
        });
    </script>
@endsection
