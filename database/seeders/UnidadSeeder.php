<?php

namespace Database\Seeders;

use App\Models\Unidad;
use Illuminate\Database\Seeder;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoComprobante = new Unidad();
        $tipoComprobante->id = '02';
        $tipoComprobante->descripcion = 'OTRA UNIDAD';
        $tipoComprobante->save();

        $tipoComprobante = new Unidad();
        $tipoComprobante->id = 'BX';
        $tipoComprobante->descripcion = 'CAJAS';
        $tipoComprobante->save();

        $tipoComprobante = new Unidad();
        $tipoComprobante->id = 'NIU';
        $tipoComprobante->descripcion = 'UNIDAD (BIENES)';
        $tipoComprobante->save();

        $tipoComprobante = new Unidad();
        $tipoComprobante->id = 'XY';
        $tipoComprobante->descripcion = 'UNIDAD X-Y';
        $tipoComprobante->save();

        $tipoComprobante = new Unidad();
        $tipoComprobante->id = 'XZ';
        $tipoComprobante->descripcion = 'UNIDAD XZ';
        $tipoComprobante->save();

        $tipoComprobante = new Unidad();
        $tipoComprobante->id = 'ZZ';
        $tipoComprobante->descripcion = 'UNIDAD (SERVICIOS)';
        $tipoComprobante->save();
    }
}
