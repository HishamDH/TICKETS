<div class="flex-1 p-8">
    <div class="space-y-8">
        <h2 class="text-3xl font-bold text-slate-800">مراجعات العملاء</h2>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- ملخص التقييمات -->
            <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg lg:col-span-1">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-xl font-semibold leading-none tracking-tight">ملخص التقييمات</h3>
                    <p class="text-sm text-slate-500">نظرة سريعة على آراء عملائك.</p>
                </div>
                <div class="p-6 pt-0 space-y-6">
                    @php
                        $total = $reviews->count();
                        $avg = $total > 0 ? round($reviews->avg('rating'), 1) : 0;
                        $counts = $reviews->groupBy('rating')->map->count();
                    @endphp

                    <div class="flex flex-col items-center justify-center gap-2">
                        <p class="text-5xl font-bold text-slate-800">{{ $avg }}</p>
                        <div class="flex items-center gap-1 text-amber-400 text-xl">
                            @for ($i = 1; $i <= 5; $i++)
                                {{ $i <= floor($avg) ? '★' : '☆' }}
                            @endfor
                        </div>
                        <p class="text-sm text-slate-500">بناءً على {{ $total }} تقييم</p>
                    </div>

                    <div class="h-[1px] w-full bg-border"></div>

                    <div class="space-y-3">
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $count = $counts[$i] ?? 0;
                                $percent = $total > 0 ? round(($count / $total) * 100) : 0;
                            @endphp
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-slate-500">{{ $i }} نجوم</span>
                                <div class="relative w-full h-2 rounded-full bg-slate-100">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $percent }}%;"></div>
                                </div>
                                <span class="text-sm text-slate-700 w-10 text-left">{{ $count }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- قائمة التقييمات -->
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-2xl border border-slate-200 bg-white text-slate-900 shadow-lg">
                    <div class="flex flex-col space-y-1.5 p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">قائمة المراجعات ({{ $total }})</h3>
                        </div>
                    </div>
                    @php
                    if($merchantid){
                        $hasReplyPermission = has_Permetion(Auth::id(),'ratings_reply', $merchantid);

                    }else {
                        $hasReplyPermission = true;
                    }
                       // $ = has_Permetion(Auth::id(), 'ratings_reply', $merchantid ?? false);
                    @endphp
                    <div class="p-6 pt-0 space-y-6">
                        @forelse($reviews as $review)
                            <div class="rounded-xl border p-4">
                                <div class="flex items-start gap-4">

                                    <img class="h-10 w-10 rounded-full" src="{{Storage::url($review->user->additional_data['profile_picture'] ?? '') ?: 'https://ui-avatars.com/api/?name=' . urlencode($review->user->f_name)}}" alt="Avatar">

                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <div>
                                                <p class="font-semibold text-slate-800">{{ $review->customer_name }}</p>
                                                <p class="text-xs text-slate-500">
                                                    {{ $review->created_at->format('Y-m-d') }}
                                                    • على خدمة "{{ $review->service->name }}"
                                                </p>
                                            </div>
                                            <div class="text-amber-400">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $review->rating ? '★' : '☆' }}
                                                @endfor
                                            </div>
                                        </div>

                                        @php
                                            $data = is_array($review->additional_data)
                                                ? $review->additional_data
                                                : (is_string($review->additional_data) ? json_decode($review->additional_data, true) : []);
                                        @endphp

                                        @if(!empty($review->review))
                                            <div class="mt-2 p-2 text-sm text-slate-800 bg-slate-50 rounded">
                                                <strong>تعليق العميل:</strong> {{ $review->review }}
                                            </div>
                                        @endif
                                        @if ($hasReplyPermission)
                                            @if(!empty($data['reply']) && empty($editingReply[$review->id]))
                                            <div class="mt-2 p-2 text-sm text-green-800 bg-green-50 rounded">
                                                <strong>ردك:</strong> {{ $data['reply'] }}
                                            </div>
                                            <button wire:click="startEditing({{ $review->id }})" class="mt-1 text-blue-600 text-sm hover:underline">تعديل الرد</button>
                                            @endif

                                            @if(empty($data['reply']) || !empty($editingReply[$review->id]))
                                            <div class="flex gap-2 mt-2">
                                                <textarea wire:model.defer="replyText.{{ $review->id }}" class="flex-1 rounded-md border p-2 text-sm" placeholder="اكتب ردك على {{ $review->customer_name }}..."></textarea>
                                                <button wire:click="sendReply({{ $review->id }})" class="bg-blue-600 text-white px-3 rounded-md hover:bg-blue-700 text-sm">
                                                    حفظ
                                                </button>
                                                @if(!empty($editingReply[$review->id]))
                                                    <button wire:click="cancelEditing({{ $review->id }})" class="bg-gray-400 text-white px-3 rounded-md hover:bg-gray-500 text-sm">
                                                        إلغاء
                                                    </button>
                                                @endif
                                            </div>
                                            @endif

                                            <button wire:click="hideReview({{ $review->id }})" class="mt-2 text-sm text-red-600 hover:underline">
                                            حذف التقييم
                                            </button>
                                        @else
                                                <span class="text-sm text-red-600">ليس لديك صلاحية للرد على هذا التقييم.</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 py-8">لا توجد تقييمات حالياً.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
