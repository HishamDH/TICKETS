<div class="mb-6" dir="rtl" x-data="{ openIndex: null }">
    <label class="block text-base font-semibold mb-3 text-gray-700 text-xl">الرعاة <i class="ri-hand-heart-line inline text-blue-600"></i></label>

    <div class="flex flex-wrap justify-center gap-6">
        @foreach ($sponsors as $index => $sponsor)
            <div class="w-64 bg-white border-2 border-gray-200 hover:border-blue-500 rounded-lg shadow-lg p-4 relative transition-all duration-300">
                
                {{-- شعار الراعي --}}
                <div class="w-full h-32 bg-gray-100 rounded mb-2 flex items-center justify-center overflow-hidden">
                    @if(!empty($sponsor['logo']))
                        <img src="{{ asset('storage/' . $sponsor['logo']) }}" class="object-contain w-full h-full" alt="logo">
                    @else
                        <span class="text-gray-400 text-sm">لا يوجد شعار</span>
                    @endif
                </div>

                {{-- بيانات الراعي --}}
                <div class="space-y-1 text-sm text-gray-800">
                    <p class="font-semibold text-gray-900">{{ $sponsor['name'] }}</p>
                    <p class="text-gray-600">{{ $sponsor['level'] }}</p>
                    <p class="text-xs text-gray-500 line-clamp-3">{{ $sponsor['description'] }}</p>
                    <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 underline text-sm">الرابط</a>
                </div>

                {{-- زر More --}}
                <div class="text-center mt-2">
                    <button @click="openIndex = {{ $index }}" class="text-blue-600 font-semibold hover:text-blue-800">
                        <i class="ri-more-2-line"></i> More
                    </button>
                </div>
            </div>

            {{-- مودال Alpine.js للراعي --}}
            <div x-show="openIndex === {{ $index }}" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 mx-4 relative">
                    <button @click="openIndex = null" class="absolute top-2 left-2 text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                    <h3 class="text-lg font-semibold mb-2">{{ $sponsor['name'] }} <i class="ri-hand-heart-line inline text-blue-600"></i></h3>
                    <p class="text-gray-700 mb-1">المستوى: {{ $sponsor['level'] }}</p>
                    <p class="text-gray-700 mb-2 overflow-auto break-words" >{{ $sponsor['description'] }}</p>
                    @if(!empty($sponsor['link']))
                        <a href="{{ $sponsor['link'] }}" target="_blank" class="text-blue-600 underline text-sm">زيارة الموقع</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
