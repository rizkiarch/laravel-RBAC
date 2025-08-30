<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StorePermissionRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Services\RoleService;
use App\Traits\ApiResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use ApiResponse;

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return $this->successResponse($roles);
    }

    public function createRole(StoreRoleRequest $request)
    {
        $role = $this->roleService->createRole($request->validated());
        return $this->successResponse($role, 'Role created successfully', 201);
    }

    public function assignRole($userId, StoreRoleRequest $request)
    {
        $roleNames = $request->validated()['name'];

        $role = Role::findByName($roleNames);
        if (!$role) {
            return $this->errorResponse('Role not found', 404);
        }

        $user = $this->roleService->assignRoleToUser($userId, $roleNames);
        return $this->successResponse($user, 'Role assigned to user successfully');
    }

    public function indexPermissions()
    {
        $permissions = Permission::all();
        return $this->successResponse($permissions);
    }

    public function createPermission(StorePermissionRequest $request)
    {
        $permission = $this->roleService->createPermission($request->validated());
        return $this->successResponse($permission, 'Permission created successfully', 201);
    }

    public function assignPermissionToRole($roleName, StorePermissionRequest $request)
    {
        $permissionNames = $request->validated()['name'];

        $permission = Permission::findByName($permissionNames);
        if (!$permission) {
            return $this->errorResponse('Permission not found', 404);
        }

        $role = Role::findByName($roleName);
        if (!$role) {
            return $this->errorResponse('Role not found', 404);
        }

        $role->givePermissionTo($permission);
        return $this->successResponse($role, 'Permission assigned to role successfully');
    }
}
