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
            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        }
    }

    public function login(array $data)
    {
        if (!$token = JWTAuth::attempt($data)) {
            return response()->json(['error' => 'Failed! Check Email or Password Again'], 401);
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
        return response()->json(['message' => 'Successfully logged out']);
    }
}
