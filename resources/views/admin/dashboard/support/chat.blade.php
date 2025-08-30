@extends('admin.layouts.app')

@section('content')



@livewire('support-chat', ['support_id' => $ticket->id,"finalID" => Auth::guard('admin')->user()->id,"merchantid" => null])





@endsection