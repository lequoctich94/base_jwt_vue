<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TestAccessController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
    'middleware' => 'api',
], function () {
    // Route::post('register', [AuthController::class, 'register'])->name('api.auth.register');
    // Route::post('register-verify', [AuthController::class, 'registerVerify'])->name('api.auth.register_verify');
    Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('api.auth.forgot_password');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('api.auth.reset_password');
    Route::get('refresh', [AuthController::class, 'refresh'])->name('api.auth.refresh');
    Route::group([
        // 'middleware' => ['token'], 'email_verified'],
        'middleware' => ['token'],
    ], function () {
        Route::get('me', [AuthController::class, 'me'])->name('api.auth.me');
        Route::post('logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('change-password', [AuthController::class, 'changePassword'])->name('api.auth.change_password');
    });
});

Route::group([
    'middleware' => ['api', 'token', 'access'],
], function () {
    Route::get('/test_login', [TestAccessController::class, 'index']);
});