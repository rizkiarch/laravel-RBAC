<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    public function getAll()
    {
        return User::with('roles')->get();
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['role'])) {
            $role = Role::findByName($data['role'], 'api');
            $user->assignRole($role);
        }

        return $user->load('roles');
    }

    public function find($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);

        $updateData = [
            'name' => $data['name'] ?? $user->name,
            'email' => $data['email'] ?? $user->email,
        ];

        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (isset($data['email']) && $data['email'] !== $user->email) {
            $existingUser = User::where('email', $data['email'])->first();
            if ($existingUser) {
                throw new \Exception('The email has already been taken.');
            }
        }

        $user->update($updateData);

        if (isset($data['role'])) {
            $role = Role::findByName($data['role'], 'api');
            $user->syncRoles([$role]);
        }

        return $user->load('roles');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function assignRole($id, $roleName)
    {
        $user = User::findOrFail($id);
        $role = Role::findByName($roleName, 'api');
        $user->syncRoles([$role]);
        return $user->load('roles');
    }
}
