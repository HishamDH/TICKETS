@extends('merchant.layouts.app',['merchant' => $merchantid ?? false])
@section('content')

@livewire("Customer_reviews", ['merchantid' => $merchantid ?? false, 'finalID' => $finalID ?? false])

@endsection
