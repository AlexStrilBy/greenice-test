<?php

use App\Http\ExchangeRequests\Controllers\ExchangeRequestsController;
use App\Http\Users\Controllers\UserInfoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth.basic']], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/info', [UserInfoController::class, 'show']);
    });

    Route::group(['prefix' => 'exchange-requests'], function () {
        Route::get('/', [ExchangeRequestsController::class, 'index']);
        Route::post('/', [ExchangeRequestsController::class, 'create']);
    });
});
