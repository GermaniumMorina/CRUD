<?php

use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\AuthCustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthCustomerController::class, 'register']);
Route::post('/login', [AuthCustomerController::class, 'login']);
Route::get('/V1/customers', [CustomerController::class, 'index']);
Route::get('/V1/customers/{id}', [CustomerController::class, 'show']);
//protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
Route::post('/V1/customers', [CustomerController::class, 'store']);
Route::put('/V1/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/V1/customers/{id}', [CustomerController::class, 'destroy']);
Route::post('/logout', [AuthCustomerController::class, 'logout']);
});
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie has been set']);
})->middleware('web');
