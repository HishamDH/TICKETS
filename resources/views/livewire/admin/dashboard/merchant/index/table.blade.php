<div>

    @php
    $access = false;
    if (adminPermission("staff_approval")) {
    $access = true;
    }
    @endphp
    <fieldset @if (!$access) disabled @endif>
        <table class="w-full caption-bottom text-sm">
            <thead class="[&amp;_tr]:border-b">
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">التاجر</th>
                    <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">النوع</th>
                    <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">الحالة</th>
                    <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">تاريخ الانضمام</th>
                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 text-left">إجراءات</th>
                </tr>
            </thead>
            <tbody class="[&amp;_tr:last-child]:border-0">
                @foreach($merchants as $merchant)
                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 font-medium">
                        <a href="{{ route('template', $merchant->id) }}" class="merchant-card">
                            {{ $merchant->f_name.' '.$merchant->l_name }}
                        </a>
                    </td>
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">{{ $merchant->business_type!='other'?$merchant->business_type:$merchant->additional_data['other_business_type']??'' }}</td>
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent {{$merchant->status=='active'?'bg-emerald-100 text-emerald-800':($merchant->status=='rejected'?'bg-red-100 text-red-800':'bg-amber-100 text-amber-800')}}" bis_skin_checked="1">{{ $merchant->status=='active'?'مفعل':($merchant->status=='rejected'?'مرفوض':'طلب جديد')}}</div>
                    </td>
                    <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">{{ $merchant->created_at->format('Y-m-d') }}</td>
                    <td class="p-4 align-middle text-left relative overflow-visible">
                        <button onclick="toggleMenu(this)" class="inline-flex items-center justify-center rounded-md text-sm font-medium hover:bg-gray-100 focus:outline-none h-10 w-10">
                            <!-- أيقونة النقاط الثلاث -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="19" cy="12" r="1"></circle>
                                <circle cx="5" cy="12" r="1"></circle>
                            </svg>
                        </button>

                        <!-- القائمة المخفية -->
                        <div class="action-menu absolute left-0 mt-2 w-36 rounded-md shadow bg-white border border-slate-200 z-50 hidden">
                            <a href="#" wire:click.prevent="acceptMerchant({{ $merchant->id }})" class="block w-full text-right px-4 py-2 text-sm text-green-700 hover:bg-green-50">قبول</a>
                            <a href="#" wire:click.prevent="rejectMerchant({{ $merchant->id }})" class="block w-full text-right px-4 py-2 text-sm text-red-700 hover:bg-red-50">رفض</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
</div>