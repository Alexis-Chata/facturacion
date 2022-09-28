<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Facade\FlareClient\Http\Client;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = Cliente::factory(20)->create();
    }
}
