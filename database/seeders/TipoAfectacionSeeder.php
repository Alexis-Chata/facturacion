<?php

namespace Database\Seeders;

use App\Models\TipoAfectacion;
use Illuminate\Database\Seeder;

class TipoAfectacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producto = new TipoAfectacion();
        $producto->id = 10;
        $producto->descripcion = 'OP. GRAVADAS';
        $producto->letra = 'S';
        $producto->codigo = 1000;
        $producto->nombre = 'IGV';
        $producto->tipo = 'VAT';
        $producto->save();

        $producto = new TipoAfectacion();
        $producto->id = 20;
        $producto->descripcion = 'OP. EXONERADAS';
        $producto->letra = 'E';
        $producto->codigo = 9997;
        $producto->nombre = 'EXO';
        $producto->tipo = 'VAT';
        $producto->save();

        $producto = new TipoAfectacion();
        $producto->id = 30;
        $producto->descripcion = 'OP. INAFECTAS';
        $producto->letra = 'O';
        $producto->codigo = 9998;
        $producto->nombre = 'INA';
        $producto->tipo = 'FRE';
        $producto->save();
    }
}
