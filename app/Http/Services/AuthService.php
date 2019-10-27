<?php

namespace App\Http\Services;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function register(RegisterUserRequest $request) {
        $userData = $request->validated();
        $userData['password'] = bcrypt($userData['password']);

        $createdUser = User::create($userData);

        $token = $createdUser->createToken('token')->accessToken;

        return response()->json(['user' => $createdUser, 'token' => $token], 201);
    }
}