<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PageController;


// welcome page
Route::get('/', [PageController::class, 'index'])->name('welcome');

// phpinfo
Route::get('/info', [PageController::class, 'info'])->name('info');
