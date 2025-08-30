<nav class="flex flex-col gap-2">

    @php
        $workerNotActive = false;
        if (is_work(Auth::guard('merchant')->user()->id) && Auth::guard('merchant')->user()->status == 'pending') {
            //session()->regenerate();
            $workerNotActive = true;
        }
    @endphp
    @if (!$workerNotActive || $merchant)
    @livewire("merchant.aside.nav2",["merchant"=>$merchant,"workerNotActive"=>$workerNotActive])

    @elseif (is_work(Auth::id()) && !$merchant)
        @livewire("merchant.aside.nav3",["merchant"=>$merchant,"workerNotActive"=>$workerNotActive])
    @endif




</nav>
