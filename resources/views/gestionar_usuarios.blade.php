@extends('adminlte::page')

@section('title', 'Dashboard')

@section('classes_body', 'sidebar-mini sidebar-collapse')

@section('content_header')
    <center>
        <h1>Fichas de Matriculas</h1>
    </center>
@stop
@section('content')
    @livewire('gestionar-usuarios')
    @livewire('historial-recibos')
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="/css/floating-labels.css">
    <style>
        .select2-container .select2-selection--single {
            height: 50px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px;
        }

        .select2-container--default .select2-selection--single {
            padding: 0.75rem .75rem;
        }
    </style>
    <!-- CSS only -->
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script>
        window.livewire.on('notificar_seleccion', accion => {
            document.getElementById("1_pestana").click();
        });

        window.livewire.on('notificar_listado', accion => {
            document.getElementById("1_listado").click();
        });

        window.livewire.on('notificar_seleccion_servicio', accion => {
            document.getElementById("1_pestana_s").click();
        });

        window.livewire.on('notificar_listado_servicio', accion => {
            document.getElementById("1_listado_s").click();
        });

        window.livewire.on('cerrar_modal', () => {
            $('#modal_crear_actualizar_cliente').modal('hide');
            Livewire.emit('modal')
        })

        window.livewire.on('abrir_modal', () => {
            $('#modal_crear_actualizar_cliente').modal('show');
            $('[href="#files"]').tab('show');
            Livewire.emit('modal')
        })

    </script>

@stop
