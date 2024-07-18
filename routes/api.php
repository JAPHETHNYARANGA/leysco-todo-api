<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'store'])->name('users.store');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('create', [TaskController::class, 'store']);
    Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
    Route::post('assign/tasks/{id}', [TaskController::class, 'assign']);
});