@extends('layouts.view')
@section('content')
@livewire('templates.templateRouter',["merchant"=>$merchant??false,"template"=>$template??false])