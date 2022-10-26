<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarioadmin = new User();
        $usuarioadmin->name = 'Administrador';
        $usuarioadmin->paterno = 'Arquitectura';
        $usuarioadmin->materno = 'Espacio';
        $usuarioadmin->dpi="987654321";
        $usuarioadmin->email = 'administrador@arquitectura.com';
        $usuarioadmin->password = bcrypt('Admin#123.@arquitectura.com');
        $usuarioadmin->save();
        $usuarioadmin->assignRole('Administrador');
        $usuarioadmin->assignRole('Cajero');

        $usuarioadmin = new User();
        $usuarioadmin->name = 'Otoniel Calderón';
        $usuarioadmin->paterno = 'Espacio';
        $usuarioadmin->materno = 'Arquitectura ';
        $usuarioadmin->dpi="123456789";
        $usuarioadmin->email = 'grupoespacio@hotmail.es';
        $usuarioadmin->password = bcrypt('123456789');
        $usuarioadmin->save();
        $usuarioadmin->assignRole('Administrador');
        $usuarioadmin->assignRole('Cajero');
    }
}
