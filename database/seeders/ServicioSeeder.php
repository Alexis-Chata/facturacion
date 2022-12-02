<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $servicios = Servicio::factory(20)->create();

        $producto12 = new Servicio();
        $producto12->name = 'Descuento';
        $producto12->valor_unitario = 0.00; //precio sin IGV
        $producto12->precio_unitario = 0.00;
        $producto12->tipo_afectacion_id = 30;
        $producto12->unidad_id = 'ZZ';
        $producto12->tipo_conceptos_cobro_id = 2;
        $producto12->save();

        $producto12 = new Servicio();
        $producto12->name = 'Devolucion';
        $producto12->valor_unitario = 0.00; //precio sin IGV
        $producto12->precio_unitario = 0.00;
        $producto12->tipo_afectacion_id = 30;
        $producto12->unidad_id = 'ZZ';
        $producto12->tipo_conceptos_cobro_id = 3;
        $producto12->save();

        $producto = new Servicio();
        $producto->name = 'Matricula';
        $producto->valor_unitario = 20.00; //precio sin IGV
        $producto->precio_unitario = 20.00;
        $producto->tipo_afectacion_id = 30;
        $producto->unidad_id = 'ZZ';
        $producto->tipo_conceptos_cobro_id = 1;
        $producto->save();

        $producto2 = new Servicio();
        $producto2->name = 'Cuota';
        $producto2->valor_unitario = 350.00; //precio sin IGV
        $producto2->precio_unitario = 350.00;
        $producto2->tipo_afectacion_id = 30;
        $producto2->unidad_id = 'ZZ';
        $producto2->tipo_conceptos_cobro_id = 1;
        $producto2->save();

        $producto9 = new Servicio();
        $producto9->name = 'Calculo';
        $producto9->valor_unitario = 296.61; //precio sin IGV
        $producto9->precio_unitario = 350.00;
        $producto9->tipo_afectacion_id = 10;
        $producto9->unidad_id = 'ZZ';
        $producto9->tipo_conceptos_cobro_id = 1;
        $producto9->save();

        $producto10 = new Servicio();
        $producto10->name = 'Certificado de Estudios';
        $producto10->valor_unitario = 4.24; //precio sin IGV
        $producto10->precio_unitario = 5.00;
        $producto10->tipo_afectacion_id = 20;
        $producto10->unidad_id = 'ZZ';
        $producto10->tipo_conceptos_cobro_id = 1;
        $producto10->save();

        $producto11 = new Servicio();
        $producto11->name = 'Carnet';
        $producto11->valor_unitario = 4.24; //precio sin IGV
        $producto11->precio_unitario = 5.00;
        $producto11->tipo_afectacion_id = 10;
        $producto11->unidad_id = 'ZZ';
        $producto11->tipo_conceptos_cobro_id = 1;
        $producto11->save();
    }
}
