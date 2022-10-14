<?php

namespace App\Http\Livewire;

use App\Exports\CrecibosExport;
use App\Mail\TestMail;
use App\Models\Cliente;
use App\Models\Detalle;
use App\Models\FormaPago;
use App\Models\Recibo;
use App\Models\Servicio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Luecano\NumeroALetras\NumeroALetras;
use Maatwebsite\Excel\Facades\Excel;

class HistorialRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $hcliente;
    public $listaServicios, $servicioSeleccionado;
    public $cantidad, $costo, $importe, $detallePedido, $total;
    public $forma_pago, $f_emision, $card_body_btn_generar_comprobante, $editar_comprobante_id, $editar_detalle_id;
    public $editandoItem, $card_header_servicio, $card_body_btn_servicio, $card_header_recibo;

    public function descargar_historial(){
        if($this->hcliente->id){
            $cliente = $this->hcliente;
        return Excel::download(new CrecibosExport($cliente), 'ReporteFicha_usuario.xlsx');
        }
    }
    public function  mount($cliente_id=null){

        $this->resetRecibo();
        $this->resetErrorBag();
        $this->listaServicios = Servicio::all();
        $this->forma_pago = 'Efectivo';
        $this->card_header_recibo = 'RECIBO';
        $this->card_body_btn_generar_comprobante = 'Generar Comprobante';
        $this->f_emision = now();
        $this->editar_comprobante_id = null;
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
        $this->card_header_servicio = 'Servicios';
        $this->card_body_btn_servicio = 'Agregar';
        $this->editar_detalle_id = null;
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
        $this->costo = $this->costo ? $this->costo : number_format(0, 2);
        $this->importe = number_format($this->cantidad * $this->costo , 2);
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
        $this->editar_detalle_id = isset($this->detallePedido[$indice]['id']) ? $this->detallePedido[$indice]['id'] : null;
        $this->emit('updateDescripcionServicio', $this->detallePedido[$indice]['descripcion']);
        $this->servicioSeleccionado = $this->detallePedido[$indice]['descripcion'];
        $this->cantidad = $this->detallePedido[$indice]['cantidad'];
        $this->costo = $this->detallePedido[$indice]['precio'];
        $this->importe = $this->detallePedido[$indice]['importe'];
    }

    public function agregar_item(Detalle $newItem){

        $this->resetErrorBag();
        $this->abrirModal();
        $this->validateCliente();

        Validator::make(
            ['servicio' => $this->servicioSeleccionado ? $this->servicioSeleccionado: null, 'cantidad' => $this->cantidad, 'costo' => $this->costo],
            ['servicio' => 'required', 'cantidad' => 'required|numeric|min:1', 'costo' => 'required|numeric|min:1'],
            ['required' => 'requerido', 'min' => 'minimo 1'],
        )->validate();
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

    public function generar_comprobante(Recibo $recibo){

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
        $recibo->femision = $this->f_emision;
        $recibo->cliente_id = $this->hcliente->id;
        $recibo->termino = $this->forma_pago;
        $recibo->total = $this->total;
        $recibo->cajero_id = 1;
        $recibo->save();
        $recibo->correlativo = $recibo->correlativo ? $recibo->correlativo : $recibo->id;
        $recibo->save();

        foreach($this->detallePedido as $item) {
            $item['id'] = isset($item['id']) ? $item['id'] : null;
            $item['recibo_id'] = isset($item['recibo_id']) ? $item['recibo_id'] : $recibo->id;
            isset($item['id']) ? Detalle::updateOrCreate(['id' => $item['id']], $item) : Detalle::create($item);
        };
        $this->generar_reciboPdf($recibo);
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

    public function generar_reciboPdf(Recibo $recibo){

        $formatter = new NumeroALetras();
        $total_letra = $formatter->toInvoice($recibo->total, 2, 'QUETZALES EXACTOS');

        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo', 'total_letra'));

        if (! File::exists(storage_path('app/public/') . 'recibospdf/')) {
            File::makeDirectory(storage_path('app/public/') . 'recibospdf/');
        }
        $nombreticketpdf ='recibospdf/rec-'.$recibo->correlativo.'.pdf';
        $consultapdf->save(storage_path('app/public/') . $nombreticketpdf);
        $recibo->path_pdf = $nombreticketpdf;
        $recibo->save();
    }

    public function descargar_recibo(Recibo $recibo){

        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo'));
        $pdfContent = $consultapdf->output();
        $this->generar_reciboPdf($recibo);
        return response()->streamDownload(
            fn () => print($pdfContent),
            "recibo.pdf"
        );
    }

    public function editarComprobante(Recibo $recibo){
        $this->card_header_recibo = 'EDITANDO RECIBO REC - '.$recibo->correlativo;
        $this->card_body_btn_generar_comprobante = 'Actualizar Comprobante';
        $this->f_emision = Carbon::parse($recibo->femision);
        $this->forma_pago = $recibo->termino;
        $this->detallePedido = collect($recibo->detalles->toArray());
        $this->total = $recibo->total;
        $this->editar_comprobante_id = $recibo->id;
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
