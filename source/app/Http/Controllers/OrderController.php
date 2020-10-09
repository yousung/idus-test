<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 단일 회원 주문 목록 조회
     * @param  User  $user
     * @return JsonResponse
     */
    public function index(User $user):JsonResponse
    {
        return makeJson(['orders' => $user->orders]);
    }
}
