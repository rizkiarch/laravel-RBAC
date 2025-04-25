<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $data)
    {
        if (!$token = JWTAuth::attempt($data)) {
            return response()->json(['error' => 'Failed! Check Email or Password Again'], 401);
        }

        return [
            'user' => auth()->user(),
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
