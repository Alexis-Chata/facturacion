<div class="container">
    <div class="card card-secondary">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col col-md-3">
                    <h5>HISTORIAL DE RECIBO</h5>
                </div>
                <div class="col col-md-3"><select class="form-control" wire:model="bdeposito">
                <option value="%%">Todos</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Deposito">Deposito</option>
                </select>
                </div>
                <div class="col col-md-3"><input type="date" class="form-control" wire:model="finicio"></div>
                <div class="col col-md-3"><input type="date" class="form-control" wire:model="ffinal"></div>
            </div>
        </div>
        <div class="card-body p-inherit table-responsive">
            <div class="my-4">
                <label for="buscar_cliente">Buscar Cliente :</label>
                <input type="text" class="form-control" id="buscar_cliente"
                    wire:model='bcliente'>
            </div>
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">Apellidos y Nombres</th>
                        <th scope="col" class="text-center">Identificación</th>
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
                        @php
                            $total = 0;
                        @endphp
                    @foreach ($recibos->where('femision','>=',$finicio)->where('femision','<=',$ffinal)->sortByDesc('correlativo') as $recibo)
                        @php
                            $total = $total + $recibo->total;
                        @endphp
                        <tr>
                            <td scope="row">{{$recibo->cliente->paterno." ".$recibo->cliente->materno." ".$recibo->cliente->name}}</td>
                            <td scope="row" class="text-center">{{$recibo->cliente->identificacion}}</td>
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
            <div class="row">
                <div class="my-4 col-6"> <strong>Total : Q. {{$total}}</strong></div>
                <div class="text-right my-4 col-6"><button class="btn btn-success"  wire:click="descargar_recibos()"><i class="fas fa-download"></i> Descargar Reporte</button></div>
            </div>
        </div>
    </div>
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
                    Livewire.emitTo('reporte-recibos','eliminar_recibo',recibo_id);
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
    @endpush
</div>
