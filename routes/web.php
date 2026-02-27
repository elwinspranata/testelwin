<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index']);
Route::post('/task/store', [TaskController::class, 'store']);
Route::get('/task/edit/{id}', [TaskController::class, 'edit']);
Route::post('/task/update/{id}', [TaskController::class, 'update']);
Route::get('/task/start/{id}', [TaskController::class, 'start']);
Route::get('/task/end/{id}', [TaskController::class, 'end']);
Route::get('/task/delete/{id}', [TaskController::class, 'delete']);