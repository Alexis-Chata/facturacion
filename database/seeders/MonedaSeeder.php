<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $producto = new Moneda();
        $producto->id = 'PEN';
        $producto->descripcion = 'SOLES';
        $producto->save();

        $producto = new Moneda();
        $producto->id = 'USD';
        $producto->descripcion = 'DOLARES';
        $producto->save();
    }
}
