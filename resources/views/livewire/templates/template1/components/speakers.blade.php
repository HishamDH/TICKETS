<div class="mb-6" dir="rtl" x-data="{ openIndex: null }">
    <label class="block text-base font-semibold mb-3 text-gray-700 text-xl">المتحدثين </label>

    <div class="flex flex-wrap justify-center gap-6">
        @foreach ($speakers as $index => $speaker)
            <div class="min-w-[250px] max-w-[250px] bg-white border-2 border-gray-200 hover:border-blue-500 rounded-lg shadow-lg p-3 relative transition-all duration-300">
                
                {{-- صورة المتحدث --}}
                <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                    @if(is_string($speaker['image']) && $speaker['image'] !== '')
                        <img src="{{ Storage::url($speaker['image']) }}" class="object-cover w-full h-full" alt="speaker image">
                    @else
                        <span class="text-gray-400">لا صورة</span>
                    @endif
                </div>

                {{-- بيانات المتحدث --}}
                <div class="space-y-1 text-sm text-gray-800">
                    <p class="font-semibold text-gray-900">{{ $speaker['name'] }}</p>
                    <p class="text-gray-600">{{ $speaker['title'] }}</p>
                    <p class="text-xs text-gray-500 line-clamp-2">{{ $speaker['shortDescreption'] }}</p>
                </div>

                {{-- زر More --}}
                <div class="text-center mt-2">
                    <button @click="openIndex = {{ $index }}" class="text-blue-600 font-semibold hover:text-blue-800">
                        <i class="ri-more-2-line"></i> More
                    </button>
                </div>
            </div>

            {{-- مودال Alpine.js للمتحدث --}}
            <div x-show="openIndex === {{ $index }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mx-4 relative">
                    <button @click="openIndex = null" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                    <h3 class="text-lg font-semibold mb-2">{{ $speaker['name'] }} <i class="ri-mic-line inline text-blue-600"></i></h3>
                    <p class="text-gray-700 mb-1">الوظيفة: {{ $speaker['title'] }}</p>
                    <p class="text-gray-700 mb-2">{{ $speaker['shortDescreption'] }}</p>
                    @if(!empty($speaker['cv']))
                        <a href="{{ $speaker['cv'] }}" target="_blank" class="text-blue-600 underline text-sm">عرض السيرة الذاتية</a>
                    @endif
                </div>
            </div>

        @endforeach
    </div>
</div>
