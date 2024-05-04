<?php

use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductFileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Route::middleware('api')->group(
    function () {

        Route::middleware(['auth:sanctum'])->group(
            function () {
                Route::apiResource('products', ProductController::class)->except(['create', 'edit', 'show']);
                Route::post('file', [ProductFileController::class, 'store'])->name('product.file');
                Route::apiResource('order', OrdersController::class)->except(['create', 'edit', 'show']);

                Route::get('me', [UserController::class, 'show'])->name('me.show');
                Route::post('logout', [LogoutController::class, 'destroy'])->name('logout');
            }
        );

        Route::middleware('guest')->group(
            function () {
                Route::post('login', [LoginController::class, 'store'])->name('login');
                Route::post('register', [RegisterController::class, 'store'])->name('register');
            }
        );
    }
);
