<?php

namespace App\Http\Livewire;

use App\Models\Servicio;
use Livewire\Component;

class GestionarServicios extends Component
{
    public Servicio $servicio;
    public $modal_titulo;
    public $bservicio;
    public $gservicios;

    protected $rules = [
        'servicio.name' => 'required|string',

    ];

    protected $validationAttributes = [
        'servicio.name' => 'Servicio',
    ];

    #buscar listado de usuarios
    public function updatedBservicio()
    {
        if($this->gservicios != ""){
        $this->gservicios = Servicio::Where(function($query) {
                        $query->where('name','like','%'.$this->bservicio.'%');
                    })->get();
        }
        else {
            $this->gservicios = Servicio::all();
        }
    }

    #obtener datos
    public function obtener_datos($servicio)
    {
        $this->servicio = Servicio::find($servicio);
        $this->modal_titulo = "Modificar";
        $this->emit('notificar_seleccion_servicio');
    }
    #modal
    public function modal_servicio($accion = 'Crear'){
        $this->updatedBservicio();
        if($accion == 'Crear')
        {
            $this->servicio = new Servicio();
            $this->modal_titulo = $accion;
        }
    }

    public function eliminar(Servicio $servicio)
    {
            $servicio->delete();
            $this->updatedBservicio();
    }

    public function save_servicio(){
        $this->validate();
        $this->servicio->save();
        $this->modal_titulo = "Crear";
        $this->servicio = new Servicio();
        $this->updatedBservicio();
        $this->emitTo('historial-recibos','actualizar_servicios');
        $this->emit('notificar_listado_servicio');
    }

    public function render()
    {
        return view('livewire.gestionar-servicios');
    }
}
