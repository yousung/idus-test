<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

// 회원가입
Route::get('join', [AuthController::class, 'join'])->name('auth.join');

// 로그인
Route::get('login', [AuthController::class, 'login'])->name('auth.login');
// 로그인 회원 단일 정보
Route::get('me', [AuthController::class, 'me'])->name('auth.me');

// 로그아웃
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
