<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Recibo;
use App\Models\User;
use Livewire\Component;

class HistorialRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $hcliente;

    public function  mount($cliente_id)
    {
        $this->hcliente = Cliente::find($cliente_id);
        $this->finicio = $this->hcliente->recibos->first()->femision;
        $this->ffinal = $this->hcliente->recibos->last()->femision;
    }

    public function render()
    {
        return view('livewire.historial-recibos');
    }

    public function descargar_informe()
    {

    }
    public function descargar_recibo()
    {

    }
    public function editar()
    {
    }
    public function reenviar()
    {

    }
}
