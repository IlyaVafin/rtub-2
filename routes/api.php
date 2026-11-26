<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [UserController::class, 'registration']);
Route::post('/authorization', [UserController::class, 'login']);
Route::get("/me", [UserController::class, 'me']);
Route::get("/videos", [\App\Http\Controllers\VideoController::class, 'index']);
Route::post("/videos", [\App\Http\Controllers\VideoController::class, 'store']);
Route::patch("/videos/{video}", [\App\Http\Controllers\VideoController::class, 'update']);
Route::delete("/videos/{video}", [\App\Http\Controllers\VideoController::class, 'destroy']);

