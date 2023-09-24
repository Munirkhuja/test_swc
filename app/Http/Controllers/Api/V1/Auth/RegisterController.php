<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class RegisterController extends Controller
{
    private AuthService $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    public function store(RegisterRequest $registerRequest): \Illuminate\Http\JsonResponse
    {
        $result = $this->auth_service->register($registerRequest);

        return response()->json($result);
    }
}
