<div class="col container mt-4">
    <div class="card card-secondary mb-4">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col col-md-3">
                    <h5 class="m-0" id="card-header-recibo">{{ $card_header_recibo }}</h5>
                </div>
            </div>
        </div>

        <div class="card-body p-inherit table-responsive">

            <div class="row">
                <div class="col">
                    <h3 class="mb-3">Datos del cliente</h3><hr>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <p><strong>Cliente : </strong>{{ $hcliente->name . ' ' . $hcliente->paterno . ' ' . $hcliente->materno }}</p>
                    <p><strong>Direccion del cliente : </strong>{{ ' ' . $hcliente->direccion }}</p>
                </div>
                <div class="col">
                    <p><strong>Fecha :</strong> <input type="date" class="form form-control" wire:model="f_emision"></p>
                        <div class="form-group row p-0">
                            <label for="inputCodigo" class="col-auto"><strong>Forma de pago :</strong></label>
                            @foreach ( $formaPago as $f_Pago )
                                <div class="form-check col">
                                    <input class="form-check-input" type="radio" wire:model.defer="forma_pago" name="forma_pago" id="forma_pago{{$f_Pago->id}}" value="{{$f_Pago->name}}">
                                    <label class="form-check-label" for="forma_pago{{$f_Pago->id}}" role=button>{{$f_Pago->name}}</label>
                            </div>
                            @endforeach
                            <x-jet-input-error for="forma_pago"/>
                        </div>
                </div>
            </div>

            <div class="card card-secondary m-3 ">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col col-md-3">
                            <h5 id="card-header-servicio">{{ $card_header_servicio }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-inherit table-responsive">
                    <form>
                        <div class="row align-items-center g-2">
                            <div class="col-sm-5 col-md">
                                <div wire:self.defer>
                                    <select name="listaServicios" id="listaServicios" class="form-control"
                                        wire:model='servicioSeleccionado' required>
                                        <option value=""> Seleccione un servicio</option>
                                        @foreach ($listaServicios as $listaServicio)
                                            <option value="{{ $listaServicio->name }}">{{ $listaServicio->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-jet-input-error for="servicio" />
                            </div>
                            <div class="col-sm-auto">
                                @livewire('gestionar-servicios')
                            </div>
                            <div class="col-sm form-label-group form-floating">
                                <input type="number" class="form-control" name="cantidad" id="cantidad"
                                    placeholder="Cantidad" wire:model.lazy='cantidad' required min=0>
                                <label for="cantidad" style="padding: 1rem 1.5rem;"> Cantidad: </label>
                                <x-jet-input-error for="cantidad" />
                            </div>
                            <div class="col-sm-3 col-md form-label-group form-floating">
                                <input type="number" class="form-control" name="costo" id="costo"
                                    placeholder="Costo" wire:model.lazy='costo' required min=0>
                                <label for="costo" style="padding: 1rem 1.5rem;"> Costo: </label>
                                <x-jet-input-error for="costo" />
                            </div>
                            <div class="col-sm-3 col-md form-label-group form-floating">
                                <input type="number" class="form-control" name="importe" id="importe"
                                    placeholder="Importe" disabled wire:model='importe'>
                                <label for="importe" style="padding: 1rem 1.5rem;"> Importe: </label>
                            </div>
                            <div class="col-sm">
                                <button class="btn btn-success" wire:click.prevent="agregar_item({{ $editar_detalle_id }})" wire:loading.attr="disabled" id="card-body-btn-servicio">{{ $card_body_btn_servicio }}</button>
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
                    @if ($detallePedido->count())
                        @foreach ($detallePedido as $indice=>$item)
                            <tr>
                                <td scope="row" class="align-middle text-center">{{ $item['descripcion'] }}</td>
                                <td scope="row" class="align-middle text-center">{{ $item['cantidad'] }}</td>
                                <td scope="row" class="align-middle text-center">{{ 'Q. '.number_format($item['precio'], 2) }}</td>
                                <td scope="row" class="align-middle text-center">{{ 'Q. '.number_format($item['importe'], 2) }}</td>
                                <td scope="row" class="align-middle text-center">
                                    <button class="align-middle btn btn-danger" wire:click="eliminarItem({{ $indice }})" wire:loading.attr="disabled"><i class="far fa-trash-alt"
                                            aria-hidden="true"></i></button>
                                    <button class="align-middle btn btn-warning" wire:click="editarItem({{ $indice }})" wire:loading.attr="disabled"><i class="far fa-edit"
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
                    <span><strong>Total: </strong> Q. {{ number_format($total, 2) }}</span>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" wire:click="generar_comprobante({{ $editar_comprobante_id }})" wire:loading.attr="disabled">{{ $card_body_btn_generar_comprobante }}</button>
                    <x-jet-input-error for="cliente" />
                    <x-jet-input-error for="detalle" />
                    <x-jet-input-error for="editandoItem" />
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-12 col-md-3 text-center">
                    <h5>HISTORIAL DE RECIBO</h5>
                </div>
                <div class="col-12 col-md-3 text-center my-2 my-md-0"><button class="btn btn-success" wire:click="descargar_historial()"><i class="fas fa-download"></i> Descargar Informe</button></div>
                <div class="col-12 col-md-3 text-center my-2 my-md-0"><input type="date" class="form-control" wire:model="finicio"></div>
                <div class="col-12 col-md-3 text-center my-2 my-md-0"><input type="date" class="form-control" wire:model="ffinal"></div>
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
                    @foreach ($hcliente->recibos->where('femision','>=',$finicio)->where('femision','<=',$ffinal)->sortByDesc('correlativo')->sortByDesc('femision') as $recibo)
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
                                    wire:click="reenviar('{{ $recibo->id }}')"><i class="fas fa-envelope"></i></button>
                                <button class="btn btn-secondary" wire:click="editarComprobante('{{ $recibo->id }}')" wire:loading.attr="disabled"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-success" wire:loading.attr="disabled"
                                    wire:target="descargar_recibo"
                                    wire:click="descargar_recibo('{{ $recibo->id }}')"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-danger" id="eliminar-recibo-{{$recibo->id}}" wire:loading.attr="disabled" wire:target="eliminar"
                                        wire:click="$emit('eliminar',{{$recibo->id}})"><i class="fas fa-trash"></i></button>
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

@push('css')
<style>
    span.select2.select2-container.select2-container--default{
        width: 100% !important;
    }
</style>
@endpush
@push('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Livewire.on('eliminar', recibo_id =>{
                    Swal.fire({
            title: 'Estas Seguro',
            text: "Una vez eliminado el Recibo no se podra recuperar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, !Eliminar!'
            }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emitTo('historial-recibos','eliminar_recibo',recibo_id);
            }
            })
    })
</script>
<script>
        window.livewire.on('notificar_eliminar', accion => {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: accion,
                showConfirmButton: false,
                timer: 1500
            })
        });
</script>
<script>
        window.livewire.on('actualizar_lista', accion =>  {
                    $('#listaServicios').select2();
                    $('#listaServicios').on('change', function() {
                        let valor = $('#listaServicios').select2('val');
                        let texto = $('#listaServicios option:selected').text();
                        @this.set('servicioSeleccionado', texto);
                    });
        });
</script>
@endpush
</div>
