<table>
    <thead>
        <tr>
            <th>Apellidos y Nombres</th>
            <th>Identificación</th>
            <th>Recibo</th>
            <th>F. Emisión</th>
            <th>Termino</th>
            <th>Total</th>
            <th>Detalles</th>
            <th>Estado</th>
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
                <td>{{$recibo->cliente->paterno." ".$recibo->cliente->materno." ".$recibo->cliente->name}}</td>
                <td>{{$recibo->cliente->identificacion}}</td>
                <td>REC - {{ $recibo->correlativo }}</td>
                <td>{{ date('d-m-Y', strtotime($recibo->femision)) }}
                </td>
                <td>{{ $recibo->termino }}</td>
                <td>Q.{{ $recibo->total }}</td>
                <td><button>{{ $recibo->detalles->count()}}</button></td>
                <td>cancelado</td>
            </tr>
        @endforeach
            <tr>
                <td>Total</td>
                <td>Q.{{$total}}</td>
            </tr>
    </tbody>
</table>
