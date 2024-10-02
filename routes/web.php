<?php

use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\AdminModul;
use App\Http\Controllers\AdminPermissionControlller;
use App\Http\Controllers\AdminUserGroupController;
use App\Http\Controllers\AdminUserManagement;
use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnvironmentalHazardController;
use App\Http\Controllers\GeneralPresController;
use App\Http\Controllers\HealthHazardController;
use App\Http\Controllers\PhysicalHazardController;
use App\Http\Controllers\Pic\SampleRequestPicController;
use App\Http\Controllers\PreventionPresController;
use App\Http\Controllers\ResponsePresController;
use App\Http\Controllers\Rnd\ExtinguishingMediaController;
use App\Http\Controllers\Rnd\EyeContactController;
use App\Http\Controllers\Rnd\GhsController;
use App\Http\Controllers\Rnd\IngestionController;
use App\Http\Controllers\Rnd\InhalationController;
use App\Http\Controllers\Rnd\PmifController;
use App\Http\Controllers\Rnd\ProductController;
use App\Http\Controllers\Rnd\RiskPhrasesController;
use App\Http\Controllers\Rnd\SafetyPhrasesController;
use App\Http\Controllers\Rnd\SampleRequestRndController;
use App\Http\Controllers\Rnd\SampleSourceController;
use App\Http\Controllers\Rnd\SffpController;
use App\Http\Controllers\Rnd\SkinContactController;
use App\Http\Controllers\Rnd\SpesificHazardController;
use App\Http\Controllers\Rnd\StoragePresController;
use App\Http\Controllers\SampleRequestController;
use App\Http\Controllers\UnitController;
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
    Route::post('/general-precautionary/list', [GeneralPresController::class, 'listData']);
    Route::get('/general-precautionary/add', [GeneralPresController::class, 'add'])->name('general_precautionary.add');
    Route::post('/general-precautionary/save', [GeneralPresController::class, 'store']);
    Route::get('/general-precautionary/detail/{id}', [GeneralPresController::class, 'detail'])->name('general_precautionary.detail');
    Route::get('/general-precautionary/edit/{id}', [GeneralPresController::class, 'edit'])->name('general_precautionary.edit');
    Route::patch('/general-precautionary/update/{id}', [GeneralPresController::class, 'update']);
    Route::post('/general-precautionary/delete', [GeneralPresController::class, 'delete']);
    // master data prevention precautionary statemnet
    Route::get('/prevention-precautionary', [PreventionPresController::class, 'index'])->name('prevention_precautionary');
    Route::post('/prevention-precautionary/list', [PreventionPresController::class, 'listData']);
    Route::get('/prevention-precautionary/add', [PreventionPresController::class, 'add'])->name('prevention_precautionary.add');
    Route::post('/prevention-precautionary/save', [PreventionPresController::class, 'store']);
    Route::get('/prevention-precautionary/detail/{id}', [PreventionPresController::class, 'detail'])->name('prevention_precautionary.detail');
    Route::get('/prevention-precautionary/edit/{id}', [PreventionPresController::class, 'edit'])->name('prevention_precautionary.edit');
    Route::patch('/prevention-precautionary/update/{id}', [PreventionPresController::class, 'update']);
    Route::post('/prevention-precautionary/delete', [PreventionPresController::class, 'delete']);
    // master data response precautionary statemnet
    Route::get('/response-precautionary', [ResponsePresController::class, 'index'])->name('response_precautionary');
    Route::post('/response-precautionary/list', [ResponsePresController::class, 'listData']);
    Route::get('/response-precautionary/add', [ResponsePresController::class, 'add'])->name('response_precautionary.add');
    Route::post('/response-precautionary/save', [ResponsePresController::class, 'store']);
    Route::get('/response-precautionary/detail/{id}', [ResponsePresController::class, 'detail'])->name('response_precautionary.detail');
    Route::get('/response-precautionary/edit/{id}', [ResponsePresController::class, 'edit'])->name('response_precautionary.edit');
    Route::patch('/response-precautionary/update/{id}', [ResponsePresController::class, 'update']);
    Route::post('/response-precautionary/delete', [ResponsePresController::class, 'delete']);
    //storage precautionary
    Route::controller(StoragePresController::class)->group(function () {
        Route::get('/storage-precautionary', 'index')->name('storage_precautionary');
        Route::post('/storage-precautionary/list', 'listData');
        Route::post('/storage-precautionary/save', 'store');
        Route::post('/storage-precautionary/detail', 'detail');
        Route::get('/storage-precautionary/edit/{id}', 'edit')->name('storage_precautionary.edit');
        Route::post('/storage-precautionary/update', 'update');
        Route::post('/storage-precautionary/delete', 'destroy');
    });
    //# First aid measure
    //inhalation 
    Route::controller(InhalationController::class)->group(function () {
        Route::get('/inhalation', 'index')->name('inhalation');
        Route::post('/inhalation/list', 'listData');
        Route::post('/inhalation/save', 'store');
        Route::post('/inhalation/delete', 'destroy');
        Route::post('/inhalation/edit', 'edit');
        Route::post('/inhalation/update', 'update');
    });
    //ingestion 
    Route::controller(IngestionController::class)->group(function () {
        Route::get('/ingestion', 'index')->name('ingestion');
        Route::post('/ingestion/list', 'listData');
        Route::post('/ingestion/save', 'store');
        Route::post('/ingestion/delete', 'destroy');
        Route::post('/ingestion/edit', 'edit');
        Route::post('/ingestion/update', 'update');
    });
    //skin contact 
    Route::controller(SkinContactController::class)->group(function () {
        Route::get('/skin-contact', 'index')->name('skin_contact');
        Route::post('/skin-contact/list', 'listData');
        Route::post('/skin-contact/save', 'store');
        Route::post('/skin-contact/delete', 'destroy');
        Route::post('/skin-contact/edit', 'edit');
        Route::post('/skin-contact/update', 'update');
    });
    //eye contact 
    Route::controller(EyeContactController::class)->group(function () {
        Route::get('/eye-contact', 'index')->name('eye_contact');
        Route::post('/eye-contact/list', 'listData');
        Route::post('/eye-contact/save', 'store');
        Route::post('/eye-contact/delete', 'destroy');
        Route::post('/eye-contact/edit', 'edit');
        Route::post('/eye-contact/update', 'update');
    });
    // #FIRE FIIGHTING MEASURES
    // extinguishing media
    Route::controller(ExtinguishingMediaController::class)->group(function () {
        Route::get('/extinguishing-media', 'index')->name('extinguishing_media');
        Route::post('/extinguishing-media/list', 'listData');
        Route::post('/extinguishing-media/save', 'store');
        Route::post('/extinguishing-media/delete', 'destroy');
        Route::post('/extinguishing-media/edit', 'edit');
        Route::post('/extinguishing-media/update', 'update');
    });
    // special fire fighting procedures media
    Route::controller(SffpController::class)->group(function () {
        Route::get('/sffp', 'index')->name('sffp');
        Route::post('/sffp/list', 'listData');
        Route::post('/sffp/save', 'store');
        Route::post('/sffp/delete', 'destroy');
        Route::post('/sffp/edit', 'edit');
        Route::post('/sffp/update', 'update');
    });
    // spesific hazard
    Route::controller(SpesificHazardController::class)->group(function () {
        Route::get('/spesific-hazard', 'index')->name('spesific_hazard');
        Route::post('/spesific-hazard/list', 'listData');
        Route::post('/spesific-hazard/save', 'store');
        Route::post('/spesific-hazard/delete', 'destroy');
        Route::post('/spesific-hazard/edit', 'edit');
        Route::post('/spesific-hazard/update', 'update');
    });
    // protection measures in fire
    Route::controller(PmifController::class)->group(function () {
        Route::get('/pmif', 'index')->name('pmif');
        Route::post('/pmif/list', 'listData');
        Route::post('/pmif/save', 'store');
        Route::post('/pmif/delete', 'destroy');
        Route::post('/pmif/edit', 'edit');
        Route::post('/pmif/update', 'update');
    });
    //#REGULATORY INFORMATION
    // risk phrases
    Route::controller(RiskPhrasesController::class)->group(function () {
        Route::get('/risk-phrases', 'index')->name('risk_phrases');
        Route::post('/risk-phrases/list', 'listData');
        Route::post('/risk-phrases/save', 'store');
        Route::post('/risk-phrases/delete', 'destroy');
        Route::post('/risk-phrases/edit', 'edit');
        Route::post('/risk-phrases/update', 'update');
    });
    // safety phrases
    Route::controller(SafetyPhrasesController::class)->group(function () {
        Route::get('/safety-phrases', 'index')->name('safety_phrases');
        Route::post('/safety-phrases/list', 'listData');
        Route::post('/safety-phrases/save', 'store');
        Route::post('/safety-phrases/delete', 'destroy');
        Route::post('/safety-phrases/edit', 'edit');
        Route::post('/safety-phrases/update', 'update');
    });
    // super admin route start
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
    // super admin route end
    // sample request route start
    //# sales customer route start
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer', 'index')->name('customer');
        Route::post('/customer/list', 'listData');
        Route::post('/customer/save', 'store');
        Route::post('/customer/update', 'update');
        Route::post('/customer/delete', 'destroy');
        Route::get('/customer/customer-detail/{id}', 'customerDetail')->name('customer.detail');
        Route::post('/customer/customer-detail/list', 'listDataCustomerDetail');
        Route::post('/customer/customer-detail/save', 'storeCustomerDetail');
        Route::post('/customer/customer-detail/update', 'updateCustomerDetail');
        Route::post('/customer/customer-detail/delete', 'destroyCustomerDetail');
    });
    //# sales customer route end
    //# sales sample request route start
    Route::controller(SampleRequestController::class)->group(function () {
        Route::get('/sample-request', 'index')->name('sample_request');
        Route::post('/sample-request/list', 'listOfSample');
        Route::post('/sample-request/customer', 'customerDropdown');
        Route::get('/sample-request/create-sample', 'createSample')->name('sample_request.add');
        Route::post('/sample-request/create-sample/save', 'storeSampleRequest');
        Route::get('/sample-request/edit-sample/{id}', 'editSample')->name('sample_request.edit');
        Route::get('/sample-request/detail/{id}', 'detailSample')->name('sample_request.detail');
        Route::post('/sample-request/edit-sample/update', 'updateSample');
        Route::post('/sample-request/delete', 'destroySample');
        Route::get('/sample-request/{id}/customer-detail', 'createDetailCustomer')->name('sample_request.customer_detail_add');
        Route::post('/sample-request/customer-detail', 'customerDetailDropdown');
        Route::post('/sample-request/customer-detail/save', 'storeCustomerDetail');
        Route::get('/sample-request/{id}/product-detail', 'createDetailProduct')->name('sample_request.product_add');
        Route::post('/sample-request/product-detail/list', 'listOfproductDetail');
        Route::post('/sample-request/product-detail', 'productDropdown');
        Route::post('/sample-request/product-detail/save', 'storeProductDetail');
        Route::post('/sample-request/product-detail/delete', 'destroyProductDetail');
        Route::post('/sample-request/product-detail/edit', 'editProductDetail');
        Route::post('/sample-request/product-detail/update', 'updateProductDetail');
        Route::post('/sample-request/send-request', 'sendRequest');
        Route::get('/sample-request/preview/{token}', 'preview')->name('sample_request.preview');
    });
    //# sales sample request route end
    //sample request end
});

// Route RND START
Route::prefix('rnd')->middleware('auth')->group(function () {
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product/list', [ProductController::class, 'listData']);
    Route::post('/product/save', [ProductController::class, 'store']);
    Route::post('/product/update', [ProductController::class, 'update']);
    Route::post('/product/delete', [ProductController::class, 'destroy']);
    //Route sample source
    Route::controller(SampleSourceController::class)->group(function () {
        Route::get('/sample-source', 'index')->name('sample_source');
        Route::post('/sample-source/list', 'listData');
        Route::post('/sample-source/save', 'store');
        Route::post('/sample-source/update', 'update');
        Route::post('/sample-source/delete', 'destroy');
    });
    //Route ghs
    Route::controller(GhsController::class)->group(function () {
        Route::get('/ghs', 'index')->name('ghs');
        Route::post('/ghs/list', 'listData');
        Route::post('/ghs/save', 'store');
        Route::post('/ghs/update', 'update');
        Route::post('/ghs/delete', 'destroy');
    });
    //Route sample request
    Route::controller(SampleRequestRndController::class)->group(function () {
        Route::get('/sample-request', 'index')->name('rnd_sample_request');
        Route::post('/sample-request/list', 'list');
        Route::get('/sample-request/detail/{sampleId}', 'detail')->name('rnd_sample_request.detail');
        Route::get('/sample-request/confirm/{sampleId}', 'detailSampleRequestProduct')->name('rnd_sample_request.change_status');
        Route::post('/sample-request/confirm/product-list', 'listSampleProduct');
        Route::post('/sample-request/confirm/ghs-list', 'ghsDropdown');
        Route::post('/sample-request/batch-number', 'batchNumberLab');
        Route::post('/sample-request/confirm/create-sample-detail', 'storeSampleReqDetail');
        Route::post('/sample-request/confirm/finished', 'finished');
        Route::post('/sample-request/confirm/information', 'information');
        Route::post('/sample-request/confirm/delete-ghs', 'deleteLabelGhs');
        Route::post('/sample-request/confirm/submit-sample', 'submitSampleRequest');
        Route::post('/sample-request/confirm/upload-msds', 'storeMsdsPds');
        Route::post('/sample-request/confirm/delete-msds', 'deleteMsdsPds');
        Route::post('/sample-request/msds-pds-list', 'listMsdsPds');
        Route::get('/sample-request/label-print', 'labelPrint')->name('rnd_sample_request.print');
    });
});
// Route RND END
// Route super admin START
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/user-group', [AdminUserGroupController::class, 'index'])->name('user_group');
    Route::post('/user-group/list', [AdminUserGroupController::class, 'listData']);
    Route::post('/user-group/save', [AdminUserGroupController::class, 'store']);
    Route::get('/user-group/edit/{id}', [AdminUserGroupController::class, 'edit'])->name('user_group.edit');
    Route::patch('/user-group/update/{id}', [AdminUserGroupController::class, 'update']);
    Route::post('/user-group/delete', [AdminUserGroupController::class, 'delete']);
    // Route Admin Unit
    Route::get('/unit', [UnitController::class, 'index'])->name('unit');
    Route::post('/unit/list', [UnitController::class, 'listData']);
    Route::post('/unit/save', [UnitController::class, 'store']);
    Route::post('/unit/update', [UnitController::class, 'update']);
    Route::post('/unit/delete', [UnitController::class, 'destroy']);
    // Route admin companies
    Route::controller(CompanyController::class)->group(function () {
        Route::get('/company', 'index')->name('company');
        Route::post('/company/save', 'store');
        Route::post('/company/list', 'listData');
        Route::post('/company/show', 'show');
        Route::post('/company/change-logo', 'changeLogo');
        Route::post('/company/update', 'update');
        Route::post('/company/update-logo', 'updateLogo');
        Route::post('/company/delete', 'destroy');
    });
    // Route admin customer
    Route::controller(AdminCustomerController::class)->group(function () {
        Route::get('/customer', 'index')->name('admin_customer');
        Route::post('/customer/list', 'listData');
        Route::post('/customer/save', 'store');
        Route::get('/customer/edit/{id}', 'edit')->name('admin_customer.edit');
        Route::post('/customer/update', 'update');
        Route::post('/customer/delete', 'destroy');
        Route::post('/customer/user', 'userCustomer');
        Route::get('/customer/customer-detail/{id}', 'customerDetail')->name('admin_customer.detail');
        Route::post('/customer/customer-detail/list', 'listDataCustomerDetail');
        Route::post('/customer/customer-detail/save', 'storeCustomerDetail');
        Route::post('/customer/customer-detail/update', 'updateCustomerDetail');
        Route::post('/customer/customer-detail/delete', 'destroyCustomerDetail');
    });
});
// Route super admin END

//Route sample pic start
Route::prefix('pic')->middleware('auth')->group(function () {
    Route::controller(SampleRequestPicController::class)->group(function () {
        Route::get('/sample-request', 'index')->name('pic_sample_request');
        Route::post('/sample-request/list', 'list');
        Route::get('/sample-request/detail/{sampleId}', 'detail')->name('pic_sample_request.detail');
        Route::post('/sample-request/assign', 'listUserForAssign');
        Route::post('/sample-request/send-assign', 'assignSample');
        Route::post('/sample-request/open-transaction', 'openTransactionSampleRequest');
        Route::get('/sample-request/change-status/{id}', 'changeStatus')->name('pic_sample_request.change_status');
        Route::post('/sample-request/delivery-information', 'deliveryInformation');
        Route::get('/sample-request/assign-sample-product/{sampleId}', 'detailSampleProduct')->name('pic_sample_request.assign');
        Route::post('/sample-request/sample-product-information', 'listSampleProduct');
        Route::post('/sample-request/send-assign-sample-product', 'assignSampleProductToUser');
        Route::post('/sample-request/info-assign-sample-product', 'infoAssign');
        Route::post('/sample-request/edit-assign-sample-product', 'editAssign');
        Route::post('/sample-request/assign-sample-product/update', 'updateAssign');
    });
});
//Route sample pic end
