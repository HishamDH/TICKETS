@extends('customer.layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-gray-50">
    <div class="space-y-6">
        <!-- العنوان -->
        <div>
            <h1 class="text-3xl font-bold text-slate-800">السجل المالي</h1>
            <p class="text-slate-500 mt-1">جميع عمليات الدفع والاسترداد الخاصة بك.</p>
        </div>

        <!-- جدول العمليات -->
        <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow">
            <div class="p-6 border-b">
                <h3 class="text-xl font-semibold">سجل العمليات</h3>
            </div>
            <div class="p-6 pt-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right">
                        <thead class="bg-slate-50 text-slate-600 border-b">
                            <tr>
                                <th class="px-4 py-3">رقم الحجز</th>
                                <th class="px-4 py-3">المبلغ</th>
                                <th class="px-4 py-3">وسيلة الدفع</th>
                                <th class="px-4 py-3">التاريخ</th>
                                <th class="px-4 py-3">النوع</th>
                                <th class="px-4 py-3 text-left">الفاتورة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paysHistory as $transaction)
                                @php
                                    $type = $transaction->additional_data['type'] ?? 'payment';
                                @endphp
                                <tr class="border-b hover:bg-slate-50">
                                    <td class="px-4 py-3 font-medium">#{{ $transaction->id }}</td>
                                    <td class="px-4 py-3">{{ number_format($transaction->amount, 2) }} ريال</td>
                                    <td class="px-4 py-3">{{ $transaction->payment_method ?? '---' }}</td>
                                    <td class="px-4 py-3">{{ $transaction->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block px-2 py-1 rounded text-xs font-medium
                                            {{ $type === 'refund' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                            {{ $type === 'refund' ? 'استرداد' : 'دفع' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-left">
                                        <button onclick="downloadInvoice({{ $transaction->id }})"
                                            class="inline-flex items-center gap-2 rounded-md border text-sm font-medium px-3 py-2 border-slate-300 bg-white text-slate-700 hover:bg-slate-100 shadow-sm transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                <polyline points="7 10 12 15 17 10" />
                                                <line x1="12" y1="15" x2="12" y2="3" />
                                            </svg>
                                            تحميل
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-slate-500">
                                        لا يوجد عمليات مالية حتى الآن.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    async function downloadInvoice(transactionId) {
        try {
            const response = await fetch(`/api/transaction/${transactionId}`);
            if (!response.ok) throw new Error('فشل في جلب البيانات');

            const data = await response.json();
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const transaction = data.transaction;
            const item = transaction.item;
            const user = item.user;
            const type = transaction.additional_data?.type || 'payment';

            doc.setFontSize(18);
            doc.text("فاتورة الدفع", 105, 20, { align: "center" });

            doc.setFontSize(12);
            doc.text(`رقم المعاملة: #${transaction.id}`, 14, 40);
            doc.text(`اسم البائع: ${user.name}`, 14, 50);
            doc.text(`اسم الخدمة: ${item.title ?? '—'}`, 14, 60);
            doc.text(`المبلغ: ${transaction.amount} ريال`, 14, 70);
            doc.text(`وسيلة الدفع: ${transaction.payment_method ?? '---'}`, 14, 80);
            doc.text(`النوع: ${type === 'refund' ? 'استرداد' : 'دفع'}`, 14, 90);
            doc.text(`تاريخ العملية: ${transaction.created_at}`, 14, 100);

            doc.save(`فاتورة-${transaction.id}.pdf`);
        } catch (err) {
            alert("فشل تحميل الفاتورة: " + err.message);
        }
    }
</script>
@endpush
