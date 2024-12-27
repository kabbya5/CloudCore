<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::controller(AuthController::class)->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/login', 'login');
    Route::post('/verify-code/{user}','verifyEmail');
    Route::post('/resend-code/{id}', 'resendCode');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [AuthController::class,'logout']);


    Route::controller(TaskController::class)->group(function(){
        Route::get('tasks', 'index');
        Route::post('tasks', 'store');
        Route::get('tasks/{task}', 'show');
        Route::put('tasks/{task}', 'update');
        Route::get('/users', 'getUsers');
        Route::delete('tasks/{task}' , 'delete');
    });
});
