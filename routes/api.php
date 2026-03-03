<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('auth/register', [RegistreController::class, 'register']);
Route::post('auth/login', [LoginController::class, 'login']);


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/users/{id}/activate', [UserController::class, 'activate']);
});