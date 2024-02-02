<?php

use App\Http\Controllers\AdminModul;
use App\Http\Controllers\AdminUserManagement;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserSettingController;
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
Route::post('/logout', [AuthenticatedController::class, 'logout']);

Route::middleware('auth')->group(function () {
    // dashboard route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // user setting route
    Route::get('/user-setting', [UserSettingController::class, 'profile'])->name('user_setting');
    Route::post('/user-setting/update', [UserSettingController::class, 'update'])->name('user_setting.update');
    Route::post('/user-setting/password-update', [UserSettingController::class, 'passwordUpdate'])->name('user_setting.password_update');
    Route::post('/user-setting/user-log', [UserSettingController::class, 'userLog'])->name('user_setting.password_update');

    // user management route



    // master data physical hazard route
    Route::prefix('physical-hazard')->group(function () {
        Route::get('/');
    });

    // super admin route
    // user management
    Route::get('/users-management', [AdminUserManagement::class, 'index'])->name('admin_user_management');
    Route::post('/users-management', [AdminUserManagement::class, 'tableData']);
    Route::post('/users-management/user-registration', [AdminUserManagement::class, 'registerUser']);
    Route::post('/users-management/user-active', [AdminUserManagement::class, 'changeActiveUser']);
    Route::get('/users-management/edit-user/{id}', [AdminUserManagement::class, 'editUserData'])->name('admin_user_management.edit');
    Route::patch('/users-management/edit-user/{id}', [AdminUserManagement::class, 'updateUserData']);
    Route::get('/users-management/change-password/{id}', [AdminUserManagement::class, 'changePassword'])->name('admin_user_management.change_password');
    Route::patch('/users-management/change-password/{id}', [AdminUserManagement::class, 'updatePassword']);

    // module management
    Route::get('/module-management', [AdminModul::class, 'index'])->name('admin_module');
    Route::post('/module-management', [AdminModul::class, 'tableData']);
    Route::post('/module-management/registration', [AdminModul::class, 'store']);
    Route::get('/module-management/edit/{id}', [AdminModul::class, 'edit'])->name('admin_module.edit');
    Route::patch('/module-management/edit/{id}', [AdminModul::class, 'update']);
});
