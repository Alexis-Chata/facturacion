<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_documento = new TipoDocumento();
        $tipo_documento->id = 1;
        $tipo_documento->descripcion = 'DNI';
        $tipo_documento->save();

        $tipo_documento = new TipoDocumento();
        $tipo_documento->id = 4;
        $tipo_documento->descripcion = 'CARNET DE EXTRANJERIA';
        $tipo_documento->save();

        $tipo_documento = new TipoDocumento();
        $tipo_documento->id = 6;
        $tipo_documento->descripcion = 'RUC';
        $tipo_documento->save();

        $tipo_documento = new TipoDocumento();
        $tipo_documento->id = 7;
        $tipo_documento->descripcion = 'PASAPORTE';
        $tipo_documento->save();

        $tipo_documento = new TipoDocumento();
        $tipo_documento->id = 2;
        $tipo_documento->descripcion = 'SIN DOCUMENTO';
        $tipo_documento->save();

        $tipo_documento = TipoDocumento::find(2);
        $tipo_documento->id = 0;
        $tipo_documento->save();
    }
}
