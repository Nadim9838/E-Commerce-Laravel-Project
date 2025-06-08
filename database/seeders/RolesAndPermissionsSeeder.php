<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

    // Create permissions
    $permissions = ['view', 'add', 'edit', 'delete'];
    foreach ($permissions as $perm) {
        Permission::firstOrCreate(['name' => $perm]);
    }

    // Create roles and assign existing permissions
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $admin->givePermissionTo(Permission::all());

    $subAdmin = Role::firstOrCreate(['name' => 'sub-admin']);
    $subAdmin->givePermissionTo(['view', 'add']);
    }
}
