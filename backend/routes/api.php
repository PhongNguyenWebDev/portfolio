<?php

use Illuminate\Support\Facades\Route;
// ADMIN
use App\Http\Controllers\Api\V1\Admin\AboutMeController;
use App\Http\Controllers\Api\V1\Admin\WorkExController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Admin\SliderController;
use App\Http\Controllers\Api\V1\Admin\IconController;
use App\Http\Controllers\Api\V1\Admin\ProfileController;
use App\Http\Controllers\Api\V1\Admin\SkillController;
use App\Http\Controllers\Api\V1\Admin\GeneralController;
use App\Http\Controllers\Api\V1\Admin\ProjectController;

Route::prefix('v1')->group(function () {
    // Register and Login
    Route::get('about-me', [AboutMeController::class, 'index']);
    Route::get('work-ex', [WorkExController::class, 'index']);
    Route::get('icons', [IconController::class, 'index']);
    Route::get('sliders', [SliderController::class, 'index']);
    Route::get('downloadCV/{id}', [SliderController::class, 'downloadCV']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/auth/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
    // Routes that require authentication
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Admin routes with prefix 'admin'
        Route::prefix('/admin')->group(function () {
            // Define multiple resources using apiResources
            Route::apiResources([
                '/sliders' => SliderController::class,
                '/about-me' => AboutMeController::class,
                '/icons' => IconController::class,
                '/profiles' => ProfileController::class,
                '/skills' => SkillController::class,
                '/work-experience' => WorkExController::class,
                '/generals' => GeneralController::class,
                '/projects' => ProjectController::class,
            ]);
            // Download CV
            Route::get('/download-cv/{id}', [SliderController::class, 'downloadCV']);
        });
    });

    // Forgot and reset password routes

});
