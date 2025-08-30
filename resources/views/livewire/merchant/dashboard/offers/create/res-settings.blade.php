<form wire:change="saveTimeSettings">
    <div class="space-y-6">

        {{-- Toggle: تفعيل تحديد مدة الحجز --}}
        @if ($offering->type == "services")

        <div>
            {{-- <div class="flex items-center justify-between">
                <label class="text-sm font-medium">تحديد مدة الحجز؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_duration" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div> --}}
            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- مدة الحجز -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        مدة الحجز <span class="text-red-500" style="font-weight: bold;">*</span>
                    </label>
                    <input type="number" wire:model.lazy="booking_duration" class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300">
                    <p class="text-xs text-gray-500 mt-1">
                        مدة بقاء تذكرة واحدة في العرض
                    </p>
                </div>

                <!-- الوحدة -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        الوحدة
                    </label>
                    <select wire:model.lazy="booking_unit" class="w-full border rounded-md p-2 focus:outline-none focus:ring focus:border-blue-300">
                        <option value="hour">ساعة</option>
                        <option value="minute">دقيقة</option>
                    </select>
                </div>
            </div>

        </div>

        {{-- Toggle: الوقت بين كل حجز وآخر للمستخدم
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">الوقت بين كل حجز وآخر للمستخدم؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_user_interval" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_user_interval)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">المدة بين الحجوزات</label>
                    <input type="number" wire:model.lazy="user_interval_minutes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: الوقت بين كل حجز وآخر للخدمة كاملة
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">الوقت بين كل حجز وآخر للخدمة؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_global_interval" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_global_interval)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">المدة بين الحجوزات</label>
                    <input type="number" wire:model.lazy="global_interval_minutes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div> --}}

        {{-- Toggle: تحديد أيام وأوقات العمل --}}
        @if ($type == 'restaurant')


        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">تحديد أوقات وأيام العمل؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_work_schedule" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_work_schedule)
            <div class="mt-4 grid grid-cols-1 gap-4">
                @php
                    $days = [
                        'saturday' => 'السبت',
                        'sunday' => 'الأحد',
                        'monday' => 'الإثنين',
                        'tuesday' => 'الثلاثاء',
                        'wednesday' => 'الأربعاء',
                        'thursday' => 'الخميس',
                        'friday' => 'الجمعة',
                    ];
                @endphp

                @foreach ($days as $key => $label)
                    <div class="border rounded-md p-4 space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="font-semibold">{{ $label }}</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.lazy="work_schedule.{{ $key }}.enabled" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                            </label>
                        </div>

                        @if ($work_schedule[$key]['enabled'])
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-sm font-medium mb-1">وقت البدء</label>
                                    <input type="time" wire:model.lazy="work_schedule.{{ $key }}.start" class="w-full border rounded-md p-2">
                                </div>
                                <div>
                                    <label class="text-sm font-medium mb-1">وقت الانتهاء</label>
                                    <input type="time" wire:model.lazy="work_schedule.{{ $key }}.end" class="w-full border rounded-md p-2">
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif


        </div>
        @endif

        {{-- Toggle: أيام ممنوع العمل فيها --}}
        @if ($type == 'restaurant')

<div>
    <div class="flex items-center justify-between">
        <label class="text-sm font-medium">أيام مغلقة (مثل الأعياد)؟</label>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" wire:model.lazy="enable_closed_days" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
        </label>
    </div>

    @if ($enable_closed_days)
        <div class="mt-4 space-y-3">

            {{-- إدخال تاريخ جديد --}}
            <div class="flex items-center gap-2">
                <input type="date" wire:model.lazy="new_closed_day" class="w-full border rounded-md p-2">
                <button type="button" wire:click="addClosedDay" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    إضافة
                </button>
            </div>

            {{-- عرض الأيام الحالية --}}
            @if (!empty($closed_days))
                <ul class="space-y-1">
                    @foreach ($closed_days as $index => $day)
                        <li class="flex items-center justify-between border p-2 rounded-md bg-gray-50">
                            <span>{{ $day }}</span>
                            <button type="button" wire:click="removeClosedDay({{ $index }})" class="text-red-600 hover:underline">حذف</button>
                        </li>
                    @endforeach
                </ul>
            @endif

        </div>
    @endif
</div>
@endif
        {{-- Toggle: عدد المستخدمين المسموح به لكل حجز --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">عدد المستخدمين لكل الخدمة ؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_user_limit" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_user_limit)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">العدد المسموح</label>
                    <input type="number" wire:model.lazy="user_limit" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        @endif

        @if ($offering->type == "services")
        <div>
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <label class="text-sm font-medium block">
                        أقصى عدد للأشخاص الذين يمكنهم الحجز في نفس الوقت؟
                    </label>
                
                    <p class="text-sm text-gray-500">
                        عند تفعيل هذه الخاصية، يمكنك تحديد عدد أقصى للأشخاص الذين يمكنهم الحجز في نفس الدقيقة.  
                        مثلاً: إذا تم تحديد الحد بـ 10 أشخاص لدقيقة، فلن يتمكن أي شخص إضافي من الحجز في تلك الدقيقة إذا وصل العدد للحد الأقصى، وسيتوجب عليه الانتضار حتى تنتهي الدقيقة وتتجدد الكمية.
                    </p>
                </div>
                
                

                    {{-- <input type="checkbox" wire:model.lazy="enable_max_users" class="sr-only peer"> --}}
                    {{-- <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div> --}}
                </label>
            </div>
            <div class="mt-2 space-y-2">
                <div>
                    <label class="block text-sm font-medium mb-1">العدد المسموح</label>
                    <input type="number" wire:model.lazy="max_user_time" class="w-full border rounded-md p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">الوحدة</label>
                    <select wire:model.lazy="max_user_unit" class="w-full border rounded-md p-2">
                        <option value="minute">دقيقة</option>
                        <option value="hour">ساعة</option>
                        <option value="day">يوم</option>
                        <option value="week">أسبوع</option>
                    </select>
                </div>
            </div>


        </div>
        @elseif ($offering->type == "events")
        <div class="flex items-center justify-between">
            <div class="space-y-2">
        <label class="text-sm font-medium block">
            أقصى عدد للأشخاص الذين يمكنهم الانضمام ?
        </label>
        <div>
            <label class="block text-sm font-medium mb-1">العدد المسموح</label>
            <input type="number" wire:model.lazy="eventMaxQuantity" class="w-full border rounded-md p-2">
        </div>
        </div>
    </div>

        @endif



        {{-- Toggle: أقصى وقت للحجز قبل البداية --}}
        <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">آخر وقت للحجز قبل البدء؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_booking_deadline" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_booking_deadline)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">عدد الدقائق قبل البدء</label>
                    <input type="number" wire:model.lazy="booking_deadline_minutes" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div>

        {{-- Toggle: تفعيل التكرار (مثل جلسات أسبوعية) --}}
        {{-- <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">تفعيل التكرار (مثلاً جلسات أسبوعية)؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_weekly_recurrence" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
            @if ($enable_weekly_recurrence)
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">اختر أيام التكرار</label>
                    <input type="text" wire:model.lazy="weekly_recurrence_days" placeholder="مثل: السبت, الثلاثاء" class="w-full border rounded-md p-2">
                </div>
            @endif
        </div> --}}

        {{-- Toggle: السماح للعميل بتحديد وقت البداية والنهاية بنفسه --}}
        {{-- <div>
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium">السماح للعميل باختيار وقت البداية والنهاية؟</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.lazy="enable_client_time_selection" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
                </label>
            </div>
        </div> --}}
        
@if ($offering->type == "services" && ($offering->features["center"] ?? null) == "place")
<div>
    {{-- <div class="flex items-center justify-between">
        <label class="text-sm font-medium">هل تريد تحديد الفروع لهذه الخدمة؟</label>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" wire:model.lazy="enable_selected_branches" class="sr-only peer">
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-blue-600 transition-all"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow-md transform peer-checked:translate-x-full transition-all"></div>
        </label>
    </div> --}}

        <div class="mt-4 space-y-3">
            <label class="block text-sm font-medium mb-1">اختر الفروع التي تقدم هذه الخدمة:</label>
            <div class="border rounded-md p-3 bg-white shadow-sm space-y-2 max-h-64 overflow-y-auto">
                @foreach ($branches as $branch)
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            wire:model.lazy="selected_branches"
                            value="{{ $branch->id }}"
                            class="form-checkbox text-blue-600 rounded focus:ring-blue-500"
                        >
                        <span class="text-sm ml-16"> {{ $branch->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
</div> 
@endif




    </div>
</form>

