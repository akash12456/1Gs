<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\Emailverify;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $email = $request->email;
        $countryCode = $request->country_code;
        $phone = $request->phone;

        if (!$email && !$phone) {
            return response()->json([
                'status' => false,
                'message' => 'No contact method provided.'
            ], 400);
        }

        $user = User::where('phone_number', $phone)->orWhere('email', $email)->first();


        $otp = rand(100000, 999999);

        if ($user) {
            $user->otp = $otp;
            $user->save();
            if ($email) {
                $data = [
                    'title' => 'Email Verification OTP',
                    'otp' => $otp
                ];
                Mail::to($email)->send(new Emailverify($data));
                $message = 'OTP sent to the provided email.';
            } elseif ($phone) {
                $data = [
                    'title' => 'Phone Verification OTP',
                    'otp' => $otp
                ];
                $message = 'OTP sent to the provided phone number.';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'token' => $user->createToken('api-token')->plainTextToken
            ], 200);
        } else {
            $user = new User();
            $user->country_code = $countryCode;
            $user->phone_number = $phone;
            $user->email = $email;
            $user->status = 'inactive';
            $user->otp = $otp;
            $user->save();


            if ($email) {
                $data = [
                    'title' => 'Email Verification OTP',
                    'otp' => $otp
                ];
                Mail::to($email)->send(new Emailverify($data));
                $message = 'OTP sent to the provided email.';
            } elseif ($phone) {
                $data = [
                    'title' => 'Phone Verification OTP',
                    'otp' => $otp
                ];
                $message = 'OTP sent to the provided phone number.';
            }

            return response()->json([
                'status' => true,
                'message' => $message,
                'token' => $user->createToken('api-token')->plainTextToken
            ], 200);
        }
    }




    protected function generateResponse($user, $token, $request)
    {
        return response()->json([
            'status' => true,
            'step' => $user->step ?? 0,
            'message' => 'User registered successfully',
            'token' => $token
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'country_code' => 'required|numeric',
            'mobile' => 'required|numeric|digits:8',
            'otp' => 'required|numeric|digits:6'
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User Not Found',
                'status' => false
            ], 404);
        }

        if ($user->otp_expire_at < now()) {
            return response()->json([
                'message' => 'OTP Expired',
                'status' => false
            ], 400);
        }

        if ($user->otp != $request->otp) {
            return response()->json([
                'message' => 'Invalid OTP',
                'status' => false
            ], 400);
        }

        $user->otp = null;
        $user->save();

        $token = $user->createToken('api-token')->accessToken;

        // Check if user's first name is not set
        if (empty($user->mobile)) {
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully',
                'is_phone' => '0',
                'is_register' => '0',
                'shipping_address' => '0',
                'language' => $user->language,
                'token' => $token,
                'user_id' => $user->id
            ]);
        } elseif (empty($user->first_name)) {
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully',
                'is_phone' => '1',
                'is_register' => '0',
                'shipping_address' => '0',
                'language' => $user->language,
                'token' => $token,
                'user_id' => $user->id
            ]);
        } elseif (!ShippingAddress::where('user_id', $user->id)->exists()) {
            // Check if user does not have a shipping address
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully',
                'is_phone' => '1',
                'is_register' => '1',
                'shipping_address' => '0',
                'language' => $user->language,
                'token' => $token,
                'user_id' => $user->id
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'OTP verified successfully',
                'is_phone' => '1',
                'is_register' => '1',
                'shipping_address' => '1',
                'language' => $user->language,
                'token' => $token,
                'user_id' => $user->id
            ]);
        }
    }


    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully.',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.',
            ], 401);
        }
    }
}
