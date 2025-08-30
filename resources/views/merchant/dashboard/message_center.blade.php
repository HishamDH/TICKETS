@extends('merchant.layouts.app',["merchant" => $merchantid ?? false])
@section('content')

@livewire('chat_center',["finalID" => $finalID, "merchantid" => $merchantid ?? false])


@endsection
