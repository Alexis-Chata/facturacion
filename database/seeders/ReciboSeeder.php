<?php

namespace Database\Seeders;

use App\Models\Detalle;
use App\Models\Recibo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;


class ReciboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recibos = Recibo::factory(20)->create();

        foreach ($recibos as $keya => $recibo) {
            $detalles = Detalle::factory(rand(1,5))->create([
                'recibo_id' => $recibo->id,
            ]);
            $total = 0;
            foreach ($detalles as $key => $detalle) {
                $total = $total + $detalle->importe_total;
            }
            $recibo->correlativo = $keya+1;
            $recibo->total = $total;
            $recibo->save();
        }
    }
}
