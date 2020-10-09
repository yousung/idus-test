<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthService
{
    /**
     * 로그인
     * @param $loginData
     * @return JsonResponse
     */
    public function login($loginData):JsonResponse
    {
        if (!$token = auth()->attempt($loginData)) {
            return makeJson(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * 회원가입
     * @param $joinData
     * @return JsonResponse
     */
    public function join($joinData)
    {
        $user =  User::create($joinData);

        return makeJson($user, 201);
    }


    /**
     * 로그아웃
     * @return JsonResponse
     */
    public function logout():JsonResponse
    {
        auth()->logout();
        return makeJson('Successfully logged out');
    }


    /**
     * 로그인 회원 정보 확인
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return makeJson(auth()->user());
    }


    /**
     * JWT TOKEN Form
     * @param  string  $token
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return makeJson([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
