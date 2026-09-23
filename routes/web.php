<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TestController::class, 'index']);

Route::view('/registreren', 'auth.register');

Route::post('/registreren', [RegisterController::class, 'store'])
    ->middleware('throttle:registration');

Route::get('/inloggen', [LoginController::class, 'create']);

Route::post('/inloggen', [LoginController::class, 'store']);

Route::post('/uitloggen', [LoginController::class, 'destroy']);