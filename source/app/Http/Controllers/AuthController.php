<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\JoinRequest;
use App\Service\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api')->only(['logout', 'me']);
    }

    /**
     * 로그인
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request->credentials());
    }

    /**
     * 회원가입
     * @param  JoinRequest  $request
     * @return JsonResponse
     */
    public function join(JoinRequest $request):JsonResponse
    {
        return $this->authService->join($request->all());
    }

    /**
     * 로그인 회원 정보
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->authService->me();
    }

    /**
     * 로그아웃
     * @return JsonResponse
     */
    public function logout():JsonResponse
    {
        return $this->authService->logout();
    }
}
