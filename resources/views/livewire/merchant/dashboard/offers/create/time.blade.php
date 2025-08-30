<form wire:submit.prevent wire:Poll.1s>
    <div class="space-y-4">

        {{-- <div>
            <label class="flex items-center gap-2">
                <input type="checkbox" wire:model="enable_time" class="form-checkbox">
                <span>تفعيل الوقت</span>
            </label>
        </div> --}}
        {{-- @dd($offering->type) --}}


        @if ($offering->type == 'services')
            <div class="border rounded-md p-4 space-y-4">
                <h3 class="text-md font-bold mb-2">اليوم الافتراضي</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model.lazy="default_day.enabled" class="form-checkbox">
                        <span>مفعل</span>
                    </label>
                    <input type="time" wire:model.lazy="default_day.from" class="border rounded p-2">
                    <input type="time" wire:model.lazy="default_day.to" class="border rounded p-2">
                    <button type="button" wire:click="applyDefaultToAll" class="bg-blue-600 text-white px-3 py-2 rounded col-span-full">تطبيق على الكل</button>
                </div>

                <h3 class="text-md font-bold mb-2">الأيام والأوقات <span class="text-red-500" style="font-weight: bold;">*</span></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(['saturday','sunday','monday','tuesday','wednesday','thursday','friday'] as $dayName)
                        <div class="border rounded-md p-3">
                            <label class="flex items-center gap-2 mb-2">
                                <input type="checkbox" wire:model.lazy="day.{{ $dayName }}" class="form-checkbox">
                                <span>{{ ucfirst($dayName) }}</span>
                            </label>

                            @if(!empty($day[$dayName]))
                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-sm mb-1">من:</label>
                                        <input type="time" wire:model.lazy="from_time.{{ $dayName }}" class="w-full border rounded-md p-2">
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1">إلى:</label>
                                        <input type="time" wire:model.lazy="to_time.{{ $dayName }}" class="w-full border rounded-md p-2">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    
                </div>
                <div class="w-full border-t pt-4 mt-6">
                    <div class="w-full bg-gray-100 p-4 rounded-md flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 mb-1">تفعيل تاريخ انتهاء الحجز</h4>
                            <p class="text-sm text-gray-500">يمنع الحجز بعد التاريخ المحدد. أوقف التفعيل للسماح بالحجوزات بلا تاريخ انتهاء.</p>
                        </div>
                    
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-medium {{ $active_max_reservation_date ? 'text-blue-600' : 'text-gray-500' }}">
                                {{ $active_max_reservation_date ? 'مفعّل' : 'غير مفعّل' }}
                            </span>
                    
                            <button type="button"
                                wire:click="$toggle('active_max_reservation_date')"
                                class="relative inline-flex items-center h-8 w-16 rounded-full transition-colors duration-300 ease-in-out 
                                    {{ $active_max_reservation_date ? 'bg-blue-600' : 'bg-gray-300' }}">
                                
                                <span class="absolute left-1 top-1 h-6 w-6 rounded-full bg-white shadow-md transform transition-transform duration-300 ease-in-out 
                                    {{ $active_max_reservation_date ? 'translate-x-8' : 'translate-x-0' }}">
                                </span>
                            </button>
                        </div>
                    </div>
                    
                
                
                
                @if ($active_max_reservation_date)
                    <div>
                        <label class="block text-sm font-bold mb-2">آخر تاريخ متاح للحجز <span class="text-red-500">*</span></label>
                        <input
                            type="date"
                            wire:model.lazy="max_reservation_date"
                            min="{{ now()->toDateString() }}"
                            class="w-full border rounded-md p-2"
                        >
                        <p class="text-sm text-gray-500 mt-1">لن يتمكن العملاء من الحجز بعد هذا التاريخ. حتى يتم تجديده</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- EVENTS --}}
        @if ($offering->type == 'events')
            <div class="border rounded-md p-4 space-y-4">
                <h3 class="text-md font-bold mb-2">مواعيد الفعالية (من → إلى) <span class="text-red-500" style="font-weight: bold;">*</span></h3>
                @foreach ($calendar as $index => $item)
                    <div class="border rounded p-3 space-y-2">
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm mb-1">من تاريخ:</label>
                                <input type="date" wire:model.lazy="calendar.{{ $index }}.start_date" class="w-full border rounded-md p-2">
                            </div>
                            <div>
                                <label class="block text-sm mb-1">إلى تاريخ:</label>
                                <input type="date" wire:model.lazy="calendar.{{ $index }}.end_date" class="w-full border rounded-md p-2">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm mb-1">من وقت:</label>
                                <input type="time" wire:model.lazy="calendar.{{ $index }}.start_time" class="w-full border rounded-md p-2">
                            </div>
                            <div>
                                <label class="block text-sm mb-1">إلى وقت:</label>
                                <input type="time" wire:model.lazy="calendar.{{ $index }}.end_time" class="w-full border rounded-md p-2">
                            </div>
                        </div>
                        <button type="button" wire:click="removeEvent({{ $index }})" class="text-red-600 text-sm">حذف</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addEvent" class="bg-blue-600 text-white px-3 py-2 rounded">+ إضافة موعد</button>
            </div>
        @endif
    </div>
</form>
