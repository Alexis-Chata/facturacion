<div class="card-body p-inherit">
    <div class="row">
        <div class="mb-3 col-4">
            <label for="b_fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control"  wire:model="b_fecha_inicio" name="b_fecha_inicio" id="b_fecha_inicio">
        </div>
        <div class="mb-3 col-4">
            <label for="b_fecha_final" class="form-label">Fecha Final</label>
            <input type="date" class="form-control"  wire:model="b_fecha_final" name="b_fecha_final" id="b_fecha_final">
        </div>
        <div class="mb-3 col-4">
            <label for="fecha_final" class="form-label">Estado</label>
            <select wire:model="b_estado" class="form-control">
                <option value="">Todos</option>
                <option value="2">Enviado</option>
                <option value="1">No Enviado</option>
            </select>
        </div>
    </div>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Fecha</th>
                <th scope="col">Tipo</th>
                <th scope="col">Serie</th>
                <th scope="col">Correlativo</th>
                <th scope="col">RUC/DNI</th>
                <th scope="col">Razon Social</th>
                <th scope="col">Moneda</th>
                <th scope="col">Total</th>
                <th class="text-center" scope="col">Ticket</th>
                <th class="text-center" scope="col">Pdf</th>
                <th class="text-center" scope="col">XML</th>
                <th class="text-center" scope="col">CDR </th>
                <th class="text-center" scope="col">Estado</th>
                <th class="text-center" scope="col">Enviar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comprobantes03 as $boleta)
                {{-- @foreach ( $boleta->operaciones as $detalle) --}}
                <tr>
                    <td scope="row" class="text-center">
                        +
                    </td>
                    <td>{{ $boleta->f_emision }}</td>
                    <td>{{ ucwords(strtolower($boleta->tipo)) }}</td>
                    <td>
                        {{ $boleta->serie }}
                    </td>
                    <td>
                        {{ $boleta->correlativo }}
                    </td>
                    <td>{{ $boleta->cliente->dni }}</td>
                    <td>{{ $boleta->cliente->name." ".$boleta->cliente->ap_paterno }}</td>
                    <td>{{ isset($boleta->moneda) ? $boleta->moneda->descripcion : 'PEN' }}</td>
                    <td>{{ $boleta->total }}</td>
                    {{-- Columna Ticket --}}
                    @if ( $boleta->tipo == "NOTA DE CREDITO ELECTRONICA" )
                        <td class="text-center">-</td>
                    @else
                        <td class="text-center"><a href="{{ Route('admin.comprobantes.ticket',$boleta) }}" target="_blank" title="Ticket"><i class="fas fa-print"></i></a></td>
                    @endif
                    {{-- Columna Pdf --}}
                    @if (file_exists(storage_path().'/app/public/cpe/'.$boleta->emisor->ruc.'-'.$boleta->tipo_comprobante_id.'-'.$boleta->serie.'-'.$boleta->correlativo.'.pdf'))
                        <td class="text-center"><a href="{{ asset('storage/cpe/'.$boleta->emisor->ruc.'-'.$boleta->tipo_comprobante_id.'-'.$boleta->serie.'-'.$boleta->correlativo.'.pdf')}}" target="_blank" title="Pdf"><i class="fas fa-file-pdf"></i></a></td>
                    @else
                        <td class="text-center"><a href="{{ Route('admin.comprobantes.pdf',$boleta) }}" target="_blank" title="Pdf"><i class="fas fa-file-pdf"></i></a></td>
                    @endif
                    {{-- Columna XML --}}
                    @if (file_exists(storage_path().'/app/public/cpe/'.$boleta->emisor->ruc.'-'.$boleta->tipo_comprobante_id.'-'.$boleta->serie.'-'.$boleta->correlativo.'.xml'))
                        <td class="text-center"><a href="{{ asset('storage/cpe/'.$boleta->emisor->ruc.'-'.$boleta->tipo_comprobante_id.'-'.$boleta->serie.'-'.$boleta->correlativo.'.xml')}}" target="_blank" title="xml"><i class="fas fa-file-code"></i></a></td>
                    @else
                        <td class="text-center"><a href="{{ Route('admin.comprobantes.xml',$boleta) }}" target="_blank" title="xml"><i class="fas fa-file-code"></i></a></td>
                    @endif
                    {{-- Columna CDR --}}
                    @if (file_exists(storage_path().'/app/public/cpe/R-'.$boleta->emisor->ruc.'-'.$boleta->tipo_comprobante_id.'-'.$boleta->serie.'-'.$boleta->correlativo.'.xml'))
                        <td class="text-center"><a href="{{ asset('storage/cpe/R-'.$boleta->emisor->ruc.'-'.$boleta->tipo_comprobante_id.'-'.$boleta->serie.'-'.$boleta->correlativo.'.xml')}}" target="_blank" title="CDR (constancia de recepción)"><i class="fas fa-file-code"></i></a></td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                    {{-- Columna Estado --}}
                    @if ($boleta->cestado == 2)
                        <td class="text-center"><i class="fas fa-check" title="Cpe aceptado por Sunat"></i></td>
                    @elseif(strlen($boleta->cestado) >6)
                        <td class="text-center">{{ $boleta->cestado }}</td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                    {{-- Columna Enviar --}}
                    @if ( $boleta->tipo == "NOTA DE CREDITO ELECTRONICA" )
                        @if ($boleta->estado_comprobante == 'ok')
                            <td class="text-center"><a target="_blank" href="https://e-consulta.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm" title="Consulta de Validez del Comprobante de Pago Electrónico"><i class='fas fa-check-double'></i></a></td>
                        @else
                            <td class="text-center"><a href="{{ Route('admin.comprobantes.notacredito',$boleta) }}"><i class='fas fa-sign-out-alt'></i></a></td>
                        @endif
                    @else
                        @if ($boleta->estado_comprobante == 'ok')
                            <td class="text-center"><a target="_blank" href="https://e-consulta.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm" title="Consulta de Validez del Comprobante de Pago Electrónico"><i class='fas fa-check-double'></i></a></td>
                        @else
                            <td class="text-center"><a href="{{ Route('admin.comprobantes.show',$boleta) }}"><i class='fas fa-sign-out-alt'></i></a></td>
                        @endif
                    @endif
                </tr>
                {{-- @endforeach --}}
            @endforeach
        </tbody>
    </table>
</div>
