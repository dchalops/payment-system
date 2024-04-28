<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProviderController;
use App\Http\Controllers\API\ProviderAuthController;
use App\Http\Controllers\Payments\PaymentController;

use App\Http\Middleware\AuthenticateJWT;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('providers/login', [ProviderAuthController::class, 'login']);

Route::middleware([AuthenticateJWT::class])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::post('/payments/processPayment', [PaymentController::class, 'createPayment']);
    Route::get('/payments/{id}', [PaymentController::class, 'getPayment']);

});