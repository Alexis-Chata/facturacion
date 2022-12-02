<?php

namespace App\Http\Livewire;

use App\Clases\ReciboClass;
use App\Models\Cliente;
use App\Models\CorrelativoBoletaB001;
use App\Models\CorrelativoFacturaF001;
use App\Models\CorrelativoNotaCreditoBC01;
use App\Models\CorrelativoNotaCreditoFC01;
use App\Models\CorrelativoReciboRE01;
use App\Models\CorrelativoReciboRE02;
use App\Models\Detalle;
use App\Models\FormaPago;
use App\Models\Recibo;
use App\Models\Serie;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class HistorialRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $hcliente;
    public $listaServicios, $servicioSeleccionado;
    public $cantidad, $precio_unitario, $importe_total, $detallePedido, $total;
    public $forma_pago, $f_emision, $card_body_btn_generar_comprobante, $editar_comprobante_id, $editar_detalle_id;
    public $editandoItem, $card_header_servicio, $card_body_btn_servicio, $card_header_recibo;

    public function actualizar_servicios(){
        $this->listaServicios = Servicio::all();
    }

    public function descargar_historial(){
        if($this->hcliente->id){
            $r_recibo = new ReciboClass();
            return $r_recibo->descargar_historial_cliente($this->hcliente);
        }
    }
    public function  mount($cliente_id=null){
        $this->resetRecibo();
        $this->resetErrorBag();
        $this->inputDoc = isset($this->inputDoc) ? $this->inputDoc : 'B001';
        $this->listaServicios = Servicio::all();
        $this->servicioSeleccionado = "";
        $this->forma_pago = 'Efectivo';
        $this->card_header_recibo = 'RECIBO';
        $this->card_body_btn_generar_comprobante = 'Generar Comprobante';
        $this->f_emision = date('Y-m-d');
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
        $this->precio_unitario = 0;
        $this->servicioSeleccionado = "";
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
        $this->precio_unitario = $this->precio_unitario ? number_format($this->precio_unitario, 2, '.', '') : number_format(0, 2);
        $this->importe_total = number_format($this->cantidad * $this->precio_unitario, 2, '.', '');
    }

    public function updatedPrecioUnitario(){

        $this->updatedCantidad();
    }

    public function updatedservicioSeleccionado(){

        $precio_unitarioSeleccionado = Servicio::find($this->servicioSeleccionado) ? Servicio::find($this->servicioSeleccionado)->precio_unitario : 0;
        $this->precio_unitario = number_format($precio_unitarioSeleccionado, 2, '.', '') ;
        $this->updatedCantidad();
    }

    protected $listeners = ['clienteIdToRecibo','eliminar_recibo','actualizar_servicios'];

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
        $this->emit('actualizar_lista');
        if(!$this->hcliente->id){
            $this->hcliente->name = ' ----- Seleccionar Cliente ----- ';
            $this->hcliente->direccion = ' ----- Seleccionar Cliente ----- ';
        }
        $formaPago = FormaPago::all();
        $series = Serie::all();
        return view('livewire.historial-recibos', compact('formaPago', 'series'));
    }

    public function eliminarItem($indice){

        $this->total = $this->total-$this->detallePedido[$indice]['importe_total'];
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
        $this->precio_unitario = $this->detallePedido[$indice]['precio_unitario'];
        $this->importe_total = $this->detallePedido[$indice]['importe_total'];
    }

    public function agregar_item(Detalle $newItem){

        $this->resetErrorBag();
        $this->abrirModal();
        $this->validateCliente();

        Validator::make(
            ['servicio' => $this->servicioSeleccionado ? $this->servicioSeleccionado: null, 'cantidad' => $this->cantidad, 'precio_unitario' => $this->precio_unitario],
            ['servicio' => 'required', 'cantidad' => 'required|numeric|min:1', 'precio_unitario' => 'required|numeric|min:1'],
            ['required' => 'requerido', 'min' => 'minimo 1'],
        )->validate();

        $productoServicio = Servicio::find($this->servicioSeleccionado);
        $porcentaje_igv = 18;
        $valor_unitario = number_format($this->precio_unitario/1.18, 2, '.', '');
        switch ($productoServicio->tipo_afectacion_id) {
            case '20':
            case '30':
                $valor_unitario = $this->precio_unitario;
                $porcentaje_igv = 0;
                break;
        }

        $newItem->producto_id = $this->servicioSeleccionado;
        $newItem->descripcion = $productoServicio->name;
        $newItem->cantidad = $this->cantidad;
        $newItem->valor_unitario = $valor_unitario;
        $newItem->precio_unitario = $this->precio_unitario;
        $newItem->igv = number_format(($this->precio_unitario-$valor_unitario) * $this->cantidad, 2, '.', '');
        $newItem->porcentaje_igv = $porcentaje_igv;
        $newItem->valor_total = number_format($valor_unitario * $this->cantidad, 2, '.', '');
        $newItem->importe_total = number_format($this->precio_unitario * $this->cantidad, 2, '.', '');
        $newItem->tipo_afectacion_id = $productoServicio->tipo_afectacion_id;
        $newItem->tipo_conceptos_cobro_id = $productoServicio->tipo_conceptos_cobro_id;
        $this->detallePedido->push($newItem->toArray());
        if(isset($this->editandoItem)){
            $this->eliminarItem($this->editandoItem);
            $this->editandoItem = null;
        }
        $this->total = $this->total+$this->importe_total;
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

        $serie = Serie::firstwhere('serie', $this->inputDoc);
        $tipo_comprobante = $serie->tipo_comprobante_id;
        switch ($tipo_comprobante) {
            case '00':
                $modelCorrelativo = "App\Models\CorrelativoRecibo".$serie->serie;
                $correlativo = new $modelCorrelativo();
                $correlativo->save();
                $tipo = "RECIBO DE PAGO";
                break;

            case '01':
                $modelCorrelativo = "App\Models\CorrelativoFactura".$serie->serie;
                $correlativo = new $modelCorrelativo();
                $correlativo->save();
                $tipo = "FACTURA ELECTRONICA";
                break;

            case '03':
                $modelCorrelativo = "App\Models\CorrelativoBoleta".$serie->serie;
                $correlativo = new $modelCorrelativo();
                $correlativo->save();
                $tipo = "BOLETA DE VENTA ELECTRONICA";
                break;

            case '07':
                $modelCorrelativo = "App\Models\CorrelativoNotaCredito".$serie->serie;
                $correlativo = new $modelCorrelativo();
                $correlativo->save();
                $tipo = "NOTA DE CREDITO ELECTRONICA";
                break;

        }

        $recibo->emisor_id = 1;
        $recibo->femision = $this->f_emision;
        $recibo->tipo_comprobante_id = $tipo_comprobante;
        $recibo->tipo = $tipo;
        $recibo->serie_id = $serie->id;
        $recibo->serie = $serie->serie;
        $recibo->forma_pago = 'Contado';
        $recibo->correlativo = $correlativo->id;
        $recibo->f_vencimiento = now();
        $recibo->f_emision = now();
        $recibo->moneda_id = "PEN";
        $recibo->op_gravadas = $this->detallePedido->where('tipo_afectacion_id', 10)->sum('valor_total');
        $recibo->op_exoneradas = $this->detallePedido->where('tipo_afectacion_id', 20)->sum('valor_total');
        $recibo->op_inafectas = $this->detallePedido->where('tipo_afectacion_id', 30)->sum('valor_total');
        $recibo->igv = $this->detallePedido->where('tipo_afectacion_id', 10)->sum('igv');
        $recibo->total = $this->total;
        $recibo->obs_ref = "-";
        $recibo->cliente_id = $this->hcliente->id;
        $recibo->cestado = 1;
        $recibo->cajero_id = Auth::user()->id;
        $recibo->tipo_comprobante_ref_id = null;
        $recibo->comprobante_ref_id = null;
        $recibo->serie_ref = null;
        $recibo->correlativo_ref = null;

        $recibo->termino = $this->forma_pago;
        $recibo->save();
        $serie->correlativo = $correlativo->id;
        $serie->save();

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


    public function generar_reciboPdf(Recibo $recibo)
    {
        $r_recibo = new ReciboClass();
        $r_recibo->generar_reciboPdf($recibo);
    }

    public function descargar_recibo(Recibo $recibo){
        $r_recibo = new ReciboClass();
        return $r_recibo->descargar_recibo($recibo);
    }

    public function editarComprobante(Recibo $recibo){
        $this->card_header_recibo = 'EDITANDO RECIBO REC - '.$recibo->correlativo;
        $this->card_body_btn_generar_comprobante = 'Actualizar Comprobante';
        $this->f_emision = $recibo->femision;
        $this->forma_pago = $recibo->termino;
        $this->detallePedido = collect($recibo->detalles->toArray());
        $this->total = $recibo->total;
        $this->editar_comprobante_id = $recibo->id;
    }

    public function reenviar(Recibo $recibo){
        $r_recibo = new ReciboClass();
        $r_recibo->reenviar($recibo,$recibo->cliente->email);
        $r_recibo->reenviar($recibo,$recibo->cliente->email2);
    }

    public function eliminar_recibo(Recibo $recibo){
        $scliente = $recibo->cliente->id;
        $recibo->delete();
        $this->hcliente = Cliente::find($scliente);
        $this->emit('notificar_eliminar',"Elimino el Usuario correctamente");
    }
}
