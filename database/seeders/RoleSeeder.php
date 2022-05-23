<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Permission::create(['name' => 'admin']);
        Permission::create(['name' => 'carrito']);

        $admin = Role::create(['name' => 'admin'])->givePermissionTo(['admin','carrito']);
        $user = Role::create(['name' => 'user'])->givePermissionTo('carrito');
    }
}
