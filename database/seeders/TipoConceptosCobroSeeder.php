<?php

namespace Database\Seeders;

use App\Models\TipoConceptosCobro;
use Illuminate\Database\Seeder;

class TipoConceptosCobroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tipoConceptosCobro = new TipoConceptosCobro();
        $tipoConceptosCobro->descripcion = 'Producto/Servicio';
        $tipoConceptosCobro->save();

        $tipoConceptosCobro = new TipoConceptosCobro();
        $tipoConceptosCobro->descripcion = 'Descuento';
        $tipoConceptosCobro->save();

        $tipoConceptosCobro = new TipoConceptosCobro();
        $tipoConceptosCobro->descripcion = 'Devolucion';
        $tipoConceptosCobro->save();
    }
}
