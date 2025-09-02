<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data)
    {
        try {
            \DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if (isset($data['role'])) {
                $role = Role::findByName($data['role'], 'api');
                $user->assignRole($role);
            } else {
                $defaultRole = Role::findByName('user', 'api');
                $user->assignRole($defaultRole);
            }

            $token = JWTAuth::fromUser($user);

            \DB::commit();

            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception('Registration failed. Please try again.');
        }
    }

    public function login(array $data)
    {
        if (! $token = JWTAuth::attempt($data)) {
            throw new \Exception('Invalid credentials');
        }

        $user = auth()->user();
        $permissions = $user->getAllPermissions()->pluck('name');

        return [
            'user' => $user,
            'permissions' => $permissions,
            'token' => $token,
        ];
    }

    public function refresh()
    {
        return [
            'token' => JWTAuth::refresh(),
        ];
    }

    public function me()
    {
        return JWTAuth::user();
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return [
            'message' => 'Successfully logged out'
        ];
    }
}
