@extends('layouts.view')
@section('content')
@if ($template == 1)
@livewire('templates.template1.view',['id' => $id])
@endif
