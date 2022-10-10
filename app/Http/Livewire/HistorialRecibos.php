<?php

namespace App\Http\Livewire;

use App\Mail\TestMail;
use App\Models\Cliente;
use App\Models\Detalle;
use App\Models\Recibo;
use App\Models\Servicio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class HistorialRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $hcliente;
    public $listaServicios, $servicioSeleccionado;
    public $cantidad, $costo, $importe, $detallePedido, $total;
    public $editar;

    public function  mount($cliente_id=null){

        $this->resetRecibo();
        $this->resetErrorBag();
        $this->listaServicios = Servicio::all();
        $this->finicio = null;
        $this->ffinal = null;
        $this->hcliente = new Cliente();
        $this->hcliente->name = ' ----- Seleccionar Cliente ----- ';
        $this->hcliente->direccion = ' ----- Seleccionar Cliente ----- ';
        if ($cliente_id) {
            $this->hcliente = Cliente::find($cliente_id);
            if ($this->hcliente->recibos != "[]") {
                $this->finicio = $this->hcliente->recibos->first()->femision;
                $this->ffinal = $this->hcliente->recibos->last()->femision;
            }
        }
    }

    public function resetNewItem(){

        $this->cantidad = 1;
        $this->costo = 0;
        $this->updatedCantidad();
    }

    public function resetRecibo(){

        $this->detallePedido = collect();
        $this->total = 0;
        $this->editar = false;
        $this->resetNewItem();
    }

    public function updatedCantidad(){
        $this->cantidad = $this->cantidad ? $this->cantidad : 1;
        $this->costo = $this->costo ? $this->costo : 0;
        $this->importe = $this->cantidad * $this->costo;
    }

    public function updatedcosto(){

        $this->updatedCantidad();
    }

    protected $listeners = ['clienteIdToRecibo'];

    public function clienteIdToRecibo($clienteid){

        $this->mount($clienteid);
        $this->emit('cerrar_modal');
    }

    public function render(){

        return view('livewire.historial-recibos');
    }

    public function eliminarItem($indice){

        $this->total = $this->total-$this->detallePedido[$indice]['importe'];
        unset($this->detallePedido[$indice]);
    }

    public function agregar_item(){

        if(!$this->hcliente->id){
            $this->hcliente->name = ' ----- Seleccionar Cliente ----- ';
            $this->hcliente->direccion = ' ----- Seleccionar Cliente ----- ';
            $this->emit('abrir_modal');
        }
        Validator::make(
            ['cliente' => $this->hcliente->id],
            ['cliente' => 'required'],
            ['required' => 'Seleccionar Cliente'],
        )->validate();

        Validator::make(
            ['servicio' => $this->servicioSeleccionado ? $this->servicioSeleccionado: null, 'cantidad' => $this->cantidad, 'costo' => $this->costo],
            ['servicio' => 'required', 'cantidad' => 'required|numeric|min:1', 'costo' => 'required|numeric|min:1'],
            ['required' => 'requerido', 'min' => 'minimo 1'],
        )->validate();
        $newItem = new Detalle();
        $newItem->descripcion = $this->servicioSeleccionado;
        $newItem->cantidad = $this->cantidad;
        $newItem->precio = $this->costo;
        $newItem->importe = $this->importe;
        $this->detallePedido->push($newItem->toArray());
        $this->total = $this->total+$this->importe;
        $this->resetNewItem();
    }

    public function generar_comprobante(){
        if(!$this->hcliente->id){
            $this->hcliente->name = ' ----- Seleccionar Cliente ----- ';
            $this->hcliente->direccion = ' ----- Seleccionar Cliente ----- ';
            $this->emit('abrir_modal');
        }
        Validator::make(
            ['cliente' => $this->hcliente->id],
            ['cliente' => 'required'],
            ['required' => 'Seleccionar Cliente'],
        )->validate();

        Validator::make(
            ['detalle' => $this->detallePedido],
            ['detalle' => 'required'],
            ['required' => 'Agregar Servicios'],
        )->validate();
        $recibo = new Recibo();
        $recibo->cliente_id = $this->hcliente->id;
        $recibo->femision = now();
        $recibo->correlativo = 21;
        $recibo->termino = 'Deposito';
        $recibo->total = $this->total;
        $recibo->cajero_id = 1;
        $recibo->save();

        foreach($this->detallePedido as $item) {
            $addItem = new Detalle($item);
            $addItem->recibo_id = $recibo->id;
            $addItem->save();
        };
        $this->mount($this->hcliente->id);
    }

    public function descargar_informe(){

    }

    public function descargar_recibo(Recibo $recibo){

        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo'));
        $pdfContent = $consultapdf->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "recibo.pdf"
        );
    }

    public function editar(){

    }

    public function reenviar(Recibo $recibo){

        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo'));
        Mail::send('recibos.comprobante_pdf', compact('recibo'), function ($mail) use ($consultapdf, $recibo) {
            $email = $recibo->cliente->email;
            $mail->to([$email]);
            $mail->subject("Espacio Arquitectura");
            $mail->attachData($consultapdf->output(), 'recibo.pdf');
        });

        /* Mail::to($recibo->cliente->email)->send(new TestMail($recibo),function ($mail) use ($consultapdf){
            $mail->attachData($consultapdf->output(),'recibo.pdf');
        });*/
    }
}
