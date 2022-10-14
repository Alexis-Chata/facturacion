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
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-4"> <strong>Total : Q. {{$total}}</strong></div>
        </div>
    </div>
</div>
