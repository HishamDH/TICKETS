@extends('merchant.layouts.app',["merchant" => $merchantid ?? false])

@section('content')

<div class="max-w-6xl mx-auto mt-12 space-y-6">
    @php
        if($merchantid){
            $hasopenPermission = has_Permetion(Auth::id(),'support_open', $merchantid);
            $hasViewPermission = has_Permetion(Auth::id(),'support_view', $merchantid);
            $hasDPermission = has_Permetion(Auth::id(),'support_delete', $merchantid);

        }else {
            $hasopenPermission = true;
            $hasViewPermission = true;
            $hasDPermission = true;
        }
    @endphp
    <!-- عنوان وزر إضافة -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">طلبات الدعم</h2>
            <p class="text-sm text-gray-500 mt-1">التذاكر المرسلة يتم التعامل معها من قبل فريق الإدارة، وسيتم الرد عليك في أقرب وقت.</p>
        </div>
        @if ($hasopenPermission)
        <a href="{{isset($merchantid) ? route('merchant.dashboard.m.support.create',["merchant" => $merchantid]) : route('merchant.dashboard.support.create') }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">
            + إضافة تذكرة جديدة
        </a>
        @else
        <button class="bg-gray-300 text-gray-500 text-sm px-4 py-2 rounded cursor-not-allowed" disabled>
            + إضافة تذكرة جديدة
        </button>

        @endif

    </div>

    <!-- جدول التذاكر -->
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-right">
                <tr>
                    <th class="px-6 py-3 font-medium text-gray-700">#</th>
                    <th class="px-6 py-3 font-medium text-gray-700">الموضوع</th>
                    <th class="px-6 py-3 font-medium text-gray-700">التصنيف</th>
                    <th class="px-6 py-3 font-medium text-gray-700">الحالة</th>
                    <th class="px-6 py-3 font-medium text-gray-700">تاريخ الإنشاء</th>
                    <th class="px-6 py-3 font-medium text-gray-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white text-right">
                @forelse ($tickets as $index => $ticket)
                    <tr>
                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $ticket->subject }}</td>
                        <td class="px-6 py-4">{{ $ticket->category ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($ticket->status == 'pending')
                                <span class="text-yellow-600">قيد المراجعة</span>
                            @elseif($ticket->status == 'open')
                                <span class="text-green-600">مفتوحة</span>
                            @else
                                <span class="text-gray-500">مغلقة</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4">
                            @if($ticket->status == 'open')
                            @if ($hasDPermission)

                                <form action="{{isset($merchantid) ? route('merchant.dashboard.m.support.destroy', ["merchant"=>$merchantid,"support"=>$ticket->id]) : route('merchant.dashboard.support.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف التذكرة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">حذف</button>
                                </form>
                            @else
                                <button class="text-gray-400 text-sm cursor-not-allowed" disabled>حذف</button>
                            @endif
                            @else
                            @if ($hasViewPermission)

                                <a href="{{isset($merchantid) ? route('merchant.dashboard.m.support.show', [ "merchant" =>  $merchantid,"support" => $ticket->id]) : route('merchant.dashboard.support.show', $ticket->id) }}" class="text-blue-600 hover:underline text-sm">عرض</a>
                            @else
                                <button class="text-gray-400 text-sm cursor-not-allowed" disabled>عرض</button>
                            @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-6">لا توجد أي تذاكر حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
