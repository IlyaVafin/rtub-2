<?php

use Illuminate\Support\Facades\Route;

Route::prefix('rtub_admin')->group(function () {
   Route::get('/', [\App\Http\Controllers\AdminController::class, 'index']);
   Route::get('/videos', [\App\Http\Controllers\AdminController::class, 'videos']);
   Route::post('/videos/{video}/approve', [\App\Http\Controllers\AdminController::class, 'approve']);
   Route::post('/videos/{video}/reject', [\App\Http\Controllers\AdminController::class, 'reject']);
});
