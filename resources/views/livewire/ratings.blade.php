<div class="max-w-md mx-auto p-6 bg-white border border-purple-300 rounded-2xl shadow-lg space-y-6 text-center">
    @if ($visible)

        @if (session()->has('message'))
            <div class="p-3 text-green-700 bg-green-100 border border-green-300 rounded-md text-sm">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 text-red-700 bg-red-100 border border-red-300 rounded-md text-sm">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-3xl font-bold text-purple-700">التقييم والمراجعة</h2>

        <!-- النجوم -->
        <div>
            <label class="block text-gray-800 font-semibold mb-3">التقييم بالنجوم:</label>
            <div class="flex justify-center gap-3">
                @for ($i = 1; $i <= 5; $i++)
                    <button
                        wire:click="$set('rating', {{ $i }})"
                        type="button"
                        class="focus:outline-none transition-transform hover:scale-110 duration-200"
                    >
                        @if ($rating >= $i)
                            <!-- star-fill -->
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-9 h-9 text-purple-500">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @else
                            <!-- star-line -->
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-9 h-9 text-purple-400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endif
                    </button>
                @endfor
            </div>
        </div>

        <!-- المراجعة -->
        <div class="mt-6">
            <label for="review" class="block text-gray-800 font-semibold mb-2">اكتب مراجعتك:</label>
            <textarea
                id="review"
                wire:model="review"
                rows="4"
                class="w-full border border-purple-300 rounded-lg p-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400 transition resize-none"
                placeholder="اكتب رأيك عن الخدمة هنا..."
            ></textarea>
        </div>

        <div class="mt-6">
            <button
                wire:click="hideComponent"
                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-8 py-2 rounded-full shadow-md transition"
            >
                تم الإرسال
            </button>
        </div>
    @endif
    @if (!$visible)
        <div class="text-gray-600">
            <p class="text-lg font-semibold mb-2">شكراً لتقييمك!</p>
            <p>إذا كان لديك أي استفسارات أو تحتاج إلى مساعدة، لا تتردد في التواصل معنا.</p>
        </div>
        
        
    @endif
</div>
<script>
    // أظهر المودال تلقائيًا عند فتح الصفحة
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('ratings-modal').classList.remove('hidden');
    });

    // اختياري: اغلقه لو ضغط خارج المكون
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('ratings-modal');
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>