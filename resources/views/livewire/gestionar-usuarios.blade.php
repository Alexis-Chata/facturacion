<div>
    <button type="button" class="btn btn-success" id="ventana_usuario" data-bs-toggle="modal" data-bs-target="#modal_crear_actualizar_cliente" wire:click="modal('Crear')">
        <i class="fas fa-plus-circle"></i> Gestionar Usuarios
    </button>
    <!-- Modal crear periodo-->
    <div wire:ignore.self class="modal fade" id="modal_crear_actualizar_cliente" tabindex="-3" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Gestionar Usuarios</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                  <a wire:ignore.self class="nav-link active" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="true" id="1_pestana">{{$modal_titulo}} Cliente </a>
                                </li>
                                <li class="nav-item">
                                    <a  wire:ignore.self class="nav-link" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false" id="1_listado">Lista de Clientes</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="tab-content" >
                                <div wire:ignore.self class="tab-pane fade active show" id="tasks" role="tabpanel" data-filter-list="card-list-body">
                                  <div class="row content-list-head">
                                    <div class="col-12 p-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="stcliente" class="fw-bold">Tipo de Cliente : <span
                                                    class="text-danger">(*)</span></label>
                                                <select id="stcliente" wire:model="stcliente" class="form-select">
                                                    <option value="">Elegir</option>
                                                    @foreach ($tclientes as $tcliente)
                                                    <option value="{{$tcliente->id}}">{{$tcliente->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('stcliente')
                                                    <div class="p-1"> {{ $message }}</div>
                                                @enderror
                                            </div>
                                            @if ($stcliente != "")
                                                <div class="col-12">
                                                    <label for="cliente_name" class="fw-bold">Nombre : <span
                                                        class="text-danger">(*)</span></label>
                                                    <input type="text" id="cliente_name" class="form-control" wire:model="cliente.name">
                                                    @error('cliente.name')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                @if ($stcliente == 1)
                                                <div class="col-12">
                                                        <label for="cliente_paterno" class="fw-bold">Ape Paterno : <span
                                                                class="text-danger">(*)</span></label>
                                                        <input type="text" id="cliente_paterno" class="form-control" wire:model="cliente.paterno">
                                                        @error('cliente.paterno')
                                                            <div class="p-1"> {{ $message }}</div>
                                                        @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="cliente_materno" class="fw-bold">Ape Materno : <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" id="cliente_materno" class="form-control" wire:model="cliente.materno">
                                                    @error('cliente.materno')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                @endif
                                                <div class="col-12">
                                                    <label for="cliente_identificacion" class="fw-bold">Identificación : <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" id="cliente_identificacion" class="form-control" wire:model="cliente.identificacion">
                                                    @error('cliente.identificacion')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="cliente_email" class="fw-bold">Email : <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" id="cliente_email" class="form-control" wire:model="cliente.email">
                                                    @error('cliente.email')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="cliente_direccion" class="fw-bold">Dirección : <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" id="cliente_direccion" class="form-control" wire:model="cliente.direccion">
                                                    @error('cliente.direccion')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12">
                                                    <label for="cliente_celular" class="fw-bold">Celular : <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="text" id="cliente_celular" class="form-control" wire:model="cliente.celular">
                                                    @error('cliente.celular')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div wire:ignore.self class="tab-pane fade" id="files" role="tabpanel" data-filter-list="dropzone-previews">
                                    <div class="content-list">
                                        <div class="row mt-2">
                                            <div class="container mb-4">
                                                <div class="col-12">
                                                    <label for="buscar_cliente">Buscar Cliente :</label>
                                                    <input type="text" class="form-control" id="buscar_cliente" wire:model='bcliente'>
                                                </div>
                                            </div>
                                          </div>
                                        @if ($gclientes != null)
                                            @if ($gclientes->count() > 0)
                                            <div class="container">
                                                <table class="table">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th>Nombres y Apellidos</th>
                                                            <th>Identificación</th>
                                                            <th>Recibos</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-success">
                                                        @foreach ($gclientes as $gcliente)
                                                        <tr>
                                                            <td>{{$gcliente->name." ".$gcliente->paterno." ".$gcliente->materno}}</td>
                                                            <td>{{$gcliente->identificacion}}</td>
                                                            <td>{{$gcliente->recibos->count()}}</td>
                                                            <td>
                                                                <button class="btn btn-success" id="select-{{$gcliente->id}}" wire:click="obtener_datos('{{$gcliente->id}}')">Seleccionar</button>
                                                                <button class="btn btn-warning" id="generar-{{$gcliente->id}}" wire:click="">Generar</button>
                                                                <button class="btn btn-danger" id="eliminar-{{$gcliente->id}}" wire:click="eliminar('{{$gcliente->id}}')" wire:target="eliminar" wire:loading.attr="disabled">Eliminar</button>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <div class="row">no hay resultados</div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            @if ($stcliente != "")
            <button type="button" class="btn btn-primary" wire:target="save" wire:click="save('{{$modal_titulo}}')"
                wire:loading.attr="disabled">{{ $modal_titulo }} Cliente
            </button>
            @endif
        </div>
        </div>
        </div>
    </div>
</div>
