@extends('templates.tmplate1.layouts.app')
@section('content')
<!-- غلاف -->
<div class="relative bg-gray-200 h-64 w-full">
    <img src="{{ Storage::url($merchant->additional_data?$merchant->additional_data['banner']??'':'') }}" alt="cover" class="w-full h-full object-cover">
    <!-- صورة النشاط -->
    <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
        <img src="{{ Storage::url(isset($merchant->additional_data)?$merchant->additional_data['profile_picture']??'':'') }}" alt="logo" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
    </div>
</div>

<!-- البيانات الأساسية -->
<div class="mt-20 text-center px-4">
    <h1 class="text-2xl font-bold text-gray-800">{{ $merchant->business_name??'' }}</h1>
    <p class="text-gray-600 mt-2 max-w-xl mx-auto">{{ $merchant->additional_data?$merchant->additional_data['discription']??'':'' }}</p>

    <!-- العنوان وأوقات العمل -->
    <div class="mt-4 flex justify-center items-center flex-wrap gap-4 text-sm text-gray-500">
        @if(isset($merchant->phone))
        <div class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 2H8a2 2 0 00-2 2v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2zM12 18h.01" />
            </svg>

            <a href="tel:{{ $merchant->phone }}" dir="ltr">{{ $merchant->phone }}</a>
        </div>
        @endif
        <!-- <div class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657l4.243 4.243a8 8 0 1011.314-11.314z" />
            </svg>
            غزة، الرمال الجنوبي
        </div> -->
        <!-- <div class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16" />
            </svg>
            من 10 صباحاً إلى 8 مساءً
        </div> -->
    </div>

    <!-- روابط التواصل -->
    <div class="mt-6 flex justify-center gap-4">
        <a href="https://facebook.com" target="_blank">
            <img src="/icons/facebook.svg" alt="facebook" class="w-6 h-6 hover:scale-110 transition">
        </a>
        <a href="https://instagram.com" target="_blank">
            <img src="/icons/instagram.svg" alt="instagram" class="w-6 h-6 hover:scale-110 transition">
        </a>
        <a href="https://wa.me/970590000000" target="_blank">
            <img src="/icons/whatsapp.svg" alt="whatsapp" class="w-6 h-6 hover:scale-110 transition">
        </a>
    </div>
</div>


<section class="py-16 bg-white">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-10">الفعاليات</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto px-4">
        <!-- كارد منتج -->
        @foreach ($merchant->offers()->where('status','active')->get() as $offer)
        @livewire('tepmlates.template1.item', ['offer' => $offer,'merchant'=>$merchant])
        @endforeach
        <!-- كرر باقي المنتجات -->
    </div>
</section>
@endsection
