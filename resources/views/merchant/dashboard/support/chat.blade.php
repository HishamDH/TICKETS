@extends('merchant.layouts.app' , ["merchant" => $merchantid ?? false])

@section('content')


@livewire('support-chat', ['support_id' => $ticket->id ,
                            'merchantid' => $merchantid ?? false,
                            'finalID' => $finalID])






@endsection