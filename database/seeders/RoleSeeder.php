<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Cajero']);

        Permission::create(['name' =>'admin.general'])->syncRoles(['Administrador']);
        Permission::create(['name' =>'cajero.general'])->syncRoles(['Cajero']);
    }
}
