@extends('admin.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mt-12 space-y-6">

    <!-- عنوان وزر إضافة -->


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
                @if ($ticket->status == 'open' || ($ticket->status == 'pending' && ($ticket->staff_id == Auth::id() || $ticket->staff_id == null)))
                    
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
                                {{-- <form action="{{ route('support.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف التذكرة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">حذف</button>
                                </form> --}}
                                <a href="{{ route('admin.dashboard.support.show', $ticket->id) }}" class="text-blue-600 hover:underline text-sm">قبول</a>

                            @endif
                            @if ($ticket->status == 'pending')
                                <a href="{{ route('admin.dashboard.support.show', $ticket->id) }}" class="text-blue-600 hover:underline text-sm">دخول</a>
                            @endif
                        </td>
                    </tr>
                @endif
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
