<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>{{$cliente->paterno." ".$cliente->materno." ".$cliente->name}}</th>
        </tr>
        <tr>
            <th scope="col" class="text-center">Recibo</th>
            <th scope="col" class="text-center">F. Emisión</th>
            <th scope="col" class="text-center">Termino</th>
            <th scope="col" class="text-center">Total</th>
            <th scope="col" class="text-center">Detalles</th>
            <th scope="col" class="text-center">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cliente->recibos->sortByDesc('correlativo')->sortByDesc('femision') as $recibo)
            <tr>
                <td>REC - {{ $recibo->correlativo }}</td>
                <td>{{ date('d-m-Y',strtotime($recibo->femision)) }}</td>
                <td>{{ $recibo->termino}}</td>
                <td>S/.{{ $recibo->total}}</td>
                <td>{{ $recibo->detalles->count()}}</td>
                <td>Cancelado</td>
            </tr>
        @endforeach
    </tbody>
</table>
