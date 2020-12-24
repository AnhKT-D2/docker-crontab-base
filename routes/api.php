<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
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

Route::post('/sign-in', [AuthController::class, 'signIn'])->name('signIn');
Route::post('sign-up', [AuthController::class, 'signUp'])->name('signUp');
Route::get('/send-mail', [AuthController::class, 'sendMail'])->name('sendMail');
Route::get('/send-multi-mail', [AuthController::class, 'sendMultiMail'])->name('sendMultiMail');
Route::post('/reset-password', [AuthController::class, 'sendPasswordResetLink']);
Route::put('/reset-password/{token}', [AuthController::class, 'resetPassword']);
Route::get('/auth/google/url', [SocialController::class, 'googleUrl']);
Route::get('/auth/google/callback', [SocialController::class, 'googleCallback']);
Route::get("/test", [UserController::class, 'exportExcel']);

Route::middleware('auth:api')->group(function () {
    Route::get('account', [AuthController::class, 'account'])->name('account');
    Route::prefix("users")->group(function() {
        Route::get("/", [UserController::class, 'lists'])->name('users.list');
        Route::post("/", [UserController::class, 'store'])->name('users.create');
        Route::delete("/{id}", [UserController::class, 'destroy'])->name('users.delete');
        Route::put("/{id}", [UserController::class, 'update'])->name('users.update');
        Route::get("/{id}", [UserController::class, 'show'])->name('users.show');

    });

    Route::prefix('notifications')->group(function() {
        Route::post('save-device-token', [NotificationController::class, 'saveDeviceToken'])->name('saveDeviceToken');
    });
});

