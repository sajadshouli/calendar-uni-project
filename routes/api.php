<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Task\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->name("api.v1.")->group(function () {

    Route::prefix('/auth')->name('auth.')->group(function () {
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
    });

    //
    Route::middleware('auth:api')->group(function () {

        Route::prefix('tasks')->name("tasks.")->group(function () {
            Route::post('/', [TaskController::class, 'store'])->name('store');
            Route::get('/', [TaskController::class, 'index'])->name('index');
            Route::get('/{task}', [TaskController::class, 'show'])->name('show');
            Route::post('/{task}/complete', [TaskController::class, 'complete'])->name('complete');
            Route::get('/items/{id}/check', [TaskController::class, 'check'])->name('check');
            Route::get('/items/{id}/uncheck', [TaskController::class, 'uncheck'])->name('uncheck');
        });
    });

    //
});
