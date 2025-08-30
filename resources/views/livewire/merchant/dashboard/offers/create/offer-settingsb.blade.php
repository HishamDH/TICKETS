<div>
<p class="text-red-600">لايتم اضهار الصور حتى يتم الحفض</p>

{{--tourism--}}
@livewire("merchant.dashboard.offers.create.components.session",['offering'=>$offering])

@if ($category == "tourism")
    @livewire("merchant.dashboard.offers.create.components.destination",[ 'offering'=>$offering])

@endif
{{--gallery--}}
@if ($category === 'exhibition')
    @livewire("merchant.dashboard.offers.create.components.products",[ 'offering'=>$offering])
@endif

{{--all--}}
{{--eelctronics--}}
@if ($category == "maintenance")
    @livewire("merchant.dashboard.offers.create.components.support-devices",[ 'offering'=>$offering])

@endif

{{--train--}}
@if ($category == "workshop")
    @livewire("merchant.dashboard.offers.create.components.train-workshops",[ 'offering'=>$offering])
@endif
{{--rest--}}
@if ($category =="restaurant")
    @livewire("merchant.dashboard.offers.create.components.plats",[ 'offering'=>$offering])

@endif

{{--net--}}
@if ($category == "online")
    @livewire("merchant.dashboard.offers.create.components.eventlinks",[ 'offering'=>$offering])

@endif
{{--ser net--}}

{{--childs--}}
@if ($category == "children_event")
    @livewire("merchant.dashboard.offers.create.components.games",[ 'offering'=>$offering])
    @livewire("merchant.dashboard.offers.create.components.kidshops",[ 'offering'=>$offering])
    @livewire("merchant.dashboard.offers.create.components.cartoons",[ 'offering'=>$offering])
@endif

{{--obbl--}}
@if ($type =="services")
    @livewire("merchant.dashboard.offers.create.components.portfolio",[ 'offering'=>$offering])
@endif
@livewire("merchant.dashboard.offers.create.components.speakers",[ 'offering'=>$offering])
@livewire("merchant.dashboard.offers.create.components.offer-features",[ 'offering'=>$offering])
@livewire("merchant.dashboard.offers.create.components.sponsors",['offering'=>$offering])
@livewire("merchant.dashboard.offers.create.components.activities",[ 'offering'=>$offering])
@livewire("merchant.dashboard.offers.create.components.services",[ 'offering'=>$offering])
@livewire("merchant.dashboard.offers.create.components.tools",[ 'offering'=>$offering])



</div>
    {{-- @livewire("templates.template1.components.activities", ["offering" => $offering])
    @livewire("templates.template1.components.cartoons", ["offering" => $offering])
    @livewire("templates.template1.components.destination", ["offering" => $offering])
    @livewire("templates.template1.components.eventlinks", ["offering" => $offering])
    @livewire("templates.template1.components.games", ["offering" => $offering])
    @livewire("templates.template1.components.kidshops", ["offering" => $offering])
    @livewire("templates.template1.components.offer-features", ["offering" => $offering])
    @livewire("templates.template1.components.plats", ["offering" => $offering])
    @livewire("templates.template1.components.portfolio", ["offering" => $offering])
    @livewire("templates.template1.components.products", ["offering" => $offering])
    @livewire("templates.template1.components.services", ["offering" => $offering])
    @livewire("templates.template1.components.session", ["offering" => $offering])
    @livewire("templates.template1.components.speakers", ["offering" => $offering])
    @livewire("templates.template1.components.sponsors", ["offering" => $offering])
    @livewire("templates.template1.components.support-devices", ["offering" => $offering])
    @livewire("templates.template1.components.tools", ["offering" => $offering])
    @livewire("templates.template1.components.train-workshops", ["offering" => $offering]) --}}