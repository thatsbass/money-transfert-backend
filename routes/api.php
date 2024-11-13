<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;


// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
// Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
// Route::get('/getClientInfos/{id}', [ClientController::class, 'getClientInfos'])->middleware('auth:api');

Route::post('/register-client', [UserController::class, 'registerClient']);
Route::post('/OTP-veriefied', [UserController::class, 'completeRegistration']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/gen', [UserController::class, 'generate']);

Route::middleware(['auth:api', 'blacklist'])->group(function () {
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/refresh', [AuthController::class, 'refresh']);
  Route::get('/getClientInfos/{id}', [ClientController::class, 'getClientInfos']);
  // autres routes protégées
});
