<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\OrderController;

Route::get('users', [UserController::class, 'index'])->name('user.index');
Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('user/{user}/orders', [OrderController::class, 'index'])->name('user.order.index');
