<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\AffiliateController;
use App\Http\Controllers\Admin\RevenueController;





// <===========================Admin Routes Starts =====================> //

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('not.logged.in')->group(function () {
    Route::controller(AuthController::class)->prefix('admin')->group(function () {
        Route::get('login', 'loginView')->name('login');
        Route::post('login', 'loginCrediential')->name('login.crediential');
        Route::get('forgot-password', 'forgotPassword')->name('admin.forgotpassword');
        Route::post('reset-forgot-password', 'resetForgotPassword')->name('admin.reset.forgotpassword');
        Route::get('change-password/{token}', 'changePassword')->name('admin.change.password');
        Route::post('store-password', 'storePassword')->name('admin.store.password');
        // Route::post('change-detail', 'changeAdminDetail')->name('admin.change.detail');
        // Route::post('password-reset', 'changeAdminPassword')->name('admin.reset.password');
    });
});

Route::middleware('Authenticated')->group(function () {
    Route::controller(DashboardController::class)->prefix('admin')->group(function () {
        Route::get('dashboard', 'Dashboard')->name('dashboard');
        Route::get('logout', 'logout')->name('logout');
        Route::get('profile', 'profile')->name('profile');
    });

    Route::controller(AuthController::class)->prefix('admin')->group(function () {
        Route::post('change-detail', 'changeAdminDetail')->name('admin.change.detail');
        Route::post('password-reset', 'changeAdminPassword')->name('admin.reset.password');
        //check admin current password
        Route::post('check-current-password', 'checkAdminCurrentPassword')->name('check.admin.current.password');
    });

    Route::controller(UserController::class)->prefix('admin')->group(function () {
        Route::get('user-list', 'userList')->name('user.list');
        Route::get('user-create', 'create_user')->name('user.create');
        Route::match(['post', 'put'], 'user-store/{id?}', 'userStore')->name('user.store');
        Route::get('user-update/{id}', 'userEdit')->name('user.update');
        Route::get('user-delete/{id}', 'userDelete')->name('user.delete');


        Route::post('check-email', 'emailExistsOrNote')->name('check.email');
        Route::post('check-brand-name', 'brandNameExistsOrNote')->name('check.brand-name');
        //upload admin profile image
        Route::post('update-admin-profile', 'updateAdminProfile')->name('update.admin.profile');
        //user status change
        Route::post('user-status-change', 'userStatusChange')->name('user.status.change');
    });

    Route::controller(DoctorController::class)->prefix('admin')->group(function () {
        //----------Driver Routes---------------//
        Route::get('doctor-list', 'doctorList')->name('doctor.list');
        Route::get('doctor-create', 'create_doctor')->name('doctor.create');
        Route::match(['post', 'put'], 'doctor-store/{id?}', 'doctorStore')->name('doctor.store');
        Route::get('doctor-update/{id}', 'doctorEdit')->name('doctor.update');
        Route::get('doctor-delete/{id}', 'doctorDelete')->name('doctor.delete');
        Route::get('doctor-view/{id}', 'doctorView')->name('doctor.view');
    });
    Route::controller(RevenueController::class)->prefix('admin')->group(function () {
        //----------Driver Routes---------------//
        Route::get('revenue-chart', 'revenueChart')->name('revenue.chart');
    });

    Route::controller(AffiliateController::class)->prefix('admin')->group(function () {
        Route::get('affiliate-list', 'affiliateList')->name('affiliate.list');
        Route::post('affiliate-store', 'affiliateStore')->name('affiliate.store');
        Route::post('affiliate-update', 'affiliateUpdate')->name('affiliate.update');
        Route::get('affiliate-delete/{id}', 'affiliateDelete')->name('affiliate.delete');
    });
});

// <===========================Admin Routes End ========================> //
