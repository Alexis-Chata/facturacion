<?php

namespace App\Http\Livewire;

use App\Clases\ReciboClass;
use App\Exports\TrecibosExport;
use App\Models\Cliente;
use App\Models\Recibo;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ReporteRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $bcliente;
    public $recibos;
    public $bdeposito = "%%";
    public $sdeposito = "like";
    protected $listeners = ['eliminar_recibo'];


    public function eliminar_recibo(Recibo $recibo){
        $scliente = $recibo->cliente->id;
        $recibo->delete();
        $this->hcliente = Cliente::find($scliente);
        $this->emit('notificar_eliminar',"Elimino el Usuario correctamente");
    }

    public function reenviar(Recibo $recibo){
        $r_recibo = new ReciboClass();
        $r_recibo->reenviar($recibo);
    }

    public function generar_reciboPdf(Recibo $recibo)
    {
        $r_recibo = new ReciboClass();
        $r_recibo->generar_reciboPdf($recibo);
    }

    public function  mount()
    {
        $recibos = Recibo::all();
        if ($recibos != "[]") {
            $this->finicio = $recibos->first()->femision;
            $this->ffinal = $recibos->last()->femision;
        }
    }

    public function descargar_recibo(Recibo $recibo){
        $r_recibo = new ReciboClass();
        $contenido = $r_recibo->descargar_recibo($recibo);
        return $contenido;
    }

    public function descargar_recibos()
    {
        $r_recibo = new ReciboClass();
        return $r_recibo->descargar_recibos($this->recibos,$this->finicio,$this->ffinal);
    }

    public function render()
    {
        if($this->bdeposito == '%%'){
            $this->bdeposito = '%%';
            $this->sdeposito = 'like';
        }
        else{$this->sdeposito = '=';}

        $this->recibos = Recibo::where('termino',$this->sdeposito,$this->bdeposito)->whereExists(function ($query)  {
            $query->select()
                  ->from('clientes')
                  ->whereColumn('clientes.id','recibos.cliente_id')
                  ->Where(function($query) {
                    $query->where('identificacion','like','%'.$this->bcliente.'%')
                            ->orWhere(DB::raw("CONCAT(`name`,' ',`paterno`,' ',`materno`)"), 'like', '%' . $this->bcliente.'%');
                });
        })->get();
        return view('livewire.reporte-recibos');
    }
}
