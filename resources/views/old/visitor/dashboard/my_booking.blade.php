@extends('visitor.layouts.app')
@section('title', 'My Tickets - ')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e3f2fd, #ede7f6);
        min-height: 100vh;
        color: #1e293b;
    }

    h1, h2, h3 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(200, 200, 255, 0.25);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(12px);
        border-radius: 16px;
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(33, 150, 243, 0.1);
    }

    .qr-modal {
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
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
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 9999px;
        padding: 8px 16px;
        font-size: 14px;
        border: 1px solid #cbd5e1;
        background-color: #fff;
        color: #1e293b;
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
</style>
@endpush

@section('sub_content')
<div class="max-w-5xl mx-auto py-10 px-4">
    <h2 class="text-3xl font-bold text-indigo-900 mb-8">My Bookings</h2>

    <div class="space-y-6">
        @foreach($bookings as $booking)
        @php
        $formatted_y = \Carbon\Carbon::parse($booking->branch->open_at ?? null)->format('h:i A');
        $formatted_h = \Carbon\Carbon::parse($booking->branch->close_at?? null )->format('h:i A');
        @endphp

        <div class="glassmorphism p-6 transition-all duration-300 card-hover flex justify-between items-center flex-wrap">
            <div class="flex items-center space-x-4">
                <img src="{{ Storage::url($booking->branch->image ?? null )  }}" alt="Branch Image" class="h-20 w-28 rounded-md object-cover">
                <div>
                    <h3 class="text-lg font-semibold">
                        <a href="{{ route('visitor.branch_preview', ['branch' => $booking->branch->id, 'restaurant' => $booking->branch->restaurant->id]) }}">
                            {{ $booking->branch->name }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-600">{{ $formatted_y }} - {{ $formatted_h }}</p>
                    <p class="text-sm text-gray-600">Code: <strong>{{ $booking->code }}</strong></p>
                </div>
            </div>

            <div class="flex flex-col items-end space-y-2 mt-4 md:mt-0">
                <span class="px-4 py-1 rounded-full text-sm font-medium text-white
                    @if($booking->status == 'confirmed') bg-green-500
                    @elseif($booking->status == 'pending') bg-yellow-400
                    @else bg-red-400 @endif">
                    {{ ucfirst($booking->status) }}
                </span>

                <div class="flex gap-2 mt-2 flex-wrap justify-end">
                    @if($booking->status == 'pending')
                    <form action="{{ route('visitor.my_bookings.pay', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">
                            <i class="ri-bank-card-line ri-sm"></i> Pay Now
                        </button>
                    </form>
                    @elseif($booking->status == 'confirmed')
                    <a href="#" class="btn view-qr-btn" data-code="{{ $booking->code }}">
                        <i class="ri-qr-code-line ri-sm"></i> View QR
                    </a>
                        <button
                        onclick="downloadPDF(this)"
                        class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition"
                        data-name="{{ $booking->branch->name }}"
                        data-location="{{ $booking->branch->location }}"
                        data-code="{{ $booking->code }}"
                        data-date="{{ $formatted_y }} - {{ $formatted_h }}"
                        data-image="{{ Storage::url($booking->branch->image ?? '') }}"
                    >
                        تحميل PDF
                    </button>
                
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

<div id="qr-modal" class="qr-modal">
    <div class="modal-content glassmorphism">
        <div id="qr-code-container" class="mb-4"></div>
        <button id="download-btn" class="btn bg-blue-600 text-white hover:bg-blue-700 mb-2">Download</button>
        <button id="close-qr-btn" class="btn hover:bg-red-500 hover:text-white">Close</button>
    </div>
</div>

@push('scripts')

  
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById('qr-modal');
        const qrContainer = document.getElementById('qr-code-container');
        const closeBtn = document.getElementById('close-qr-btn');
        const downloadBtn = document.getElementById('download-btn');

        document.querySelectorAll('.view-qr-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                const code = btn.getAttribute('data-code');
                qrContainer.innerHTML = "";
                new QRCode(qrContainer, { text: code });
                modal.classList.add('active');
            });
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            qrContainer.innerHTML = "";
        });

        downloadBtn.addEventListener('click', () => {
            const img = qrContainer.querySelector('img');
            if (img) {
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'qr-ticket.png';
                link.click();
            }
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                qrContainer.innerHTML = "";
            }
        });
    });
</script>


@endpush

@push('scripts')
<!-- استدعاء jsPDF من CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

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
        doc.text(`branch name: ${name}`, 10, 20);
        doc.text(`location : ${location}`, 10, 30);
        doc.text(`Reservation date : ${date}`, 10, 40);
        doc.text(`Reservation code : ${code}`, 10, 50);

        fetch(imageUrl)
            .then(res => res.blob())
            .then(blob => {
                const reader = new FileReader();
                reader.onload = function () {
                    const imgData = reader.result;
                    doc.addImage(imgData, 'JPEG', 10, 60, 60, 40);
                    doc.save(`reservation_${code}.pdf`);
                };
                reader.readAsDataURL(blob);
            });
    }
</script>
@endpush
