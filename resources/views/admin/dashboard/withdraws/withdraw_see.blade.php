@extends('admin.layouts.app')

@section('content')
<div class="p-6 md:p-10 max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-orange-600">
            تفاصيل طلب السحب
        </h1>
        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-xl text-slate-700 font-bold">
            رجوع
        </a>
    </div>

    {{-- Withdraw Info --}}
    <div class="bg-white shadow-xl rounded-2xl p-6 ring-1 ring-blue-200 mb-8">
        <h2 class="text-xl font-bold text-blue-600 mb-4">بيانات طلب السحب</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-700">
            <p><span class="font-bold">رقم الطلب:</span> {{ $log->id }}</p>
            <p><span class="font-bold">رقم السحب:</span> {{ $log->withdraw_id }}</p>
            <p><span class="font-bold">المبلغ:</span> {{ number_format($log->amount, 2) }} ريال</p>
            <p><span class="font-bold">الحالة:</span> 
                <span class="px-2 py-1 rounded-lg text-white 
                    {{ $log->status == 'pending' ? 'bg-yellow-500' : ($log->status == 'approved' ? 'bg-green-600' : 'bg-red-600') }}">
                    {{ $log->status }}
                </span>
            </p>
            <p><span class="font-bold">تاريخ الإنشاء:</span> {{ $log->created_at->format('Y-m-d H:i') }}</p>
            <p><span class="font-bold">آخر تحديث:</span> {{ $log->updated_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    {{-- Bank Info --}}
    @if(is_array($log->additional_data))
        <div class="bg-white shadow-xl rounded-2xl p-6 ring-1 ring-purple-200 mb-8">
            <h2 class="text-xl font-bold text-purple-600 mb-4">بيانات الحساب البنكي</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-slate-700">
                <p><span class="font-bold">اسم الحساب:</span> {{ $log->additional_data['account_name'] ?? '—' }}</p>
                <p><span class="font-bold">البنك:</span> {{ $log->additional_data['bank_name'] ?? '—' }}</p>
                <p><span class="font-bold">IBAN:</span> {{ $log->additional_data['iban'] ?? '—' }}</p>
                <p><span class="font-bold">SWIFT:</span> {{ $log->additional_data['swift'] ?? '—' }}</p>
            </div>
        </div>
    @endif

    {{-- User Info --}}
    <div class="bg-white shadow-xl rounded-2xl p-6 ring-1 ring-orange-200 mb-8">
        <h2 class="text-xl font-bold text-orange-600 mb-4">بيانات المستخدم</h2>
        <div class="flex items-center gap-4">
            @if($log->user && ($log->user->additional_data['profile_picture'] ?? null))
                <img src="{{ asset('storage/' . $log->user->additional_data['profile_picture']) }}" 
                     class="w-16 h-16 rounded-full object-cover ring-2 ring-orange-300 shadow">
            @else
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">ع</div>
            @endif
            <div>
                <a href="{{route("template",$log->user->id)}}" target="_blank" rel="noopener noreferrer"><div class="text-lg font-semibold">{{ $log->user->f_name ?? '—' }}</div></a>
                <div class="text-slate-500 text-sm">{{ $log->user->email ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Wallet Info --}}
    @if($log->user && $log->user->wallet)
        <div class="bg-white shadow-xl rounded-2xl p-6 ring-1 ring-green-200 mb-8">
            <h2 class="text-xl font-bold text-green-600 mb-4">المحفظة</h2>
            <p class="text-lg">الرصيد الحالي: 
                <span class="font-bold text-green-700">
                    {{ number_format($log->user->wallet->balance, 2) }} ريال
                </span>
            </p>
        </div>

        {{-- Last 30 Transactions --}}
        <div class="bg-white shadow-xl rounded-2xl p-6 ring-1 ring-slate-200">
            <h2 class="text-xl font-bold text-slate-700 mb-4">آخر 30 عملية دفع</h2>
            <ul class="divide-y divide-slate-100">
                @foreach($log->user->wallet->transactions()->latest()->take(30)->get() as $pay)
                    <li class="py-3 flex justify-between items-center">
                        <span class="font-mono text-orange-600">{{ $pay->transaction_id }}</span>
                        <span class="text-sm text-slate-500">{{ $pay->created_at->format('Y-m-d H:i') }}</span>
                        <span class="font-bold text-green-700">{{ number_format($pay->amount, 2) }} ريال</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endsection
