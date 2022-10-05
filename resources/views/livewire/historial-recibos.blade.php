<div class="col container mt-4">
    <div class="card card-secondary mb-2">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col col-md-3">
                    <h5>RECIBO</h5>
                </div>
            </div>
        </div>

        <div class="card-body p-inherit table-responsive">

            <div class="row">
                <div class="col">
                    <h3>Datos del cliente</h3>
                    <p>{{ $hcliente->name." ".$hcliente->paterno." ".$hcliente->materno }}</p>
                    <p><strong>Direccion del cliente: </strong>{{ " ".$hcliente->paterno }}</p>
                </div>
                <div class="col">
                    <p><strong>numero de recibo :</strong> 8</p>
                    <p><strong>fecha :</strong> {{ now()->format('d-m-Y') }}</p>
                    <p><strong>Forma de pago :</strong> Deposito</p>
                </div>
            </div>

            <div class="card card-secondary m-3">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col col-md-3">
                            <h5>Servicios</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-inherit table-responsive">
                    <div class="row align-items-center">
                        <div class="col-4" wire:ignore>
                            {{-- <input type="text" class="form-control" name="servicio" id="servicio" placeholder="Servicio"> --}}
                            {{-- <label for="listaServicios"> Servicio: </label> --}}
                            <select name="listaServicios" id="listaServicios" class="form-control" wire:model='servicioSeleccionado'>
                                <option> Seleccione un servicio</option>
                                @foreach ( $listaServicios as $listaServicio )
                                    <option value="{{ $listaServicio->id }}">{{ $listaServicio->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col form-label-group">
                            <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" wire:model='cantidad'>
                            <label for="total"> Cantidad: </label>
                        </div>
                        <div class="col form-label-group">
                            <input type="text" class="form-control" name="costo" id="costo" placeholder="Costo" wire:model='costo'>
                            <label for="total"> Costo: </label>
                        </div>
                        <div class="col form-label-group">
                            <input type="text" class="form-control" name="total" id="total" placeholder="Total" disabled wire:model='total'>
                            <label for="total"> Total: </label>
                        </div>
                        <div class="col">
                            <button class="btn btn-success">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">Descripcion</th>
                        <th scope="col" class="text-center">Cantidad</th>
                        <th scope="col" class="text-center">Precio</th>
                        <th scope="col" class="text-center">Importe</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hcliente->recibos->sortByDesc('femision') as $recibo)
                        <tr>
                            <td scope="row" class="text-center">REC - {{ $recibo->correlativo }}</td>
                            <td scope="row" class="text-center">{{ date('d-m-Y', strtotime($recibo->femision)) }}</td>
                            <td scope="row" class="text-center">{{ $recibo->termino }}</td>
                            <td scope="row" class="text-center">{{ $recibo->termino }}</td>
                            <td scope="row" class="text-center">
                                <button class="btn btn-danger"><i class="far fa-trash-alt" aria-hidden="true"></i></button>
                                <button class="btn btn-warning"><i class="far fa-edit" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-success">Generar Comprobante</button>
        </div>
    </div>

    <div  class="card card-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col col-md-3"><h5>HISTORIAL DE RECIBO</h5></div>
                <div class="col col-md-3"><button class="btn btn-success">Descargar Informe</button></div>
                <div class="col col-md-3"><input type="date" class="form-control" wire:model="finicio"></div>
                <div class="col col-md-3"><input type="date" class="form-control" wire:model="ffinal"></div>
            </div>
        </div>
    <div class="card-body p-inherit table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col" class="text-center">Recibo</th>
                <th scope="col" class="text-center">F. Emisión</th>
                <th scope="col" class="text-center">Termino</th>
                <th scope="col" class="text-center">Total</th>
                <th scope="col" class="text-center">Detalles</th>
                <th scope="col" class="text-center">Estado</th>
                <th scope="col" class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hcliente->recibos->sortByDesc('femision') as $recibo)
            <tr>
                <td scope="row" class="text-center">REC - {{$recibo->correlativo}}</td>
                <td scope="row" class="text-center">{{date("d-m-Y",strtotime($recibo->femision))}}</td>
                <td scope="row" class="text-center">{{$recibo->termino}}</td>
                <td scope="row" class="text-center">Q.{{$recibo->total}}</td>
                <td scope="row" class="text-center"><button class="btn btn-primary">{{$recibo->detalles->count()}}</button></td>
                <td scope="row" class="text-center">cancelado</td>
                <td scope="row" class="text-center">
                    <button class="btn btn-danger"  wire:loading.attr="disabled" wire:target="reenviar" wire:click="reenviar('{{$recibo->id}}')">Reenviar</button>
                    <button class="btn btn-warning">Editar</button>
                    <button class="btn btn-success"  wire:loading.attr="disabled" wire:target="descargar_recibo" wire:click="descargar_recibo('{{$recibo->id}}')">Descargar</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    </div>
    <script>
        window.onload = function () {
        $(document).ready(function(){
                $('#listaServicios').select2();
                $('#listaServicios').on('change', function(){
                    let valor = $('#listaServicios').select2('val');
                    let texto = $('#listaServicios option:selected').text();
                        @this.set('servicioSeleccionado', texto);
                });
            }
        )
        }
    </script>

</div>
