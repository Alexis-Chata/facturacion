<?php

namespace Database\Seeders;

use App\Models\FormaPago;
use Illuminate\Database\Seeder;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formaPago = new FormaPago();
        $formaPago->name = 'Efectivo';
        $formaPago->save();

        $formaPago = new FormaPago();
        $formaPago->name = 'Deposito';
        $formaPago->save();
    }
}
