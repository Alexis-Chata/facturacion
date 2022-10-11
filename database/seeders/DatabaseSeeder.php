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
        $this->call(ServicioSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TclienteSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(ReciboSeeder::class);
        $this->call(FormaPagoSeeder::class);
    }
}
