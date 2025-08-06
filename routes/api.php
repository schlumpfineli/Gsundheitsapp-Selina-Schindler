<?php


use Illuminate\Support\Facades\Route;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\MedicationController;
use App\Controllers\UploadsController;

// guest endpoints
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/user', [UserController::class, 'create']);
Route::get('/medications', [MedicationController::class, 'index']);
Route::get('/medications/search', [MedicationController::class, 'search']);
Route::get('/uploads/{id}', [UploadsController::class, 'show']);


// user endpoints
Route::middleware(['auth:sanctum'])->group(function () {
  Route::post('/auth/logout', [AuthController::class, 'logout']);

  Route::get('/user', [UserController::class, 'index']);
  Route::patch('/user', [UserController::class, 'update']);
  Route::delete('/user', [UserController::class, 'destroy']);

  Route::post('/medications', [MedicationController::class, 'create']);
  Route::patch('/medications', [MedicationController::class, 'update']);
  Route::delete('/medications', [MedicationController::class, 'destroy']);


  Route::get('/uploads', [UploadsController::class, 'index']);
  Route::post('/uploads', [UploadsController::class, 'create']);
  Route::patch('/uploads', [UploadsController::class, 'update']);
  Route::delete('/uploads', [UploadsController::class, 'destroy']);
});
