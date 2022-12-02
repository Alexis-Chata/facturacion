<?php

namespace Database\Seeders;

use App\Models\Serie;
use Illuminate\Database\Seeder;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serie = new Serie();
        $serie->tipo_comprobante_id = '01';
        $serie->serie = 'F001';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '07';
        $serie->serie = 'FC01';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '08';
        $serie->serie = 'FD01';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '03';
        $serie->serie = 'B001';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '07';
        $serie->serie = 'BC01';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '08';
        $serie->serie = 'BD01';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '00';
        $serie->serie = 'RE01';
        $serie->correlativo = '0';
        $serie->save();

        $serie = new Serie();
        $serie->tipo_comprobante_id = '00';
        $serie->serie = 'RE02';
        $serie->correlativo = '0';
        $serie->save();
    }
}
