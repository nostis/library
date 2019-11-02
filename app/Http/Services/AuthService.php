<?php

namespace App\Http\Services;

use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\RegisterAdminRequest;
use App\Http\Requests\User\RegisterLibrarianRequest;
use App\Http\Requests\User\RegisterClientRequest;

class AuthService {
    public function login(LoginUserRequest $request) {
        $userData = $request->validated();

        if(!Auth::attempt($userData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        else {
            $token = Auth::user()->createToken('token')->accessToken;

            return response()->json(['token' => $token]);
        }
    }

    public function registerAdmin(RegisterAdminRequest $request) {
        $user = $this->register($request->validated(), 'Admin');

        return response()->json(['user' => $user, 'token' => $user->accessToken], 201);
    }

    public function registerLibrarian(RegisterLibrarianRequest $request) {
        $user = $this->register($request->validated(), 'Librarian');

        return response()->json(['user' => $user, 'token' => $user->accessToken], 201);
    }

    public function registerClient(RegisterClientRequest $request) {
        $user = $this->register($request->validated(), 'Client');

        return response()->json(['user' => $user, 'token' => $user->accessToken], 201);
    }

    private function register(array $request, $role) {
        $request['password'] = bcrypt($request['password']);

        $createdUser = User::create($request);
        $createdUser->assignRole($role);
        $createdUser->createToken('token')->accessToken;

        return $createdUser;
    }
}