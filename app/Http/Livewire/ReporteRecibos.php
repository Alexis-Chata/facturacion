<?php

namespace App\Http\Livewire;

use App\Models\Recibo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporteRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $bcliente;
    public $bdeposito = "%%";
    public $sdeposito = "like";

    public function  mount(){
        $recibos = Recibo::all();
        if ($recibos != "[]") {
            $this->finicio = $recibos->first()->femision;
            $this->ffinal = $recibos->last()->femision;
        }
    }
    public function render()
    {
        if($this->bdeposito == '%%'){
            $this->bdeposito = '%%';
            $this->sdeposito = 'like';
        }
        else{$this->sdeposito = '=';}

        $recibos = Recibo::where('termino',$this->sdeposito,$this->bdeposito)->whereExists(function ($query)  {
            $query->select()
                  ->from('clientes')
                  ->whereColumn('clientes.id','recibos.cliente_id')
                  ->Where(function($query) {
                    $query->where('identificacion','like','%'.$this->bcliente.'%')
                            ->orWhere(DB::raw("CONCAT(`name`,' ',`paterno`,' ',`materno`)"), 'like', '%' . $this->bcliente.'%');
                });
        })->get();
        return view('livewire.reporte-recibos',compact('recibos'));
    }
}
