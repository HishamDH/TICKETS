@extends('customer.layouts.app')

@section('content')


@livewire('support-chat', ['support_id' => $ticket->id])





@endsection