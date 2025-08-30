@extends('checker.layouts.app')
@section('title', 'Dashboard - ')

@push('styles')
<style>
    #reader {
        width: 100%;
        max-width: 400px;
        margin: auto;
        border-radius: 10px;
        overflow: hidden;
    }

    .glassmorphism {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 12px 32px rgba(106, 90, 205, 0.1);
    }

    .gradient-button {
        background: linear-gradient(135deg, #57B5E7 0%, #B19CD9 100%);
        transition: all 0.3s ease;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    .gradient-button:hover {
        background: linear-gradient(135deg, #4da8d9 0%, #a28cc7 100%);
        transform: translateY(-2px);
    }

    #qr-result {
        font-size: 1.1rem;
        font-weight: 500;
    }
</style>
@endpush

@section('sub_content')
<div class="glassmorphism p-4 rounded">
    <h3 class="mb-3">QR Code Scanner</h3>

    <button id="start-btn" class="gradient-button px-3 py-2 rounded text-white mb-3">
        تشغيل الكاميرا
    </button>

    <div id="reader" style="width: 300px; display: none;" class="mb-3"></div>

    <div id="qr-result" class="text-success"></div>
    <div id="qr-error" class="text-danger mt-2"></div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    let scannerStarted = false;
    let html5QrCode;

    document.getElementById("start-btn").addEventListener("click", () => {
        const readerDiv = document.getElementById("reader");
        const resultDiv = document.getElementById("qr-result");
        const errorDiv = document.getElementById("qr-error");

        resultDiv.textContent = "";
        errorDiv.textContent = "";

        if (scannerStarted) return;

        html5QrCode = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                const cameraId = devices[0].id;

                readerDiv.style.display = "block";
                scannerStarted = true;

                html5QrCode.start(
                    cameraId,
                    { fps: 10, qrbox: 250 },
                    (decodedText, decodedResult) => {
                        resultDiv.textContent = "Scanned QR Code: " + decodedText;
                        errorDiv.textContent = "";

                        // إيقاف المسح بعد النجاح (اختياري)
                        html5QrCode.stop().then(() => {
                            scannerStarted = false;
                            readerDiv.style.display = "none";
                        }).catch(err => {
                            console.error("خطأ عند إيقاف الكاميرا:", err);
                        });
                    },
                    (errorMessage) => {
                        errorDiv.textContent = "مافي كيو ار كود.";
                    }
                );
            } else {
                errorDiv.textContent = "مافي كاميرا متوفرة.";
            }
        }).catch(err => {
            errorDiv.textContent = "خطأ في الوصول للكاميرا.";
            console.error(err);
        });
    });
</script>
@endsection
