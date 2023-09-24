<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    public function login(LoginRequest $loginRequest): \Illuminate\Http\JsonResponse
    {
        $result = $this->auth_service->register($loginRequest);

        return response()->json($result);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()?->token()?->revoke();
        return response()->json(
            [
                'error' => null,
                'result' => ['message' => 'Successfully logged out']
            ]
        );
    }
}
