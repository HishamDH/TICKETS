<a href="{{ route('template1.item',['id'=>$merchant->id,'offering'=>$offer->id]) }}" wire:click.prevent="fullView">
    <div class="border rounded-xl overflow-hidden shadow hover:shadow-lg transition">
        <img src="{{ Storage::url($offer->image??'') }}" alt="{{ $offer->name??'' }}" class="w-full h-48 object-cover">
        <div class="p-4">
            <h3 class="text-lg font-bold">{{ $offer->name??'' }}</h3>
            <p class="text-sm text-gray-500">{{ $offer->description??'' }}</p>
            @if(isset($offer->start_time)&& isset($offer->end_time))
            <p class="text-sm text-gray-500">{{ $offer->start_time->translatedFormat('h:i A').' - '.$offer->end_time->translatedFormat('h:i A') }}</p>
            @endif
            <p class="text-xl text-orange-600 font-bold">
                @php
                $final = $this->calcPrice($offer);
                @endphp
                @if ($offer->price??0 != $final)
                <apsn class="text-sm text-gray-500 line-through">{{ $offer->price }} ريال</apsn>
                @endif
                {{ $final }} ريال
            </p>
            <button class="mt-4 w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">احجز الآن</button>
        </div>
    </div>

</a>
