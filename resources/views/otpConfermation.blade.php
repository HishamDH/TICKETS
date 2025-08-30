@extends('layouts.view')
@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">أدخل رمز التحقق</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otpConfermation.store') }}">
        @csrf

        <div class="mb-4">
            <label for="otp" class="block text-gray-700 mb-1">رمز التحقق</label>
            <input type="text" name="otp" id="otp" required
                   class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p id="otp-error" class="text-red-500 text-sm mt-1 hidden">الرمز غير صحيح</p>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition opacity-50 cursor-not-allowed"
                disabled>
            تأكيد الرمز
        </button>
    </form>

    

    <div class="mt-6 text-center">
        <button id="resend-btn"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded cursor-not-allowed opacity-50"
                disabled>
            إعادة إرسال الكود (30)
        </button>
    </div>
</div>

<script>
    const correctOtp = "{{ $otp }}";
    const input = document.getElementById('otp');
    const submitBtn = document.querySelector('button[type="submit"]');
    const errorText = document.getElementById('otp-error');

    input.addEventListener('input', function () {
        if (input.value === correctOtp) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            errorText.classList.add('hidden');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            errorText.classList.remove('hidden');
        }
    });

    const resendBtn = document.getElementById('resend-btn');
    let secondsLeft = 30;

    @if(session('otp_sent_at'))
        const otpSentAt = new Date("{{ \Carbon\Carbon::parse(session('otp_sent_at'))->format('Y-m-d H:i:s') }}");
        const now = new Date();
        const diff = Math.floor((now - otpSentAt) / 1000);
        if (diff < 60) {
            secondsLeft = 60;
        } else {
            secondsLeft = 0;
        }
    @endif

    function updateResendButton() {
        if (secondsLeft <= 0) {
            resendBtn.disabled = false;
            resendBtn.textContent = "إعادة إرسال الكود";
            resendBtn.classList.remove('cursor-not-allowed', 'opacity-50', 'bg-gray-300');
            resendBtn.classList.add('bg-orange-500', 'hover:bg-orange-600', 'text-white');
        } else {
            resendBtn.textContent = "إعادة إرسال الكود (" + secondsLeft + ")";
            resendBtn.disabled = true;
            secondsLeft--;
            setTimeout(updateResendButton, 1000);
        }
    }

    updateResendButton();

    resendBtn.addEventListener('click', function () {
        if (!resendBtn.disabled) {
            location.reload();
        }
    });
</script>
@endsection
