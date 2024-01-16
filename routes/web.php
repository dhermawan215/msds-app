<?php

use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// auth route
Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');
Route::post('/login', [AuthenticatedController::class, 'authenticated']);

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

// master data physical hazard route
Route::prefix('physical-hazard')->group(function () {
    Route::get('/');
});
