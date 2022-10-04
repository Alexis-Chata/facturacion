<div class="col col-md-6 container m-4">
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </div>
</div>
