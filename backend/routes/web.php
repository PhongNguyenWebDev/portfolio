<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('api/users', [homeController::class, 'index']);
