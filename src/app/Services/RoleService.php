<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;
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
        $user->syncRoles(is_array($roleNames) ? $roleNames : [$roleNames]);
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
