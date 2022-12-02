<?php

namespace App\Http\Livewire;

use App\Models\Recibo;
use Livewire\Component;

class ComprobantesSunat extends Component
{
    public $comprobantes03;
    public $b_estado;
    public $b_fecha_inicio;
    public $b_fecha_final;

    public function render()
    {
        $this->comprobantes03 = Recibo::orderBy('id', 'desc')->get();
        if (!empty($this->b_fecha_inicio) or !empty($this->b_fecha_final) or !empty($this->b_estado)){
            if(!empty($this->b_estado)){
                $this->comprobantes03 = Recibo::orderBy('id', 'desc')->where('cestado','like',"%".$this->b_estado."%")->get();
            }
            if(!empty($this->b_fecha_inicio)){
                $this->comprobantes03 = $this->comprobantes03->where('f_emision','>=',$this->b_fecha_inicio);
            }
            if(!empty($this->b_fecha_final)){
                $this->comprobantes03 = $this->comprobantes03->where('f_emision','<=',$this->b_fecha_final);
            }
        }
        else {
            $this->comprobantes03 = Recibo::where('cestado','like',"%".$this->b_estado."%")->orderBy('id', 'desc')->get();
        }
        //dd($this->comprobantes03);
        return view('livewire.comprobantes-sunat');
    }

    public function mount(){
        $this->b_fecha_inicio = now()->subDays(7)->format('Y-m-d');
    }
}
