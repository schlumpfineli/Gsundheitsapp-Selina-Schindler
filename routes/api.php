<?php


use Illuminate\Support\Facades\Route;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\CommentsController;
use App\Controllers\MedicationController;

// guest endpoints
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/user', [UserController::class, 'create']);

// user endpoints
Route::middleware(['auth:sanctum'])->group(function () {
  Route::post('/auth/logout', [AuthController::class, 'logout']);

  Route::get('/user', [UserController::class, 'index']);
  Route::patch('/user', [UserController::class, 'update']);
  Route::delete('/user', [UserController::class, 'destroy']);


  Route::get('/comments', [CommentsController::class, 'index']);
  Route::post('/comments', [CommentsController::class, 'create']);
  Route::patch('/comments', [CommentsController::class, 'update']);
  Route::delete('/comments', [CommentsController::class, 'destroy']);


  Route::get('/medications', [MedicationController::class, 'index']);
  Route::post('/medications', [MedicationController::class, 'create']);
  Route::patch('/medications', [MedicationController::class, 'update']);
  Route::delete('/medications', [MedicationController::class, 'destroy']);

  Route::get('/files', [FileController::class, 'index']);
  Route::post('/files', [FileController::class, 'create']);
  Route::patch('/files', [FileController::class, 'update']);
  Route::delete('/files', [FileController::class, 'destroy']);
});
