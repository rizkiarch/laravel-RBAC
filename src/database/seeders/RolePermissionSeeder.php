<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-articles',
            'create-articles',
            'edit-articles',
            'delete-articles',
            'manage-roles',
            'manage-permissions',
            'manage-users',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

        $superadminRole = Role::create([
            'name' => 'superadmin',
            'guard_name' => 'api',
        ]);
        $superadminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'api',
        ]);
        $adminRole->givePermissionTo([
            'manage-articles',
            'create-articles',
            'edit-articles',
            'delete-articles',
            'manage-users',
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'guard_name' => 'api',
        ]);
        $userRole->givePermissionTo([
            'manage-articles',
            'create-articles',
            'edit-articles',
            'delete-articles',
        ]);
    }
}
