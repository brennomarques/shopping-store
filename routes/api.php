<?php

use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductFileController;
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
        Route::apiResource('products', ProductController::class)->except(['create', 'edit', 'show']);
        Route::post('file', [ProductFileController::class, 'store'])->name('product.file');
    }
);
