<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\Interfaces\UserAuthenticationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    protected UserAuthenticationInterface $authRepository;

    public function __construct(UserRepositoryInterface $userRepository, UserAuthenticationInterface $authRepository)
    {
        $this->userRepository = $userRepository;
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authRepository->login($credentials);

        if (is_string($token)) {
            return response()->json(compact('token'));
        }

        return $token;
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $token = $request->header('Authorization', '');

            if (strpos($token, 'Bearer ') === 0) {
                $token = substr($token, 7);
            }

            if ($this->authRepository->logout($token)) {
                return response()->json(['message' => 'Successfully logged out'], 200);
            }

            return response()->json(['error' => 'Could not invalidate token'], 500);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not invalidate token'], 500);
        }
    }

    public function getUser(): JsonResponse
    {
        $user = $this->userRepository->getUser();

        return response()->json(compact('user'));
    }
}
