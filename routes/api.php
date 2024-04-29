<?php

use App\Http\Controllers\api\ProdutController;
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
        Route::apiResource('products', ProdutController::class)->except(['create', 'edit', 'show']);
    }
);
