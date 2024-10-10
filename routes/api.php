<?php


use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\UserController;   
use App\Http\Controllers\Api\ProfileDetailController;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::post('/verify-otp', [UserController::class, 'verifyOtp']);

Route::controller(AuthController::class)->group(function () { 
    Route::post('signup','signup');
    Route::post('register', 'register');
    Route::post('forget-password', 'forgetPassword');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('reset-password', 'resetPassword');
    Route::post('complete-profile', 'completeProfile');
});


Route::controller(ProfileDetailController::class)->group(function () {
    Route::get('affilate-get', 'userAffiliateProfile'); 
    Route::get('get-userdetail', 'getUserDetails');   
    Route::post('email-verify-otp', 'email_verify');  
    Route::post('otp-verify', 'otp_verify');    
    Route::post('resend-otp-verify', 'resend_otp');    
}); 

 
    Route::middleware(['auth:sanctum', 'check.status'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
    });
 

  
    
 


});

