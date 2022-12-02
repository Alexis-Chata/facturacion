<?php

namespace App\Http\Controllers;

use App\Models\CorrelativoNotaCreditoBC01;
use App\Models\Detalle;
use App\Models\Recibo;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Http\Request;

class CpeController extends Controller
{
    public function index(){
        $cp = Recibo::get()->whereNotIn('tipo_comprobante_id', [0])->whereNotIn('estado_comprobante', ['ok']);
        foreach($cp as $cpe){
            if(file_exists(storage_path('app/public/cpe/R-'.$cpe->emisor->ruc.'-'.$cpe->tipo_comprobante_id.'-'.$cpe->serie.'-'.$cpe->correlativo.'.xml'))){
                $doc_cdr = new DOMDocument();
                $infocdr = file_get_contents(storage_path('app/public/cpe/R-'.$cpe->emisor->ruc.'-'.$cpe->tipo_comprobante_id.'-'.$cpe->serie.'-'.$cpe->correlativo.'.xml'));
                $doc_cdr->loadXML($infocdr);
                $ResponseCode = $doc_cdr->getElementsByTagName("ResponseCode")->item(0)->nodeValue;
                if($ResponseCode == '0'){
                    $cpe->nombrexml = $cpe->emisor->ruc.'-0'.$cpe->tipo_comprobante_id.'-'.$cpe->serie.'-'.$cpe->correlativo.'.xml';
                    $cpe->codigo_sunat = $doc_cdr->getElementsByTagName("ResponseCode")->item(0)->nodeValue;
                    $cpe->mensaje_sunat = $doc_cdr->getElementsByTagName("Description")->item(0)->nodeValue;
                    $cpe->cestado = 2;//aceptado
                    $cpe->estado_comprobante = 'ok';//aceptado
                    $cpe->save();
                }
            }
        }
        return  view('administrador.cpe.comprobantes_electronicos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comprobante = Recibo::find(1)->emisor;
        //echo env('LOG_CHANNEL');
        return $comprobante;
    }

    public function envio($id, $envio){

        $details = array();
        $descuentos = array();
        $this->comprobante = Recibo::find($id);
        $formatter = new NumeroALetras();
        $total_letra = $formatter->toInvoice($this->comprobante->total, 2, strtolower($this->comprobante->moneda->descripcion));
        $sumOtrosDescuentos = 0;
        $mtoOperInafectas = 0;
        $mtoOperGravadas = 0;
        foreach($this->comprobante->operaciones as $operaciones){
            if($operaciones->tipo_conceptos_cobro_id == 3){
                $sumOtrosDescuentos = $sumOtrosDescuentos + $operaciones->pago;
                $descuentos[] = [
                    "codTipo" =>  "03",
                    "factor" => 0,
                    "monto" => $operaciones->pago,
                ];
            }else{
                $details[] = [
                            "codProducto" => $operaciones->producto_id,
                            "unidad" => $operaciones->producto->unidad_id,
                            "descripcion" => $operaciones->descripcion,
                            "cantidad" => $operaciones->cantidad,
                            "mtoValorUnitario" => $operaciones->valor_unitario,
                            "mtoValorVenta" => $operaciones->valor_total,
                            "mtoBaseIgv" => $operaciones->valor_unitario*$operaciones->cantidad,
                            "porcentajeIgv" => $operaciones->porcentaje_igv,
                            "igv" => $operaciones->igv,
                            "tipAfeIgv" => $operaciones->tipo_afectacion_id,
                            "totalImpuestos" => $operaciones->igv,
                            "mtoPrecioUnitario" => $operaciones->precio_unitario
                ];
            }
        }
        $datoscdp = [
            "ublVersion" => "2.1",
            "tipoOperacion" => "0101",
            "tipoDoc" => $this->comprobante->tipo_comprobante_id,
            "serie" => $this->comprobante->serie,
            "correlativo" => $this->comprobante->correlativo,
            "fechaEmision" => $this->comprobante->f_emision."T00:00:00-05:00",
            "formaPago" => [
                "moneda" => $this->comprobante->moneda_id,
                "tipo" => "Contado"
            ],
            "tipoMoneda" => $this->comprobante->moneda_id,
            "client" => [
                "tipoDoc" => "1",
                "numDoc" => $this->comprobante->cliente->dni,
                "rznSocial" => $this->comprobante->cliente->name." ".$this->comprobante->cliente->ap_parteno,
                "address" => [
                    "direccion" => $this->comprobante->cliente->direccion
                    // "provincia" => "LIMA",
                    // "departamento" => "LIMA",
                    // "distrito" => "LIMA",
                    // "ubigueo" => "150101"
                ]
            ],
            "company" => [
                "ruc" => $this->comprobante->emisor->ruc,
                "razonSocial" => $this->comprobante->emisor->nombre,
                "nombreComercial" => $this->comprobante->emisor->nombre,
                "address" => [
                    "direccion" => $this->comprobante->emisor->direccion,
                    "provincia" => $this->comprobante->emisor->provincia,
                    "departamento" => $this->comprobante->emisor->departamento,
                    "distrito" => $this->comprobante->emisor->distrito,
                    "ubigueo" => $this->comprobante->emisor->ubigueo
                ]
            ],
            "mtoOperInafectas" => $this->comprobante->op_inafectas,
            "mtoOperGravadas" => $this->comprobante->op_gravadas,
            "mtoOperExoneradas" => $this->comprobante->op_exoneradas,
            "mtoIGV" => $this->comprobante->igv,
            "valorVenta" => $this->comprobante->op_inafectas + $this->comprobante->op_gravadas + $this->comprobante->op_exoneradas,
            "totalImpuestos" => $this->comprobante->igv,
            "subTotal" => $this->comprobante->total,
            "mtoImpVenta" => $this->comprobante->total,
            "details" => $details,
            "legends" => [
                [
                    "code" => "1000",
                    "value" => $total_letra
                ]
            ]
        ];

        if( $this->comprobante->tipo == 'NOTA DE CREDITO ELECTRONICA'){
            $datoscdp["ublVersion"] = "2.1";
            $datoscdp["tipoDoc"] = $this->comprobante->tipo_comprobante_id;
            $datoscdp["tipDocAfectado"] = $this->comprobante->tipo_comprobante_ref_id;
            $datoscdp["numDocfectado"] = $this->comprobante->serie_ref.'-'.$this->comprobante->correlativo_ref;
            $datoscdp["codMotivo"] = $this->comprobante->codmotivo;
            $datoscdp["desMotivo"] = "ANULACION DE LA OPERACION";
            unset ($datoscdp["formaPago"]);
            $envio = str_replace("invoice","note",$envio);
        }

        if (count($descuentos)>0) {
            $datoscdp['sumOtrosDescuentos'] = $sumOtrosDescuentos;
            $datoscdp['descuentos'] = $descuentos;
        } //dd($datoscdp);

        $response = Http::withToken($this->comprobante->emisor->tokenapisperu)->post('https://facturacion.apisperu.com/api/v1/'.$envio, $datoscdp );

        return $response;
    }

    public function factura_boleta($id){

        $response = $this->envio($id,'invoice/send');

        $response1 = $response->json();
        if($response1['sunatResponse']['success']){
            Storage::disk('local')->put('/public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'-CDR.zip', base64_decode($response1['sunatResponse']['cdrZip']));
            $zip = new ZipArchive;
            if($zip->open(storage_path('app/public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'-CDR.zip'))===true){
                $zip->extractTo(storage_path('app/public/cpe/'));
                $zip->close();
            }

            if($response1['sunatResponse']['cdrResponse']['code']=="0"){
                $this->comprobante->cdrbase64 = $response1['sunatResponse']['cdrZip'];
                $this->comprobante->nombrexml = $this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'.xml';
                $this->comprobante->hash = $response1['hash'];
                $this->comprobante->codigo_sunat = $response1['sunatResponse']['cdrResponse']['code'];
                $this->comprobante->mensaje_sunat = $response1['sunatResponse']['cdrResponse']['description'];
                $this->comprobante->cestado = 2;//aceptado
                $this->comprobante->estado_comprobante = 'ok';//aceptado
                $this->comprobante->save();
            }
        }else{
            $this->comprobante->hash = $response1['hash'];
            $this->comprobante->codigo_sunat = $response1['sunatResponse']['error']['code'];
            $this->comprobante->mensaje_sunat = $response1['sunatResponse']['error']['message'];
            $this->comprobante->cestado = $response1['sunatResponse']['error']['code'].' - '.$response1['sunatResponse']['error']['message'];// Error CodeSunat
            $this->comprobante->estado_comprobante = $response1['sunatResponse']['error']['code'];
            $this->comprobante->save();
        }
        //return $response1;
        return redirect()->route('admin.pagos.comprobantes');
    }

    public function pdf($id){

        $response = $this->envio($id,'invoice/pdf');

        $body = $response->getBody();
        // Explicitly cast the body to a string
        $stringBody = (string) $body;
        Storage::disk('local')->put('/public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'.pdf', $stringBody);
        //return response()->file(storage_path('app/public/cpe/Invoice_12345-234566.pdf'));
        return Storage::response('public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'.pdf');

    }

    public function xml($id){

        $response = $this->envio($id,'invoice/xml');

        $body = $response->getBody();
        // Explicitly cast the body to a string
        $stringBody = (string) $body;
        Storage::disk('local')->put('/public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'.xml', $stringBody);
        //return response()->file(storage_path('app/public/cpe/Invoice_12345-234566.pdf'));
        return Storage::response('public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'.xml');

    }

    public function notacredito($id){

        $response = $this->envio($id,'note/send');

        $response1 = $response->json();
        if($response1['sunatResponse']['success']){
            Storage::disk('local')->put('/public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'-CDR.zip', base64_decode($response1['sunatResponse']['cdrZip']));
            $zip = new ZipArchive;
            if($zip->open(storage_path('app/public/cpe/'.$this->comprobante->emisor->ruc.'-'.$this->comprobante->tipo_comprobante_id.'-'.$this->comprobante->serie.'-'.$this->comprobante->correlativo.'-CDR.zip'))===true){
                $zip->extractTo(storage_path('app/public/cpe/'));
                $zip->close();
            }
            if($response1['sunatResponse']['cdrResponse']['code']=="0"){
                $this->comprobante->cestado = 2;//aceptado
                $this->comprobante->save();
            }
        }else{
            $this->comprobante->cestado = $response1['sunatResponse']['error']['code'].' - '.$response1['sunatResponse']['error']['message'];// Error CodeSunat
            $this->comprobante->save();
        }
        return redirect()->route('admin.pagos.comprobantes');
    }

    public function anularComprobante(Recibo $comprobante){
        $comprobante->cestado = 'anulado';
        $comprobante->save();

        $mensualidades= Detalle::where('comprobante_id', $comprobante->id)->where('tipo_conceptos_cobro_id',2)->get();

        $operaciones = $comprobante->operaciones;
        foreach($operaciones as $operacion){
            if($operacion->opereferencia){
                $operacionref = Detalle::find($operacion->opereferencia);
                $operacionref->estado = 'pendiente';
                $operacionref->save();
            }
            $operacion->estado = 'anulado';
            $operacion->save();
        }

        if($comprobante->tipo == "BOLETA DE VENTA ELECTRONICA"){

            $correlativo = new CorrelativoNotaCreditoBC01();
            $correlativo->save();
            $tipo = "NOTA DE CREDITO ELECTRONICA";
            $tipo_comprobante = "07";

            $pago = Recibo::create([
                'tipo' => $tipo,
                'tipo_comprobante' => $tipo_comprobante,
                'serie' => 'BC01',
                'correlativo' => $correlativo->id,
                'fechavencimiento' => now(),
                'fechaemision' => now(),
                'total' => $comprobante->total,
                'igv' => 0,
                'monto' => $comprobante->total,
                'empresa_id' => 1,
                'usuario_id' => $comprobante->usuario_id,
                'cestado' => '1',
                'cajero_id' =>  Auth::user()->id,
                'ref_id' => $comprobante->id,
                'tipo_comprobante_ref_id' => $comprobante->tipo_comprobante_id,
                'serie_ref' => $comprobante->serie,
                'correlativo_ref' => $comprobante->correlativo,
                'codmotivo' => '0'.$comprobante->tipo_comprobante_id,
            ]);

            $alloperas = Detalle::where('comprobante_id', $comprobante->id)->get();

            foreach ($alloperas as $allopera) {
                $operacionNC = $allopera->replicate()->fill([
                    'comprobante_id' => $pago->id,
                    'estado' => 'cancelado'
                ]);

                $operacionNC->save();
            }
        }
    }

    public function ticket($id){
        $pago = Recibo::find($id);
        $formatter = new NumeroALetras();
        $total_letra = $formatter->toInvoice($pago->total, 2, 'soles');
        $f_venci = date('d-m-Y', strtotime($pago->fv_ucpagada));

        $paper_heigth = 355;
        if ($pago->tipo!="RECIBO ELECTRONICO"){
            $paper_heigth = $paper_heigth+80;
        }
        $pdfContent = FacadePdf::loadView('pagos.comprobante',compact('pago', 'total_letra', 'f_venci'))->setPaper([0, 0, 215.25, $paper_heigth+13*2*$pago->operaciones->count()]);
        return $pdfContent->stream();
    }
}
