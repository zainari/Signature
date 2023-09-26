<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //Return View of OTP login Page

    public function login()
    {
        return view('Auth.otp-login');
    }

    public function generate(Request $request)
    {
        #Validate Data
        $request->validate([
            'mobile_no' => 'required|exists:users,mobile_no'
        ]);
        #Generate An OTP

        $verificationcode = $this->generateotp($request->mobile_no);

        #
    }
    public function generateotp(){
     $user = users::where('mobile_no', $mobile_no)->first();

     #user does not Have Any Exciting OTP

     $verificationcode = verification_codes::where('user_id', $user->id)->latest()->first();

     $now = Carbon::now();

     if($verificationcode && $now->isBefore($verificationcode->expire_at)){
        return $verificationcode;
     }
     //create a New OTP

     return verification_codes::create([
        'user_id' => $user->id,
        'otp' =>  rand(123456,9999999),
        'expire_at' => Carbon::now()->addMinutes(10)
     ]);
    }


}
