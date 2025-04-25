<?php

namespace App\Services;

use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function createRole(array $data)
    {
        return Role::create(['name' => $data['name']]);
    }

    public function assignRoleToUser($userId, $roleNames)
    {
        $user = User::findOrFail($userId);
        $user->assignRole($roleNames);
        return $user;
    }

    public function createPermission(array $data)
    {
        return Permission::create(['name' => $data['name']]);
    }

    public function assignPermissionToRole($roleNames, $permissionNames)
    {
        $role = Role::findByName($roleNames);
        $role->givePermissionTo($permissionNames);
        return $role;
    }
}
