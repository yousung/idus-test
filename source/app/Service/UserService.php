<?php

declare(strict_types=1);

namespace App\Service;

use App\Http\Resources\UserResource;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;

class UserService
{
    /**
     * 회원 검색 필터
     * @param $builder
     * @return JsonResponse
     */
    public function index($builder):JsonResponse
    {
        return response()->json(
            UserResource::collection(
                $builder->simplePaginate(
                    request('limit', 15),
                    ['id', 'name', 'nickname', 'phone', 'email', 'gender']
                )
            )
        );
    }
}
