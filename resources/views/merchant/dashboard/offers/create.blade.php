@extends('merchant.layouts.app')
@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>




        {{-- <div class="grid grid-cols-12 gap-6"> --}}
            {{-- خطوات التسجيل - السلم --}}
                @livewire('merchant.dashboard.offers.setup-steps', ['offering' => $offering])
            

            {{-- نموذج تعبئة المعلومات --}}
  
            
            <div class="col-span-9">

             {{-- 

                {{--  --}}

                 {{-- @if ($currentStep == 1)
                    @livewire('merchant.dashboard.offers.create.information', ['offering' => $offering])
                @elseif ($currentStep == 4)
                    @livewire('merchant.dashboard.offers.create.gallery', ['offering' => $offering])
                @elseif ($currentStep == 2)
                    @livewire('merchant.dashboard.offers.create.prices', ['offering' => $offering]) 
                @elseif ($currentStep == 3)
                    @livewire('merchant.dashboard.offers.create.res_settings', ['offering' => $offering])
                @endif  --}}
            </div>

        </div>
    </div>
</div>



<script>
    const hasChairsCheckbox = document.getElementById('hasChairs');
    const chairsCountContainer = document.getElementById('chairsCountContainer');

    hasChairsCheckbox.addEventListener('change', function () {
        chairsCountContainer.style.display = this.checked ? 'block' : 'none';
    });
</script>

@endsection
