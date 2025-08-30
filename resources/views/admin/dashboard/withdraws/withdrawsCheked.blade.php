@extends('admin.layouts.app')

@section('content')
<div class="p-6 md:p-8">
  <h2 class="text-2xl md:text-3xl font-bold text-orange-600 mb-4">إدارة طلبات السحب</h2>

  <div class="overflow-x-auto rounded-lg shadow ring-1 ring-orange-100 bg-white">
    <table class="min-w-full text-sm md:text-base text-slate-800">
      <thead class="bg-orange-50 border-b border-orange-200">
        <tr class="text-slate-600 text-xs md:text-sm uppercase tracking-wide">
          <th class="px-4 py-3 text-right">رقم العملية</th>
          <th class="px-4 py-3 text-right">المستخدم</th>
          <th class="px-4 py-3 text-right">المبلغ</th>
          <th class="px-4 py-3 text-right">الحالة</th>
          <th class="px-4 py-3 text-right">التاريخ</th>
          {{-- <th class="px-4 py-3 text-center">الإجراءات</th> --}}
        </tr>
      </thead>
      <tbody class="divide-y divide-orange-50">
        @forelse($logs as $withdraw)
          <tr class="hover:bg-orange-50 transition">
           
            <td class="px-4 py-3 font-mono text-xs text-slate-500"> <a href="{{route("admin.dashboard.withdraws.show",$withdraw->id)}}">{{ $withdraw->withdraw_id }}</a></td>
            
            <td class="px-4 py-3">
              <div class="flex items-center gap-2">
                <div class="h-7 w-7 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 text-xs font-bold">
                  {{ mb_substr($withdraw->user->name ?? '؟', 0, 1) }}
                </div>
                <div>
                  <div class="font-medium">{{ $withdraw->user->f_name ?? 'غير معروف' }}</div>
                  <div class="text-xs text-slate-400">{{ $withdraw->user->email ?? '—' }}</div>
                </div>
              </div>
            </td>

            <td class="px-4 py-3 font-semibold text-orange-700">{{ number_format($withdraw->amount, 2) }} ر.س</td>

            <td class="px-4 py-3">
              @if($withdraw->status === 'pending')
                <span class="inline-block px-2 py-0.5 rounded-full bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs">قيد المراجعة</span>
              @elseif($withdraw->status === 'completed')
                <span class="inline-block px-2 py-0.5 rounded-full bg-green-50 border border-green-200 text-green-700 text-xs">مكتمل</span>
              @else
                <span class="inline-block px-2 py-0.5 rounded-full bg-red-50 border border-red-200 text-red-700 text-xs">مرفوض</span>
              @endif
            </td>

            <td class="px-4 py-3 text-xs text-slate-500">{{ $withdraw->created_at->format('Y-m-d H:i') }}</td>

            {{-- <td class="px-4 py-3 text-center">
              @if($withdraw->status === 'pending')
                <div class="flex items-center justify-center gap-2">
                  <form action="{{route('admin.dashboard.withdraws.update',$withdraw->id)}}" method="POST">
                    @method('PUT')
                    @csrf
                    
                    <button type="submit" class="text-green-600 hover:text-green-800" title="قبول">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                      </svg>
                    </button>
                  </form>

                  <form action="{{route('admin.dashboard.withdraws.destroy',$withdraw->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-red-600 hover:text-red-800" title="رفض">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </form>
                </div>
              @else
                <span class="text-slate-400 text-xs">—</span>
              @endif
            </td> --}}
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-8 text-slate-400 text-sm">لا توجد طلبات سحب حاليا.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-8 flex justify-center">
    {{ $logs->links('pagination::tailwind') }}
</div>
</div>
@endsection
