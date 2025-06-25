<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Routes for login and register
    |--------------------------------------------------------------------------
    */
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'checkExpiredToken'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
});

/*
|--------------------------------------------------------------------------
| Routes for verify email
|--------------------------------------------------------------------------
*/
Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify'])->middleware(['signed'])->name('verification.verify');


Route::middleware('auth:api')->group(function () {
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Routes for verify email
    |--------------------------------------------------------------------------
    */
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link sent!']);
    })->middleware(['throttle:6,1'])->name('verification.send');

    Route::get('/user', [UserController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Routes for role
    |--------------------------------------------------------------------------
    */
    Route::get('/role', [RoleController::class, 'index']);
    Route::post('/assign-role/{userId}', [RoleController::class, 'assignRole']);

    /*
    |--------------------------------------------------------------------------
    | Routes for category
    |--------------------------------------------------------------------------
    */
    Route::get('/category', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{category}', [CategoryController::class, 'show']);
    Route::put('/category/{category}', [CategoryController::class, 'update']);
    Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Routes for product
    |--------------------------------------------------------------------------
    */
    Route::get('/product', [ProductController::class, 'index']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/product/{product}', [ProductController::class, 'show']);
    Route::put('/product/{product}', [ProductController::class, 'update']);
    Route::delete('/product/{product}', [ProductController::class, 'destroy']);
});
