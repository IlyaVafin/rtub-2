<?php

use App\Http\Controllers\DonateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [UserController::class, 'registration']);
Route::post('/authorization', [UserController::class, 'login']);
Route::get("/videos", [\App\Http\Controllers\VideoController::class, 'index']);
Route::get("/videos/{video}", [VideoController::class, 'show']);
Route::middleware('bearer')->group(function () {
    Route::get("/me", [UserController::class, 'me']);
    Route::post("/videos", [\App\Http\Controllers\VideoController::class, 'store']);
    Route::patch("/videos/{video}", [\App\Http\Controllers\VideoController::class, 'update']);
    Route::delete("/videos/{video}", [\App\Http\Controllers\VideoController::class, 'destroy']);
    Route::post("/channels/{nickname}", [DonateController::class, 'store']);
    Route::post('/payment-webhook', [DonateController::class, 'updateStatus']);
});
