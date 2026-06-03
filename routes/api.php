<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::group(['prefix'=>'auth'], function ($router){
    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
});

Route::middleware(['jwt.custom'])->group(function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('profile', [AuthController::class,'profile']);

    // Route for Books
    Route::post('/books',[BookController::class,'store']);
    Route::get('/books',[BookController::class,'index']);
    Route::get('/books/{id}',[BookController::class,'show']);
    Route::put('/books/{id}',[BookController::class,'update']);
    Route::delete('/books/{id}',[BookController::class,'destroy']);
});
