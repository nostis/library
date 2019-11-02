<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterClientRequest;
use App\Http\Requests\RegisterLibrarianRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function registerAdmin(RegisterAdminRequest $request) {
        return $this->authService->registerAdmin($request);
    }

    public function registerLibrarian(RegisterLibrarianRequest $request) {
        return $this->authService->registerLibrarian($request);
    }

    public function registerClient(RegisterClientRequest $request) {
        return $this->authService->registerClient($request);
    }

    public function login(LoginUserRequest $request) {
        return $this->authService->login($request);
    }
}
