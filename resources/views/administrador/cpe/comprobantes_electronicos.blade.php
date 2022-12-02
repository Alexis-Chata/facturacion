@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <center>
        <h1>Comprobantes Electronicos</h1>
    </center>
@stop
@section('classes_body', 'sidebar-mini sidebar-collapse')
@section('content')
    <livewire:comprobantes-sunat />
    @livewireScripts
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
