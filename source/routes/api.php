<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\OrderController;

// 회원목록 리스트
Route::get('users', [UserController::class, 'index'])->name('user.index');

// 단일 회원 정보
Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');

// 단일 회원 주문 내역 리스트
Route::get('user/{user}/orders', [OrderController::class, 'index'])->name('user.order.index');
