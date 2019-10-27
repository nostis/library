<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request) {
        return $this->authService->register($request);
    }

    public function login(LoginUserRequest $request) {
        return $this->authService->login($request);
    }
}
