<div id="servicio_general">
    <button type="button" id="ventana_servicio" class="btn btn-primary col" data-bs-toggle="modal" data-bs-target="#modal_crear_actualizar_servicio" wire:click="modal_servicio('Crear')">
        <i class="fas fa-plus-circle"></i>
    </button>
 <!-- Modal crear periodo-->
 <div wire:ignore.self class="modal fade" id="modal_crear_actualizar_servicio" tabindex="-2" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gestionar Servicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-fill" role="tablist" id="listado-abc">
                            <li class="nav-item">
                                <a wire:ignore.self class="nav-link active" data-toggle="tab" href="#tasks2" role="tab" aria-controls="tasks2" aria-selected="true" id="1_pestana_s">{{$modal_titulo}} Servicio </a>
                            </li>
                            <li class="nav-item">
                                <a  wire:ignore.self class="nav-link" data-toggle="tab" href="#files2" role="tab" aria-controls="files2" aria-selected="false" id="1_listado_s">Lista de Servicio</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="tab-content" >
                            <div wire:ignore.self class="tab-pane fade active show" id="tasks2" role="tabpanel" data-filter-list="card-list-body">
                                <div class="row content-list-head">
                                    <div class="col-12 p-4">
                                        <div class="row">
                                                <div class="col-12">
                                                    <label for="servicio_name" class="fw-bold">Nombre : <span
                                                        class="text-danger">(*)</span></label>
                                                    <input type="text" id="servicio_name" class="form-control" wire:model="servicio.name">
                                                    @error('servicio.name')
                                                        <div class="p-1"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade" id="files2" role="tabpanel" data-filter-list="dropzone-previews">
                                <div class="content-list">
                                    <div class="row mt-2">
                                        <div class="container mb-4">
                                        <div class="col-12">
                                            <label for="buscar_cliente">Buscar Servicio :</label>
                                        <input type="text" class="form-control" id="buscar_cliente" wire:model='bservicio'>
                                        </div>
                                        </div>
                                    </div>
                                    @if ($gservicios != null)
                                        @if ($gservicios->count() > 0)
                                        <div class="container table-responsive">
                                            <table class="table">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Nombres</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-success">
                                                    @foreach ($gservicios->sortByDesc('id') as $gservicio)
                                                    <tr>
                                                        <td>{{$gservicio->name}}</td>
                                                        <td>
                                                            <button class="btn btn-success" id="select-{{$gservicio->id}}" wire:click="obtener_datos('{{$gservicio->id}}')">Seleccionar</button>
                                                            <button class="btn btn-danger" id="eliminar-{{$gservicio->id}}" wire:click="eliminar('{{$gservicio->id}}')" wire:target="eliminar" wire:loading.attr="disabled">Eliminar</button>
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
                <button type="button" class="btn btn-primary" wire:target="save" wire:click="save_servicio('{{$modal_titulo}}')"
                    wire:loading.attr="disabled">{{ $modal_titulo }} Servicio
                </button>
            </div>
        </div>
    </div>
</div>
</div>
