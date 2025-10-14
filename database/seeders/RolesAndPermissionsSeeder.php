<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view transactions']);
        Permission::create(['name' => 'manage transactions']);
        Permission::create(['name' => 'view reports']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'finance-admin']);
        $role->givePermissionTo(['view transactions', 'manage transactions', 'view reports']);

        $role = Role::create(['name' => 'compliance-admin']);
        $role->givePermissionTo(['view transactions', 'view reports']);

        $role = Role::create(['name' => 'support-admin']);
        $role->givePermissionTo(['view users', 'manage users', 'view transactions']);
    }
}