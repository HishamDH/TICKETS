@extends('visitor.layouts.app')
@section('title', 'My Tickets - ')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(87, 181, 231, 0.05) 50%, rgba(177, 156, 217, 0.1) 100%);
        min-height: 100vh;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 30px rgba(87, 181, 231, 0.1);
    }

    /* مودال QR */
    .qr-modal {
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999 !important;
    }

    .qr-modal.active {
        display: flex;
    }

    .qr-modal .modal-content {
        background: white;
        border-radius: 12px;
        padding: 20px;
        width: 320px;
        text-align: center;
        position: relative;
    }

    .qr-modal button {
        cursor: pointer;
    }
</style>
@endpush

@section('sub_content')

<div class="max-w-5xl mx-auto py-10">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">My Tickets</h2>

    <div class="space-y-6">
        @foreach($tickets as $ticket)
        @php

        $data = $ticket->event??$ticket->additional_data->event;
        $formatted_y = \Carbon\Carbon::parse($data['date'])->format('d-m-Y');
        $formatted_h = \Carbon\Carbon::parse($data['date'])->format('h:i A');
        @endphp

        <div class="glassmorphism p-6 rounded-xl transition-all duration-300 card-hover flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="bg-indigo-100 rounded-full flex items-center justify-center">
                    <img src="{{Storage::url($data['image'])  }}" alt="" class="h-20 w-full rounded-md object-cover">

                </div>
                <div>
                   <a href="{{route('visitor.events.show', $ticket->event)}}"> <h3 class="text-xl font-semibold">{{ $data['name'] }}</h3></a>
                    <p class="text-sm text-gray-600">{{ $formatted_y }} • {{ $formatted_h }}</p>
                    <p class="text-sm text-gray-600">{{ $ticket->venue }}</p>
                    <p class="text-sm text-gray-600">
                        <span>Ticket Code:</span>
                        <span class="font-bold
                            @if($ticket->status == 'paid') text-green-400
                            @elseif($ticket->status == 'cancled') text-red-400
                            @else text-blue-400 @endif">
                            {{ $ticket->code }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="flex flex-col items-end space-y-2">
                @if($ticket->status == 'pending')
                <form action="{{ route('visitor.tickets.update',['ticket'=>$ticket->id]) }}" method="post">@csrf @method('PUT')
                    <button class="bg-green-600 border border-green-600 px-3 py-1 rounded-md mt-2 transition duration-50 text-white hover:bg-white hover:text-green-600">checkout</button>
                </form>

                <form action="{{ route('visitor.tickets.destroy',['ticket'=>$ticket->id]) }}" method="post">
                    @csrf @method('delete')
                    <button type="submit" class="bg-red-600 border border-red-600 px-3 py-1 rounded-md mt-2 transition duration-50 text-white hover:bg-white hover:text-red-600">delete ticket</button>
                </form>
                @elseif($ticket->status == 'paid')
                <a href="#" class="view-qr-btn flex items-center gap-1 bg-white hover:bg-gray-600 hover:border-gray-600 hover:text-white px-4 py-2 rounded-full border border-gray-200 text-sm transition duration-50"
                    data-code="{{ $ticket->code }}">
                    <i class="ri-qr-code-line ri-sm"></i> View QR
                </a>

                <button
                onclick="downloadPDF(this)"
                class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition"
                data-name="{{ $ticket->event->name ?? "not found"}} "
                data-location="{{ $ticket->event->location ?? "not found"}}"
                data-code="{{ $ticket->code?? "not found" }}"
                data-date="{{ $formatted_y ?? "not found"}} - {{ $formatted_h?? "not found" }}"
                data-image="{{ Storage::url($data['image'] ?? '') }}"
            >
                تحميل PDF
            </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- مودال QR -->
<div id="qr-modal" class="fixed top-0 right-0 w-full z-50 glassmorphism qr-modal">
    <div class="modal-content text-center">
        <div id="qr-code-container" class="mb-4 text-center px-4"></div>

        <button id="download-btn" class="download-btn bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-2">
            Download
        </button>


        <button id="close-qr-btn" class="close-qr-btn text-gray-500 px-4 py-2 rounded hover:bg-red-500 hover:text-white mt-2">Close</button>
    </div>
</div>

@endsection

@push('scripts')
<!-- تضمين مكتبة QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('qr-modal');
        const qrContainer = document.getElementById('qr-code-container');
        const closeBtn = document.getElementById('close-qr-btn');
        const downloadBtn = document.getElementById('download-btn');
        let qrInstance = null;

        // عند الضغط على زر View QR
        document.querySelectorAll('.view-qr-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();

                // حذف QR السابق لو موجود
                qrContainer.innerHTML = "";

                // جلب الكود من data attribute
                const code = btn.getAttribute('data-code');

                // انشاء QR جديد
                qrInstance = new QRCode(qrContainer, {
                    text: code,
                });

                // عرض المودال
                modal.classList.add('active');
            });
        });

        // إغلاق المودال
        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            qrContainer.innerHTML = "";
        });

        // تحميل صورة QR
        downloadBtn.addEventListener('click', () => {
            const img = qrContainer.querySelector('img');
            if (img) {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'qr-ticket.png';
                link.click();
            }
        });

        // إغلاق المودال عند الضغط خارج المحتوى (اختياري)
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                qrContainer.innerHTML = "";
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    function downloadPDF(button) {
        const name = button.dataset.name;
        const location = button.dataset.location;
        const code = button.dataset.code;
        const date = button.dataset.date;
        const imageUrl = button.dataset.image;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text(`event name: ${name}`, 10, 20);
        doc.text(`location : ${location}`, 10, 30);
        doc.text(`event date : ${date}`, 10, 40);
        doc.text(`ticket code : ${code}`, 10, 50);

        fetch(imageUrl)
            .then(res => res.blob())
            .then(blob => {
                const reader = new FileReader();
                reader.onload = function () {
                    const imgData = reader.result;
                    doc.addImage(imgData, 'JPEG', 10, 60, 60, 40);
                    doc.save(`${code}.pdf`);
                };
                reader.readAsDataURL(blob);
            });
    }
</script>

@endpush
