<?php

namespace Database\Seeders;

use App\Models\Tcliente;
use Illuminate\Database\Seeder;

class TclienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tcliente = new Tcliente();
        $tcliente->name = "Persona Natural";
        $tcliente->save();

        $tcliente = new Tcliente();
        $tcliente->name = "Persona Juridica";
        $tcliente->save();
    }
}
