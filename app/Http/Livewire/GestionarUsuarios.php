<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Tcliente;
use Facade\FlareClient\Http\Client;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GestionarUsuarios extends Component
{
    public Cliente $cliente;
    public $modal_titulo;
    public $bcliente;
    public $gclientes;
    public $stcliente;

    protected $rules = [
        'stcliente' => 'required',
        'cliente.name' => 'required|string',
        'cliente.paterno' => 'required|string',
        'cliente.materno' => 'required|string',
        'cliente.identificacion' => 'required|string',
        'cliente.email' => 'required|email',
        'cliente.direccion' => 'required|string',
        'cliente.celular' => 'required',
    ];
    protected $rules2 = [
        'stcliente' => 'required',
        'cliente.name' => 'required|string',
        'cliente.identificacion' => 'required|string',
        'cliente.email' => 'required|email',
        'cliente.direccion' => 'required|string',
        'cliente.celular' => 'required',
    ];

    protected $validationAttributes = [
        'stcliente' => 'Tipo de Cliente',
        'cliente.name' => 'Nombre',
        'cliente.paterno' => 'Apellido Paterno',
        'cliente.matenro' => 'Apellido Materno',
        'cliente.identificacion' => 'Identificación',
        'cliente.email' => 'Email',
        'cliente.direccion' => 'Dirección',
        'cliente.celular' => 'Celular',
    ];

    #buscar listado de estudiante
    public function updatedBcliente()
    {
        $this->gclientes = Cliente::Where(function($query) {
                        $query->where('identificacion','like','%'.$this->bcliente.'%')
                                ->orWhere(DB::raw("CONCAT(`name`,' ',`paterno`,' ',`materno`)"), 'like', '%' . $this->bcliente.'%');
                    })->get();
    }
    #obtener datos
    public function obtener_datos($usuario){
        $this->cliente = Cliente::find($usuario);
        $this->stcliente = $this->cliente->tcliente_id;
        $this->modal_titulo = "Modificar";
        $this->emit('notificar_seleccion');
    }
    #modal
    public function modal($accion = 'Crear'){
        if($accion == 'Crear')
        {
            $this->cliente = new Cliente();
            $this->modal_titulo = $accion;
        }
        else
        {

        }
    }
    #eliminar
    public function eliminar(Cliente $cliente){
        if($cliente->recibos->count() == 0){
            $cliente->delete();
            $this->updatedBcliente();
        }
    }

    public function save($accion){
        if($accion == "Crear"){
            if ($this->stcliente == 1) {
            $this->validate();
            }
            elseif($this->stcliente == 2){
            $this->validate($this->rules2);
            }
        }
        else {

        }
        $this->cliente->tcliente_id = $this->stcliente;
        $this->cliente->save();
        $this->modal_titulo = "Crear";
        $this->cliente = new Cliente();
        $this->emit('notificar_listado');
        $this->reset('stcliente');
    }

    protected $listeners = ['modal'];

    public function render()
    {
        $tclientes = Tcliente::all();
        return view('livewire.gestionar-usuarios',compact('tclientes'));
    }
}
