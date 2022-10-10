<div class="col container mt-4">
    <div class="card card-secondary mb-4">
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
                    <h3 class="mb-3">Datos del cliente</h3>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p><strong>Cliente: </strong>{{ $hcliente->name . ' ' . $hcliente->paterno . ' ' . $hcliente->materno }}</p>
                    <p><strong>Direccion del cliente: </strong>{{ ' ' . $hcliente->direccion }}</p>
                </div>
                <div class="col">
                    @if ($editar)
                        <p><strong>numero de recibo :</strong> 8</p>
                    @endif
                    <p><strong>fecha :</strong> {{ now()->format('d-m-Y') }}</p>
                    <p><strong>Forma de pago :</strong> Deposito</p>
                </div>
            </div>

            <div class="card card-secondary m-3 floating ">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col col-md-3">
                            <h5>Servicios</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-inherit table-responsive">
                    <form>
                        <div class="row align-items-center">
                            <div class="col-4">
                                <div wire:ignore>
                                    <select name="listaServicios" id="listaServicios" class="form-control"
                                        wire:model='servicioSeleccionado' required>
                                        <option value=""> Seleccione un servicio</option>
                                        @foreach ($listaServicios as $listaServicio)
                                            <option value="{{ $listaServicio->id }}">{{ $listaServicio->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-jet-input-error for="servicio" />
                            </div>
                            <div class="col-auto">
                                @livewire('gestionar-servicios')
                            </div>
                            <div class="col form-label-group">
                                <input type="number" class="form-control" name="cantidad" id="cantidad"
                                    placeholder="Cantidad" wire:model.lazy='cantidad' required min=0>
                                <label for="cantidad"> Cantidad: </label>
                                <x-jet-input-error for="cantidad" />
                            </div>
                            <div class="col form-label-group">
                                <input type="number" class="form-control" name="costo" id="costo"
                                    placeholder="Costo" wire:model.lazy='costo' required min=0>
                                <label for="costo"> Costo: </label>
                                <x-jet-input-error for="costo" />
                            </div>
                            <div class="col form-label-group">
                                <input type="number" class="form-control" name="importe" id="importe"
                                    placeholder="Importe" disabled wire:model='importe'>
                                <label for="importe"> Importe: </label>
                            </div>
                            <div class="col">
                                <button class="btn btn-success" wire:click.prevent="agregar_item">Agregar</button>
                                <x-jet-input-error for="cliente" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr style="border-bottom: 3px solid black;">
                        <th scope="col" class="text-center">Descripcion</th>
                        <th scope="col" class="text-center">Cantidad</th>
                        <th scope="col" class="text-center">Precio</th>
                        <th scope="col" class="text-center">Importe</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($detallePedido) --}}
                    @if ($detallePedido->count())
                        @foreach ($detallePedido as $indice=>$item)
                            <tr>
                                <td scope="row" class="align-middle text-center">{{ $item['descripcion'] }}</td>
                                <td scope="row" class="align-middle text-center">{{ $item['cantidad'] }}</td>
                                <td scope="row" class="align-middle text-center">{{ $item['precio'] }}</td>
                                <td scope="row" class="align-middle text-center">{{ $item['importe'] }}</td>
                                <td scope="row" class="align-middle text-center">
                                    <button class="align-middle btn btn-danger" wire:click="eliminarItem({{ $indice }})"><i class="far fa-trash-alt"
                                            aria-hidden="true"></i></button>
                                    <button class="align-middle btn btn-warning"><i class="far fa-edit"
                                            aria-hidden="true"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td scope="row" class="text-center" colspan="100%"> Agregar un servicio </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="row justify-content-end mt-3">
                <div class="col-auto">
                    <button class="btn btn-primary" wire:click="generar_comprobante">Generar Comprobante</button>
                    <x-jet-input-error for="cliente" />
                    <x-jet-input-error for="detalle" />
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col col-md-3">
                    <h5>HISTORIAL DE RECIBO</h5>
                </div>
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
                <tbody>{{-- dd($detallePedido) --}}
                    @foreach ($hcliente->recibos->sortByDesc('femision') as $recibo)
                        <tr>
                            <td scope="row" class="text-center">REC - {{ $recibo->correlativo }}</td>
                            <td scope="row" class="text-center">{{ date('d-m-Y', strtotime($recibo->femision)) }}
                            </td>
                            <td scope="row" class="text-center">{{ $recibo->termino }}</td>
                            <td scope="row" class="text-center">Q.{{ $recibo->total }}</td>
                            <td scope="row" class="text-center"><button
                                    class="btn btn-primary">{{ $recibo->detalles->count() }}</button></td>
                            <td scope="row" class="text-center">cancelado</td>
                            <td scope="row" class="text-center">
                                <button class="btn btn-danger" wire:loading.attr="disabled" wire:target="reenviar"
                                    wire:click="reenviar('{{ $recibo->id }}')">Reenviar</button>
                                <button class="btn btn-warning" wire:click="$toggle('editar')">Editar</button>
                                <button class="btn btn-success" wire:loading.attr="disabled"
                                    wire:target="descargar_recibo"
                                    wire:click="descargar_recibo('{{ $recibo->id }}')">Descargar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.onload = function() {
            $(document).ready(function() {
                $('#listaServicios').select2();
                $('#listaServicios').on('change', function() {
                    let valor = $('#listaServicios').select2('val');
                    let texto = $('#listaServicios option:selected').text();
                    @this.set('servicioSeleccionado', texto);
                });
            })
        }
    </script>

</div>
