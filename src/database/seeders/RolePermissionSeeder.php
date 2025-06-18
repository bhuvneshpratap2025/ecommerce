<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'publish products']);

        // Create roles and assign existing permissions
        $spRole = Role::create(['name' => 'super-admin']);
        $spRole->givePermissionTo(['edit products', 'delete products', 'publish products']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['edit products', 'publish products']);

        $normalRole = Role::create(['name' => 'default']);
        $normalRole->givePermissionTo('publish products');
    }
}
