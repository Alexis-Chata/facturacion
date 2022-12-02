<?php

namespace Database\Seeders;

use App\Models\TipoComprobante;
use Illuminate\Database\Seeder;

class TipoComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = '01';
        $tipoComprobante->descripcion = 'FACTURA';
        $tipoComprobante->letras = 'FAC';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = '00';
        $tipoComprobante->descripcion = 'RECIBO ELECTRONICO';
        $tipoComprobante->letras = 'REC';
        $tipoComprobante->save();
        $tipoComprobante->id = '00';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = '03';
        $tipoComprobante->descripcion = 'BOLETA';
        $tipoComprobante->letras = 'BOL';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = '07';
        $tipoComprobante->descripcion = 'NOTA DE CREDITO';
        $tipoComprobante->letras = 'NCR';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = '08';
        $tipoComprobante->descripcion = 'NOTA DE DEBITO';
        $tipoComprobante->letras = 'NDE';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = '09';
        $tipoComprobante->descripcion = 'GUIA DE REMISION';
        $tipoComprobante->letras = 'GUI';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = 'RA';
        $tipoComprobante->descripcion = 'RESUMEN ANULACIONES';
        $tipoComprobante->letras = 'RAN';
        $tipoComprobante->save();

        $tipoComprobante = new TipoComprobante();
        $tipoComprobante->id = 'RC';
        $tipoComprobante->descripcion = 'RESUMEN COMPROBANTE';
        $tipoComprobante->letras = 'RCO';
        $tipoComprobante->save();
    }
}
