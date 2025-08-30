<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->authService->register($request->validated());
            return $this->successResponse($result, 'User registered successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Registration failed', 500, ['error' => $th->getMessage()]);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->validated());
            return $this->successResponse($result, 'User logged in successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Login failed', 401, ['error' => $th->getMessage()]);
        }
    }

    public function refresh()
    {
        try {
            $result = $this->authService->refresh();
            return $this->successResponse($result, 'Token refreshed successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Token refresh failed', 500, ['error' => $th->getMessage()]);
        }
    }

    public function me()
    {
        try {
            $result = $this->authService->me();
            return $this->successResponse($result, 'User data retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Failed to retrieve user data', 500, ['error' => $th->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            $result = $this->authService->logout();
            return $this->successResponse($result, 'User logged out successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Logout failed', 500, ['error' => $th->getMessage()]);
        }
    }
}
