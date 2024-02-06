<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $email = $request->input('email');
            $otp = rand(1000, 9999);
            Mail::to($email)->send(new OTPMail($otp));
            User::updateOrCreate(['email' => $email], ['otp' => $otp]);
            return response()->json(['message' => 'OTP sent successfully'], 200);

        }
        catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 200);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'otp' => 'required'
        ]);
        $email = $request->input('email');
        $otp = $request->input('otp');

        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json(['message' => 'User not found'], 200);
        }
        User::where('email', $email)->update(['otp' => 0]);
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['message' => 'OTP verified successfully', 'token' => $token], 200);
    }
}
