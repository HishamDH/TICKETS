@extends('merchant.layouts.app', ['merchant' => $merchantid ?? false])

@section('content')
    <div class="flex-1 p-8">
        <div class="space-y-6">
            <h2 class="text-3xl font-bold text-slate-800">إدارة الحجوزات</h2>

            <!-- جدول البوندينج -->
            @php
                $hasReservationDetailsPermission = true;
                $hasReservatioDeletePermession = true;
                $hasReservatioEditePermession = true;
                if ($merchantid) {
                    $hasReservationDetailsPermission = has_Permetion(Auth::id(), 'reservation_detail', $merchantid);
                    $hasReservatioDeletePermession = has_Permetion(Auth::id(), 'reservations_delete', $merchantid);
                    $hasReservatioEditePermession = has_Permetion(Auth::id(), 'reservations_edit', $merchantid);
                    
                }
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                <div class="px-4 py-2 flex justify-between items-center">
                    <h3 class="font-semibold text-lg">الحجوزات الجارية (Bundling)</h3>
                    <input type="text" id="search-bundling" placeholder="بحث..." class="px-3 py-1 border rounded-lg text-sm">
                </div>
                <div class="px-4 py-2 overflow-x-scroll">
                    <table class="w-full caption-bottom text-sm" id="table-bundling">
                        <thead>
                            <tr class="border-b">
                                <th class="h-12 px-4 text-right">العميل</th>
                                <th class="h-12 px-4 text-right">رقم الهاتف</th>
                                <th class="h-12 px-4 text-right">الخدمة</th>
                                <th class="h-12 px-4 text-right">الحالة</th>
                                <th class="h-12 px-4 text-right">المبلغ المدفوع</th>
                                <th class="h-12 px-4 text-right">الكود</th>
                                <th class="h-12 px-4 text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bundling as $reservation)
                                <tr>
                                    <td class="p-4">{{ $reservation->user->f_name ?? 'غير معروف' }}</td>
                                    <td class="p-4">{{ $reservation->user->phone ?? 'غير متوفر' }}</td>
                                    <td class="p-4">{{ $reservation->offering->name }}</td>
                                    <td class="p-4">
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">قيد
                                            الانتضار</span>
                                    </td>
                                    <td class="p-4">{{ $reservation->price }}</td>
                                    <td class="p-4">{{ $reservation->code }}</td>
                                    <td class="p-4 text-center" 
                                    x-data="{ 
                                        open: false, 
                                        selectedDate: '{{ $reservation->additional_data['selected_date'] ?? $reservation->created_at->format('Y-m-d') }}', 
                                        selectedTime: '{{ $reservation->additional_data['selected_time'] ?? '00:00' }}', 
                                        quantity: '{{ $reservation->quantity }}' 
                                    }">
                                
                                    <!-- عرض التفاصيل -->
                                    @if ($hasReservationDetailsPermission)
                                        <a href="{{ $merchantid ? route('merchant.dashboard.m.reservations.show', ['merchant' => $merchantid, 'reservation' => $reservation->id]) : route('merchant.dashboard.reservations.show', $reservation->id) }}"
                                           class="text-blue-500 hover:underline">
                                           <i class="ri-eye-line"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-500"><i class="ri-lock-line"></i></span>
                                    @endif
                                
                                    <!-- زر تعديل -->
                                    @if($hasReservatioEditePermession)
                                    <button @click="open = true" class="text-yellow-500 ml-2 hover:underline">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    @else
                                    <button  class="text-yellow-500 ml-2 hover:underline">
                                        <i class="ri-lock-line" disabled></i>
                                    </button>
                                    @endif
                                    <!-- زر حذف -->
                                    @if ($hasReservatioDeletePermession)
                                        <form action="{{ $merchantid 
                                            ? route('merchant.dashboard.m.reservations.destroy', ['merchant' => $merchantid, 'reservation' => $reservation->id])
                                            : route('merchant.dashboard.reservations.destroy', $reservation->id) }}" 
                                            method="POST" class="inline-block ml-2"
                                            onsubmit="return confirm('هل أنت متأكد من الغاء هذا الحجز؟ سيتم استرداد المبلغ كامل بدون اي رسوم')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 ml-2"><i class="ri-lock-line"></i></span>
                                    @endif
                                
                                    <!-- المودال -->
                                    <div x-show="open" 
                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" 
                                    style="display: none;">
                               
                                   <form method="POST" action="{{ $merchantid 
                                    ? route('merchant.dashboard.m.reservations.update', ['merchant' => $merchantid, 'reservation' => $reservation->id])
                                    : route('merchant.dashboard.reservations.update', $reservation->id) }}" 
                                         @click.away="open = false" 
                                         class="bg-white rounded-xl p-6 w-96 space-y-4">
                               
                                       @csrf
                                       @method('PUT')
                               
                                       <h3 class="text-lg font-semibold">تعديل الحجز</h3>
                               
                                       <div class="space-y-2">
                                           <label class="block text-sm font-medium">التاريخ</label>
                                           <input type="date" name="selectedDate" x-model="selectedDate"
                                                  class="w-full border rounded px-2 py-1" required>
                                       </div>
                               
                                       <div class="space-y-2">
                                           <label class="block text-sm font-medium">الوقت</label>
                                           <input type="time" name="selectedTime" x-model="selectedTime"
                                                  class="w-full border rounded px-2 py-1" required>
                                       </div>
                               
                                       <div class="space-y-2">
                                           <label class="block text-sm font-medium">الكمية</label>
                                           <input type="number" name="quantity" x-model="quantity"
                                                  class="w-full border rounded px-2 py-1" min="1" required>
                                       </div>
                               
                                       <div class="flex justify-end gap-2 mt-4">
                                           <button type="button" @click="open = false" 
                                                   class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                                               إلغاء
                                           </button>
                                           <button type="submit" 
                                                   class="px-4 py-2 rounded bg-green-500 text-white hover:bg-green-600">
                                               تحديث
                                           </button>
                                       </div>
                                   </form>
                               </div>
                               
                                </td>
                                
                                        
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- جدول الحجوزات المنتهية -->
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                <div class="px-4 py-2 flex justify-between items-center">
                    <h3 class="font-semibold text-lg">الحجوزات المنتهية (Finished)</h3>
                    <input type="text" id="search-finished" placeholder="بحث..."
                        class="px-3 py-1 border rounded-lg text-sm">
                </div>
                <div class="px-4 py-2 overflow-x-scroll">
                    <table class="w-full caption-bottom text-sm" id="table-finished">
                        <thead>
                            <tr class="border-b">
                                <th class="h-12 px-4 text-right">العميل</th>
                                <th class="h-12 px-4 text-right">رقم الهاتف</th>
                                <th class="h-12 px-4 text-right">الخدمة</th>
                                <th class="h-12 px-4 text-right">الحالة</th>
                                <th class="h-12 px-4 text-right">المبلغ المدفوع</th>
                                <th class="h-12 px-4 text-right">الكود</th>
                                <th class="h-12 px-4 text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($finished as $reservation)
                                <tr>
                                    <td class="p-4">{{ $reservation->user->f_name ?? 'غير معروف' }}</td>
                                    <td class="p-4">{{ $reservation->user->phone ?? 'غير متوفر' }}</td>
                                    <td class="p-4">{{ $reservation->offering->name }}</td>
                                    <td class="p-4">
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">منتهية</span>
                                    </td>
                                    <td class="p-4">{{ $reservation->price }}</td>
                                    <td class="p-4">{{ $reservation->code }}</td>
                                    <td class="p-4 text-center">
                                        @if ($hasReservationDetailsPermission)
                                            <a href="{{ route($merchantid ? 'merchant.dashboard.m.reservations.show' : 'merchant.dashboard.reservations.show', $merchantid ? ['merchant' => $merchantid, 'reservation' => $reservation->id] : [$reservation->id]) }}"
                                                class="text-blue-500 hover:underline">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-500"><i class="ri-lock-line"></i></span>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- جدول "لم يتم الحضور" -->
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                <div class="px-4 py-2 flex justify-between items-center">
                    <h3 class="font-semibold text-lg">لم يتم الحضور</h3>
                    <input type="text" id="search-notpresent" placeholder="بحث..."
                        class="px-3 py-1 border rounded-lg text-sm">
                </div>
                <div class="px-4 py-2 overflow-x-scroll">
                    <table class="w-full caption-bottom text-sm" id="table-notpresent">
                        <thead>
                            <tr class="border-b">
                                <th class="h-12 px-4 text-right">العميل</th>
                                <th class="h-12 px-4 text-right">رقم الهاتف</th>
                                <th class="h-12 px-4 text-right">الخدمة</th>
                                <th class="h-12 px-4 text-right">الحالة</th>
                                <th class="h-12 px-4 text-right">المبلغ المدفوع</th>
                                <th class="h-12 px-4 text-right">الكود</th>
                                <th class="h-12 px-4 text-center">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($NotPresent as $reservation)
                                <tr>
                                    <td class="p-4">{{ $reservation->user->f_name ?? 'غير معروف' }}</td>
                                    <td class="p-4">{{ $reservation->user->phone ?? 'غير متوفر' }}</td>
                                    <td class="p-4">{{ $reservation->offering->name }}</td>
                                    <td class="p-4">
                                        <span
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">لم
                                            يحضر</span>
                                    </td>
                                    <td class="p-4">{{ $reservation->price }}</td>
                                    <td class="p-4">{{ $reservation->code }}</td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route($merchantid ? 'merchant.dashboard.m.reservations.show' : 'merchant.dashboard.reservations.show', $merchantid ? ['merchant' => $merchantid, 'reservation' => $reservation->id] : [$reservation->id]) }}"
                                            class="text-blue-500 hover:underline">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- JavaScript للبحث -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupSearch(inputId, tableId) {
                const input = document.getElementById(inputId);
                const table = document.getElementById(tableId);
                input.addEventListener('keyup', function() {
                    const filter = input.value.toLowerCase();
                    const rows = table.getElementsByTagName('tr');
                    for (let i = 1; i < rows.length; i++) {
                        let visible = false;
                        const cells = rows[i].getElementsByTagName('td');
                        for (let j = 0; j < cells.length; j++) {
                            if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                                visible = true;
                                break;
                            }
                        }
                        rows[i].style.display = visible ? '' : 'none';
                    }
                });
            }

            setupSearch('search-bundling', 'table-bundling');
            setupSearch('search-finished', 'table-finished');
            setupSearch('search-notpresent', 'table-notpresent');
            document.querySelectorAll('a[href*="destroy"]').forEach(a => {
            a.addEventListener('click', function(e) {
                if(!confirm('هل أنت متأكد من الغاء هذا الحجز؟')) e.preventDefault();
            });
        });
        });



    </script>
@endsection
