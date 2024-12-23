<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseTrait;

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->access_token = JWTAuth::fromUser($user);

        return self::successResponse('must_verify', UserResource::make($user));
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('phone', 'password');

        try {
            if (!JWTAuth::attempt($credentials)) {
                return self::failResponse(422, 'Invalid phone or Password');
            }

            $user = auth()->user();
            $user->access_token = JWTAuth::fromUser($user);

            return self::successResponse('login successfully', UserResource::make($user));
        } catch (JWTException $e) {
            return self::failResponse(500, 'Could not create token');
        }
    }


    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return self::successResponse('log_out');
    }

}
