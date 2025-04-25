<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StorePermissionRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Services\RoleService;
use App\Traits\ApiResponse;

class RoleController extends Controller
{
    use ApiResponse;

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function createRole(StoreRoleRequest $request)
    {
        $role = $this->roleService->createRole($request->validated());
        return $this->successResponse($role, 'Role created successfully', 201);
    }

    public function assignRole($userId, StoreRoleRequest $request)
    {
        dd($userId);
        $user = $this->roleService->assignRoleToUser($userId, $request->validated()['name']);
        return $this->successResponse($user, 'Role assigned successfully');
    }

    public function createPermission(StorePermissionRequest $request)
    {
        $permission = $this->roleService->createPermission($request->validated());
        return $this->successResponse($permission, 'Permission created successfully', 201);
    }

    public function assignPermissionToRole($roleName, StorePermissionRequest $request)
    {
        $role = $this->roleService->assignPermissionToRole($roleName, $request->validated()['name']);
        return $this->successResponse($role, 'Permission assigned to role successfully');
    }
}
