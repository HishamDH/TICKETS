@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])

@section('content')
<div class="flex-1 p-8" x-data="{ open: false }">
  <div
  x-show="open"
  x-transition
  class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-lg bg-black/50 px-4"
  style="display: none;">
<div
    @click.away="open = false"
    class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-8 space-y-6"
>
  <div class="flex justify-between items-center border-b pb-4">
    <h2 class="text-xl font-bold text-gray-800">معلومات التحويل البنكي</h2>
    <button
        @click="open = false"
        class="text-gray-500 hover:text-orange-500 transition text-sm">
      إغلاق
    </button>
  </div>

<form     action="{{ isset($merchantid) 
  ? route('merchant.dashboard.m.withdraws.store', $merchantid) 
  : route('merchant.dashboard.withdraws.store') }}"  method="POST" class="space-y-6">
  @csrf

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">اسم الحساب البنكي</label>
      <input type="text" name="account_name" required
              class="w-full rounded-lg border border-gray-300 py-2 px-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">اسم البنك</label>
      <input type="text" name="bank_name" required
              class="w-full rounded-lg border border-gray-300 py-2 px-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">رقم IBAN</label>
      <input type="text" name="iban" required
              class="w-full rounded-lg border border-gray-300 py-2 px-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">رمز SWIFT</label>
      <input type="text" name="swift" required
              class="w-full rounded-lg border border-gray-300 py-2 px-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
    </div>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">الكمية AMOUNT</label>
    <input type="text" name="amount" required max="{{$wallet->balance??1}}" min="1"
            class="w-full rounded-lg border border-gray-300 py-2 px-3 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition">
  </div>
  <div class="flex justify-between items-center pt-4 border-t">
    <button
        type="button"
        @click="open = false"
        class="inline-flex items-center justify-center rounded-lg bg-gray-200 text-gray-700 font-bold py-2 px-4 hover:bg-gray-300 transition">
        إلغاء
    </button>
    <button
        type="submit"
        class="inline-flex items-center justify-center rounded-lg bg-orange-500 text-white font-bold py-2 px-4 hover:bg-orange-600 transition">
        إرسال الطلب
    </button>
  </div>
</form>
</div>
</div>
  <div class="space-y-8">
    <h2 class="text-3xl font-bold text-slate-800">المحفظة المالية والسحب</h2>

    <div class="grid md:grid-cols-3 gap-6">

      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl hover:shadow-2xl transition">
        <div class="flex flex-col space-y-2 p-6">
          <h3 class="text-xl font-semibold tracking-tight text-orange-600">المسحوبات المعالجة</h3>
          <div class="text-4xl font-bold text-slate-900 mt-2">{{ number_format($wallet->withdrawn_total??0, 2) }} ريال</div>
          <p class="text-sm text-slate-500 mt-1">المبالغ التي تم صرفها بعد الموافقة.</p>
        </div>
      </div>

      <div class="rounded-2xl border-2 border-orange-400 bg-white text-slate-900 shadow-2xl hover:shadow-3xl transition transform hover:scale-105">
        <div class="flex flex-col space-y-2 p-6">
          <h3 class="text-xl font-bold tracking-tight text-orange-700">الرصيد القابل للسحب</h3>
          <div class="text-5xl font-extrabold text-slate-900 mt-2 break-words">{{ number_format($wallet?$wallet->balance:0, 2) }} ريال</div>
          <p class="text-sm text-slate-500 mt-1">رصيدك المتاح حاليا للسحب.</p>

          {{-- زر طلب السحب --}}
          @if (($wallet?$wallet->balance:0) > 0)

          <div >

              @php
                if($merchantid){
                    $hasWalletWithdrawPermission = has_Permetion(Auth::id(),'wallet_withdraw', $merchantid);

                }else {
                    $hasWalletWithdrawPermission = true;
                }
              @endphp
            {{-- الزر الرئيسي --}}
            @if ($hasWalletWithdrawPermission)
              <button
                @click="open = true"
                type="button"
                class="w-full inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-orange-400 to-orange-600 text-white text-base font-bold py-3 shadow-lg hover:from-orange-500 hover:to-orange-700 focus:ring-4 focus:ring-orange-300 transition">
                طلب سحب
            </button>
            @else
            <button
                type="button"
                class="w-full inline-flex items-center justify-center rounded-lg bg-gray-300 text-gray-600 text-base font-bold py-3 shadow-lg cursor-not-allowed">
                لا تملك صلاحية طلب السحب
            </button>
            @endif


            {{-- الخلفية + المودال --}}

          </div>

          @endif

        </div>
      </div>

      {{-- الرصيد الملغي / المحجوز --}}
      <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl hover:shadow-2xl transition">
        <div class="flex flex-col space-y-2 p-6">
          <h3 class="text-xl font-semibold tracking-tight text-orange-600">الرصيد الملغي / المحجوز</h3>
          <div class="text-4xl font-bold text-slate-900 mt-2">{{ number_format($wallet?$wallet->locked_balance:0, 2) }} ريال</div>
          <p class="text-sm text-slate-500 mt-1">رصيد غير متاح حاليا للسحب.</p>
        </div>
      </div>

    </div>

    {{-- سجل عمليات السحب (اختياري) --}}
{{-- سجل عمليات السحب --}}
<div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-xl mt-8 overflow-x-auto">
    <div class="flex justify-between items-center p-6 border-b border-slate-200 bg-gradient-to-r from-orange-50 to-white">
      <h3 class="text-xl font-semibold tracking-tight text-orange-600">سجل عمليات السحب</h3>
    </div>

    @if($withdraws->isEmpty())
      <div class="p-6 text-slate-500 text-center">
        لا توجد عمليات سحب سابقة حتى الآن.
      </div>
    @else
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-orange-50">
          <tr>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">معرّف السحب</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">المستخدم</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">المبلغ (ريال)</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">الحالة</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-orange-800 uppercase tracking-wider">التاريخ</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-slate-200">
          @foreach($withdraws as $withdraw)
            <tr class="hover:bg-orange-50 transition">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-700">{{ $withdraw->withdraw_id }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                {{ $withdraw->user->f_name ?? 'مستخدم غير معروف' }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 font-bold">{{ number_format($withdraw->amount, 2) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                @if($withdraw->status === 'pending')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">قيد المعالجة</span>
                @elseif($withdraw->status === 'completed')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">مكتمل</span>
                @elseif($withdraw->status === 'cancelled')
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">ملغي</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                {{ $withdraw->created_at->format('Y-m-d H:i') }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>


  </div>
</div>
@endsection
