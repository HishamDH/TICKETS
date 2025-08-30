@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])
@section('content')

@livewire('merchant.dashboard.pos',['merchantid'=>$merchantid])

@endsection
