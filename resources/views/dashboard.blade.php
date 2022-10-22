@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="container mt-4">
    <div class="row my-4">
        <div class="col-12 col-md-4" style="margin: auto"><center><img src="{{asset('imagenes/logo_compacto_3.jpg')}}" class="card-img-top"></center></div>
    </div>
    <div class="row">
        <div class="col">
            <center>
            <div class="card" style="width: 18rem;">
                <center><img src="https://cdn-icons-png.flaticon.com/512/2331/2331941.png" class="card-img-top" alt="..." style="width:50%;"></center>
                <div class="card-body">
                <p class="card-title fs-1"><center><b>EMITIR PAGOS</b></center></p>
                <p class="card-text"></p>
                <a  class="btn btn-primary" href="{{route('admin.recibos')}}">Ingresar</a>
                </div>
            </div>
            </center>
        </div>
        <div class="col">
            <center>
            <div class="card" style="width: 18rem;">
                <center>
                <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" class="card-img-top" alt="..." style="padding : 10%;width:50%;">
                </center>
                <div class="card-body">
                <p class="card-title fs-1" ><center><b>REPORTE DE CAJA</b></center></p>
                <p class="card-text"></p>
                <a  class="btn btn-primary" href="{{route('admin.reportes')}}">Ingresar</a>
                </div>
            </div>
            </center>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
