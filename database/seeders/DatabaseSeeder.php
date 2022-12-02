<?php

namespace Database\Seeders;

use App\Models\FormaPago;
use App\Models\Tcliente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TclienteSeeder::class);
        $this->call(FormaPagoSeeder::class);
        $this->call(ClienteSeeder::class);
        // $this->call(ReciboSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(TipoComprobanteSeeder::class);
        $this->call(SerieSeeder::class);
        $this->call(TipoAfectacionSeeder::class);
        $this->call(TipoConceptosCobroSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(EmisorSeeder::class);
        $this->call(ServicioSeeder::class);

    }
}
