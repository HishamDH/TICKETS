<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold">الأسئلة المطلوب الاجابة عليها  من قبل المستخدم</h3>
        <button type="button" wire:click="addQuestion" class="text-blue-600 hover:underline text-sm">+ إضافة سؤال</button>
    </div>

    @foreach ($questions as $qIndex => $question)
    <div class="space-y-3 border border-slate-200 rounded-lg p-4">
        <div>
            <label class="text-sm font-medium">السؤال</label>
            <input type="text"
            wire:model.lazy="questions.{{ $qIndex }}.question"
            class="w-full border rounded-md p-2"
            @if(($question['status'] ?? null) === 'critical') disabled @endif>
             </div>



        {{-- الترجمات --}}
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-semibold">الترجمات</h4>
                <button type="button" wire:click="addTranslation({{ $qIndex }})" class="text-blue-500 text-sm hover:underline">+ إضافة ترجمة</button>
            </div>

            @foreach ($question['translations'] as $tIndex => $trans)
            <div class="grid md:grid-cols-3 gap-4 border p-3 rounded-md bg-slate-50">
                <div>
                    <label class="text-sm font-medium">اللغة</label>
                    <input type="text" wire:model.lazy="questions.{{ $qIndex }}.translations.{{ $tIndex }}.lang" class="w-full border rounded-md p-2" placeholder="مثال: en">
                </div>

                <div>
                    <label class="text-sm font-medium">السؤال المترجم</label>
                    <input type="text" wire:model.lazy="questions.{{ $qIndex }}.translations.{{ $tIndex }}.question" class="w-full border rounded-md p-2">
                </div>


                <div class="col-span-3 text-right">
                    <button type="button" wire:click="removeTranslation({{ $qIndex }}, {{ $tIndex }})" class="text-red-500 text-xs hover:underline">حذف الترجمة</button>
                </div>
            </div>
            @endforeach
        </div>

        {{-- زر حذف السؤال --}}
        @if (($question['status'] ?? null) !== 'critical')
        <div class="text-right">
            <button type="button" wire:click="removeQuestion({{ $qIndex }})" class="text-red-600 hover:underline text-sm">
                حذف السؤال
            </button>
        </div>
        @endif
    

    </div>
    @endforeach
</div>