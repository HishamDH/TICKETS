@extends('merchant.layouts.app',["merchant" => $merchantid ?? false])

@section('content')
<form action="{{ isset($merchantid) ? route('merchant.dashboard.m.support.store',["merchant" => $merchantid]) : route('merchant.dashboard.support.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-xl shadow-lg">
    @csrf

    <div>
        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">الموضوع</label>
        <input type="text" name="subject" id="subject" class="w-full border rounded-md p-3 text-sm" placeholder="مثال: مشكلة في الدفع" value="{{ old('subject') }}">
        @error('subject') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">التصنيف</label>
        <select name="category" id="category" class="w-full border rounded-md p-3 text-sm">
            <option value="">اختر التصنيف</option>
            <option value="payment" {{ old('category') == 'payment' ? 'selected' : '' }}>الدفع</option>
            <option value="booking" {{ old('category') == 'booking' ? 'selected' : '' }}>الحجوزات</option>
            <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>مشكلة تقنية</option>
            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>أخرى</option>
        </select>
        @error('category') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">الرسالة</label>
        <textarea name="message" id="message" rows="4" class="w-full border rounded-md p-3 text-sm" placeholder="اشرح مشكلتك بالتفصيل...">{{ old('message') }}</textarea>
        @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">مرفق (اختياري)</label>
        <input type="file" name="attachment" class="w-full border rounded-md p-2 text-sm" accept="image/*,.pdf,.doc,.docx">
        @error('attachment') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <button type="submit" class="w-full h-10 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
            إرسال
        </button>
    </div>
</form>

@endsection
