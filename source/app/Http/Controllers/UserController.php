<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Filter\UserFilter;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 회원 목록 리스트
     * @param  UserFilter  $filter
     * @return JsonResponse
     */
    public function index(UserFilter $filter):JsonResponse
    {
        return $this->userService->index(User::Filter($filter));
    }


    /**
     * 단일 회원 상세 정보 조회
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user):JsonResponse
    {
        return makeJson($user);
    }
}
