<?php

namespace App\Http\Livewire;

use App\Mail\TestMail;
use App\Models\Cliente;
use App\Models\Detalle;
use App\Models\FormaPago;
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
    public $forma_pago, $editandoItem, $card_header_servicio, $card_body_btn_servicio;

    public function  mount($cliente_id=null){

        $this->resetRecibo();
        $this->resetErrorBag();
        $this->listaServicios = Servicio::all();
        $this->forma_pago = 'Efectivo';
        $this->card_header_servicio = 'Servicios';
        $this->card_body_btn_servicio = 'Agregar';
        $this->finicio = null;
        $this->ffinal = null;
        $this->hcliente = new Cliente();
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
        $this->editandoItem = null;
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

    /**
     * Recibe id del cliente para cargar sus datos y generar comprobante
     *
     * @param  $clienteid
     * @return void
     */
    public function clienteIdToRecibo($clienteid){

        $this->mount($clienteid);
        $this->emit('cerrar_modal');
    }

    public function render(){
        if(!$this->hcliente->id){
            $this->hcliente->name = ' ----- Seleccionar Cliente ----- ';
            $this->hcliente->direccion = ' ----- Seleccionar Cliente ----- ';
        }
        $formaPago = FormaPago::all();
        return view('livewire.historial-recibos', compact('formaPago'));
    }

    public function eliminarItem($indice){

        $this->total = $this->total-$this->detallePedido[$indice]['importe'];
        unset($this->detallePedido[$indice]);
    }
    public function editarItem($indice){
        $this->editandoItem = $indice;
        $this->card_header_servicio = 'Editando Servicio';
        $this->card_body_btn_servicio = 'Editar Servicio';
        $this->emit('updateDescripcionServicio', $this->detallePedido[$indice]['descripcion']);
        $this->servicioSeleccionado = $this->detallePedido[$indice]['descripcion'];
        $this->cantidad = $this->detallePedido[$indice]['cantidad'];
        $this->costo = $this->detallePedido[$indice]['precio'];
        $this->importe = $this->detallePedido[$indice]['importe'];
    }

    public function agregar_item(){

        $this->resetErrorBag();
        $this->abrirModal();
        $this->validateCliente();

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
        if(isset($this->editandoItem)){
            $this->eliminarItem($this->editandoItem);
            $this->editandoItem = null;
        }
        $this->total = $this->total+$this->importe;
        $this->resetNewItem();
    }

    public function generar_comprobante(){

        if(isset($this->editandoItem)){
            Validator::make(
                ['editandoItem' => null],
                ['editandoItem' => 'required'],
                ['required' => 'Termine de editar Item'],
            )->validate();
        }
        $this->resetErrorBag();
        $this->abrirModal();
        $this->validateCliente();

        Validator::make(
            ['detalle' => $this->detallePedido],
            ['detalle' => 'required'],
            ['required' => 'Agregar Servicios'],
        )->validate();
        $recibo = new Recibo();
        $recibo->cliente_id = $this->hcliente->id;
        $recibo->femision = now();
        $recibo->termino = $this->forma_pago;
        $recibo->total = $this->total;
        $recibo->cajero_id = 1;
        $recibo->save();
        $recibo->correlativo = $recibo->id;
        $recibo->save();

        foreach($this->detallePedido as $item) {
            $addItem = new Detalle($item);
            $addItem->recibo_id = $recibo->id;
            $addItem->save();
        };
        $this->mount($this->hcliente->id);
    }

    public function validateCliente(){

        Validator::make(
            ['cliente' => $this->hcliente->id],
            ['cliente' => 'required'],
            ['required' => 'Seleccionar Cliente'],
        )->validate();

    }

    /**
     * Abre modal de clientes, en caso no se haya seleccionado un cliente
    */
    public function abrirModal(){
        if(!$this->hcliente->id){
            $this->emit('abrir_modal');
        }
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
