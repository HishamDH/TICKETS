@extends('merchant.layouts.app',["merchant" => $merchantid ?? false])
@section('content')

<div class="space-y-8">
  <h2 class="text-3xl font-bold text-slate-800">سجل الأنشطة</h2>

  <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
    <div class="divide-y divide-slate-100">
      @forelse ($notifications as $note)
        <div class="flex items-start gap-4 p-6">
          <div class="flex-shrink-0 w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-500 font-bold">
            {{ strtoupper(substr($note->user_id, 0, 1)) }}
          </div>

          <div class="flex-1">
            <div class="flex justify-between items-center mb-1">
              <h3 class="text-base font-semibold text-slate-800">
                {{ $note->subject }}
              </h3>
              <span class="text-xs text-slate-400">
                {{ $note->created_at->diffForHumans() }}
              </span>
            </div>
            <p class="text-sm text-slate-600">{{ $note->message }}</p>
            <p class="text-xs text-slate-400 mt-2">User ID: {{ $note->user_id }}</p>
          </div>
        </div>
      @empty
        <div class="p-6 text-center text-slate-500">
          لا توجد سجلات حالياً.
        </div>
      @endforelse
    </div>
  </div>
</div>


@endsection
