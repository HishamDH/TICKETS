@extends('employee.layouts.app')
@section('title', 'Dashboard - قائمة التذاكر')

@push('styles')
<style>
    body {
        font-family: 'Quicksand', sans-serif;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6e6fa 100%);
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Space Grotesk', sans-serif;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .card-hover:hover {
        transform: translateY(-5px) scale(1.01);
        box-shadow: 0 20px 40px rgba(106, 90, 205, 0.15);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }

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
<div class="p-6 space-y-4 max-w-6xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800">قائمة التذاكر</h2>

    <div class="grid grid-cols-1 gap-4">
        @foreach ($tickets as $ticket)
            <div class="glassmorphism rounded-xl p-4 flex justify-between items-center card-hover transition duration-300">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">#{{ $ticket->id }} - {{ \Illuminate\Support\Str::limit($ticket->title, 50, '...') }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($ticket->content, 70, '...') }}</p>
                    <div class="text-sm text-gray-500 mt-2 space-x-2 rtl:space-x-reverse">
                        <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-xs">
                            {{ ucfirst($ticket->status) }}
                        </span>
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">
                            {{ $ticket->user->name ?? 'غير معروف' }}
                        </span>
                        <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">
                            {{ $ticket->code }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <button class="text-blue-600 hover:text-blue-800" title="عرض">
                        <i class="ri-eye-line text-xl"></i>
                    </button>
                    <button class="text-purple-600 hover:text-purple-800" title="قبول">
                        <i class="ri-checkbox-circle-line"></i>
                    </button>
                    <button class="text-purple-600 hover:text-purple-800" title="رفض">
                        <i class="ri-close-circle-line"></i>
                    </button>
                    <button class="text-purple-600 hover:text-purple-800" title="طباعة">
                        <i class="ri-printer-line text-xl"></i>
                    </button>
                    <a href="#" class="view-qr-btn flex items-center gap-1 bg-white hover:bg-gray-600 hover:border-gray-600 hover:text-white px-4 py-2 rounded-full border border-gray-200 text-sm transition duration-50"
                    data-code="{{ $ticket->code }}">
                    <i class="ri-qr-code-line ri-sm"></i> View QR
                </a>
                    <form action="{{ route('employee.support.destroy', $ticket->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:text-red-800" title="حذف">
                            <i class="ri-delete-bin-line text-xl"></i>
                        </button>
                        </button></form>

                </div>
            </div>
        @endforeach
    </div>
</div>

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

