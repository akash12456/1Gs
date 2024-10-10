<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;   
use App\Models\Affiliate;  
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgetPasswordOtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;
use Log;
use File;
use App\Mail\Emailverify;  

class ProfileDetailController extends Controller
{

    public function userAffiliateProfile(){  
       
        $affiliate_Category = Affiliate::where('status', 'active')->paginate(10); 
        $affiliate_Category->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'affiliate_name'  => $item->affiliate_name, 
                'affiliate_link' => $item->affiliate_links, 
                'image' => url($item->image),
            ];
        });
    
        return response()->json([
            'status' => true,
            'message' => 'User Affiliate Category',
            'affiliate_Category' => $affiliate_Category->items(),  
            'pagination' => [
                'current_page' => $affiliate_Category->currentPage(),
                'last_page' => $affiliate_Category->lastPage(),
                'per_page' => $affiliate_Category->perPage(),
                'total' => $affiliate_Category->total(),
            ]
        ]);
    }
    
    
    public function getUserDetails(Request $request){   
        $userId = auth('sanctum')->user()->id;  
        $usersDetail = User::where('id', $userId)->first();  
        if ($usersDetail->status === 'active') {    
            return response()->json([
                'status' => true,
                'message' => 'User details fetched successfully.',
                'data' => [
                    'user_detail' => sanitizeData($usersDetail->only([
                        'id', 'first_name', 'email','phone_number', 'gender', 'age','is_profile_completed',
                    ])), 
                ]
            ]);
        }
    
        return response()->json([
            'status' => false,
            'message' => 'User details not found.'
        ], 404);
    } 
 
    public function email_verify(Request $request){
        $userId = auth('sanctum')->user()->id;  
    
        if (!$userId) { 
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }
    
        $step = $request->input('step');
        $otp = rand(100000, 999999); 
        $user = User::find($userId);  
    
        if ($request->has('email')) {
            $email = $request->input('email');
            $emailExists = User::where('email', $email)->where('id', '!=', $userId)->exists();
    
            if ($emailExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already exists in our records.'
                ], 409);
            }
     
            $user->otp = $otp; 
            $user->save();
    
            $data = [
                'title' => 'Email Verification OTP',
                'otp' => $otp
            ];   
            Mail::to($email)->send(new Emailverify($data));  
    
            return response()->json([
                'status' => true,
                'message' => 'OTP sent to the provided email.'
            ], 200);
        } 
        elseif ($request->has('phone')) {
            $phone = $request->input('phone');
            $phoneExists = User::where('phone', $phone)->where('id', '!=', $userId)->exists();
    
            if ($phoneExists) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Phone number already exists in our records.'
                ], 409);
            } 
             
            $user->otp = $otp; 
            $user->save(); 
            return response()->json([
                'status' => true,
                'message' => 'OTP sent to the provided phone number.'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Please provide either an email or a phone number.'
            ], 400);
        }
    }
    
 

    public function otp_verify(Request $request)
    {
        $userId = auth('sanctum')->user()->id;
    
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }
     
        $user = User::find($userId);
     
        if ($user->otp == $request->input('otp')) { 
            if ($request->has('email')) { 
                $user->is_email_verified = 0;  
                $user->email = $request->input('email');  
            } elseif ($request->has('phone')) { 
                $user->is_phone_verified = 0; 
                $user->phone = $request->input('phone');  
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email or phone number is required for verification.'
                ], 400);
            }
     
            $user->otp = null;
            $user->save();
    
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully.',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP. Please try again.',
            ], 400);
        }
    }


    public function resend_otp(Request $request){
        $userId = auth('sanctum')->user()->id; 
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        } 
        $user = User::find($userId);
        $otp = rand(100000, 999999);   
        if ($request->has('email')) { 
            $email = $request->input('email'); 
            if ($user->email !== $email) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email does not match with the current one on file.'
                ], 400);
            } 
            $user->otp = $otp;  
            $user->save(); 
            $data = [
                'title' => 'Resend Email Verification OTP',
                'otp' => $otp
            ];
            Mail::to($email)->send(new Emailverify($data)); 
            return response()->json([
                'status' => true,
                'message' => 'OTP has been resent to your email.'
            ], 200); 
        } elseif ($request->has('phone')) { 
            $phone = $request->input('phone');  
            if ($user->phone !== $phone) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Phone number does not match with the current one on file.'
                ], 400);
            } 
            $user->otp = $otp; 
            $user->save();  
            return response()->json([
                'status' => true,
                'message' => 'OTP has been resent to your phone number.'
            ], 200);
        } 
        return response()->json([
            'status' => 'error',
            'message' => 'Please provide either email or phone number.'
        ], 400);
    }

    
 

}