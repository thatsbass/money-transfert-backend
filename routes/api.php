<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;



Route::post('/register-client', [UserController::class, 'registerClient']);
Route::post('/OTP-veriefied', [UserController::class, 'completeRegistration']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api', 'blacklist'])->group(function () {
Route::post('/transfers/initiate', [TransferController::class, 'initiate']);
Route::post('/transfers/confirm/{key}', [TransferController::class, 'confirm']);
Route::post('/transfers/cancel/{key}', [TransferController::class, 'cancel']);
Route::get('/transfers/{accountId}/history', [TransferController::class, 'history']);

Route::get('/me', [AuthController::class, 'currentUserInfos']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::get('/getClientInfos/{id}', [ClientController::class, 'getClientInfos']);
  // autres routes protégées
});
