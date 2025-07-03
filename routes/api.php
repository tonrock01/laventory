<?php

use App\Http\Controllers\API\ActivitylogsController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\StockLogController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
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


Route::middleware(['auth:api', 'verified'])->group(function () {
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

    Route::group(['middleware' => ['role:admin']], function () {
        /*
        |--------------------------------------------------------------------------
        | Routes for user
        |--------------------------------------------------------------------------
        */
        Route::get('/user', [UserController::class, 'index']);

        /*
        |--------------------------------------------------------------------------
        | Routes for category
        |--------------------------------------------------------------------------
        */
        Route::post('/category', [CategoryController::class, 'store']);
        Route::put('/category/{category}', [CategoryController::class, 'update']);
        Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Routes for role
        |--------------------------------------------------------------------------
        */
        Route::get('/role', [RoleController::class, 'index']);
        Route::post('/assign-role/{userId}', [RoleController::class, 'assignRole']);

        /*
        |--------------------------------------------------------------------------
        | Routes for product
        |--------------------------------------------------------------------------
        */
        Route::post('/product', [ProductController::class, 'store']);
        Route::put('/product/{product}', [ProductController::class, 'update']);
        Route::delete('/product/{product}', [ProductController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Routes for activity logs
        |--------------------------------------------------------------------------
        */
        Route::get('/activity-logs', [ActivitylogsController::class, 'index']);
    });

    Route::group(['middleware' => ['role:admin|staff']], function () {
        /*
        |--------------------------------------------------------------------------
        | Routes for category
        |--------------------------------------------------------------------------
        */
        Route::get('/category', [CategoryController::class, 'index']);
        Route::get('/category/{category}', [CategoryController::class, 'show']);


        /*
        |--------------------------------------------------------------------------
        | Routes for product
        |--------------------------------------------------------------------------
        */
        Route::get('/product', [ProductController::class, 'index']);
        Route::get('/product/{product}', [ProductController::class, 'show']);


        /*
        |--------------------------------------------------------------------------
        | Routes for stock_log
        |--------------------------------------------------------------------------
        */
        Route::get('/stock-log', [StockLogController::class, 'index']);
        Route::post('/stock/in', [StockLogController::class, 'stockIn']);
        Route::post('/stock/out', [StockLogController::class, 'stockOut']);
        Route::get('/product/{product}/stock-log', [StockLogController::class, 'productLogs']);
    });
});
