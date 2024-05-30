<?php

use App\Http\Controllers\AdminModul;
use App\Http\Controllers\AdminPermissionControlller;
use App\Http\Controllers\AdminUserManagement;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnvironmentalHazardController;
use App\Http\Controllers\GeneralPresController;
use App\Http\Controllers\HealthHazardController;
use App\Http\Controllers\PhysicalHazardController;
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
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticatedController::class, 'authenticated']);
});

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect('/');
    });
    Route::post('/logout', [AuthenticatedController::class, 'logout']);
    // dashboard route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // user setting route
    Route::get('/user-setting', [UserSettingController::class, 'profile'])->name('user_setting');
    Route::post('/user-setting/update', [UserSettingController::class, 'update'])->name('user_setting.update');
    Route::post('/user-setting/password-update', [UserSettingController::class, 'passwordUpdate'])->name('user_setting.password_update');
    Route::post('/user-setting/user-log', [UserSettingController::class, 'userLog'])->name('user_setting.password_update');

    // master data physical hazard route
    Route::get('/physical-hazard', [PhysicalHazardController::class, 'index'])->name('physical_hazard');
    Route::post('/physical-hazard', [PhysicalHazardController::class, 'tableData']);
    Route::get('/physical-hazard/add', [PhysicalHazardController::class, 'add'])->name('physical_hazard.add');
    Route::post('/physical-hazard/save', [PhysicalHazardController::class, 'store']);
    Route::get('/physical-hazard/detail/{id}', [PhysicalHazardController::class, 'detail'])->name('physical_hazard.detail');
    Route::get('/physical-hazard/edit/{id}', [PhysicalHazardController::class, 'edit'])->name('physical_hazard.edit');
    Route::patch('/physical-hazard/update/{id}', [PhysicalHazardController::class, 'update']);
    Route::delete('/physical-hazard/delete/{id}', [PhysicalHazardController::class, 'delete']);

    // master data health hazard route
    Route::get('/health-hazard', [HealthHazardController::class, 'index'])->name('health_hazard');
    Route::post('/health-hazard/list', [HealthHazardController::class, 'listData']);
    Route::get('/health-hazard/add', [HealthHazardController::class, 'add'])->name('health_hazard.add');
    Route::post('/health-hazard/save', [HealthHazardController::class, 'store']);
    Route::get('/health-hazard/detail/{id}', [HealthHazardController::class, 'detail'])->name('health_hazard.detail');
    Route::get('/health-hazard/edit/{id}', [HealthHazardController::class, 'edit'])->name('health_hazard.edit');
    Route::patch('/health-hazard/update/{id}', [HealthHazardController::class, 'update']);
    Route::delete('/health-hazard/delete/{id}', [HealthHazardController::class, 'delete']);

    // master data health hazard route
    Route::get('/environmental-hazard', [EnvironmentalHazardController::class, 'index'])->name('environmental_hazard');
    Route::post('/environmental-hazard/list', [EnvironmentalHazardController::class, 'listData']);
    Route::get('/environmental-hazard/add', [EnvironmentalHazardController::class, 'add'])->name('environmental_hazard.add');
    Route::post('/environmental-hazard/save', [EnvironmentalHazardController::class, 'store']);
    Route::post('/environmental-hazard/delete', [EnvironmentalHazardController::class, 'delete']);
    Route::get('/environmental-hazard/edit/{id}', [EnvironmentalHazardController::class, 'edit'])->name('environmental_hazard.edit');
    Route::patch('/environmental-hazard/update/{id}', [EnvironmentalHazardController::class, 'update']);
    Route::get('/environmental-hazard/detail/{id}', [EnvironmentalHazardController::class, 'detail'])->name('environmental_hazard.detail');
    // master data general precautionary statemnet
    Route::get('/general-precautionary', [GeneralPresController::class, 'index'])->name('general_precautionary');
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

    // admin permission management
    Route::get('/permission-management', [AdminPermissionControlller::class, 'index'])->name('admin_permission');
    Route::post('/permission-management', [AdminPermissionControlller::class, 'tableData']);
    Route::get('/permission-management/add/{id}', [AdminPermissionControlller::class, 'add'])->name('admin_permission.add');
    Route::post('/permission-management/save', [AdminPermissionControlller::class, 'store']);
    Route::get('/permission-management/edit/{id}', [AdminPermissionControlller::class, 'edit'])->name('admin_permission.edit');
    Route::post('/permission-management/permission', [AdminPermissionControlller::class, 'dataEdit']);
    Route::post('/permission-management/permission/update', [AdminPermissionControlller::class, 'update']);
});
