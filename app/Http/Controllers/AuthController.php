<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller {
    public function register(RegisterRequest $request) {
        try {
            $request->validated();

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            $token = auth()->attempt($request->only('email', 'password'));

            $user->token = $token;

            return ApiResponse::success(201, 'CREATED', $user);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error(500, 'INTERNAL SERVER ERROR', $th->getMessage());
        }
    }

    public function login(LoginRequest $request) {
        try {
            $request->validated();

            if (!$token = auth()->attempt($request->only('email', 'password'))) {
                return ApiResponse::error(401, 'UNAUTHORIZED', 'Invalid credentials');
            }

            $user = auth()->user();

            $user->token = $token;

            return ApiResponse::success(200, 'OK', $user);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error(500, 'INTERNAL SERVER ERROR', $th->getMessage());
        }
    }

    public function logout() {
        try {
            auth()->logout();

            return ApiResponse::success(204, 'NO CONTENT');
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error(500, 'INTERNAL SERVER ERROR', $th->getMessage());
        }
    }
}
