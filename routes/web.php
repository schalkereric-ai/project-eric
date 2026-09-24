<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TestController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Registratie
|--------------------------------------------------------------------------
*/

Route::view('/registreren', 'auth.register');

Route::post('/registreren', [RegisterController::class, 'store'])
    ->middleware('throttle:registration');


/*
|--------------------------------------------------------------------------
| Inloggen / uitloggen
|--------------------------------------------------------------------------
*/

Route::get('/inloggen', [LoginController::class, 'create'])
    ->name('login');

Route::post('/inloggen', [LoginController::class, 'store']);

Route::post('/uitloggen', [LoginController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| Wachtwoord resetten
|--------------------------------------------------------------------------
*/

Route::get(
    '/wachtwoord-vergeten',
    [ForgotPasswordController::class, 'create']
);

Route::post(
    '/wachtwoord-vergeten',
    [ForgotPasswordController::class, 'store']
);

Route::get(
    '/wachtwoord-resetten/{token}',
    [ResetPasswordController::class, 'create']
);

Route::post(
    '/wachtwoord-resetten',
    [ResetPasswordController::class, 'store']
);


/*
|--------------------------------------------------------------------------
| Ingelogde accountfuncties
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
     * Profiel
     */

    Route::get(
        '/profiel',
        [ProfileController::class, 'show']
    )->name('profile.show');

    Route::put(
        '/profiel',
        [ProfileController::class, 'update']
    )->name('profile.update');


    /*
     * Wachtwoord wijzigen
     */

    Route::get(
        '/wachtwoord-wijzigen',
        [ChangePasswordController::class, 'create']
    )->name('password.change');

    Route::put(
        '/wachtwoord-wijzigen',
        [ChangePasswordController::class, 'update']
    )->name('password.update');

});