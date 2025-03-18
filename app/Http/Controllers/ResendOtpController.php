<?php

namespace App\Http\Controllers\Api;

use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResendOtpController extends Controller
{
    /**
     * Resend OTP to the user's email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendOtp(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'success' => false, 'message' => $validator->errors() ], 422);
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user sudah terverifikasi
        if ($user->email_verified_at) {
            return response()->json([ 'success' => false, 'message' => 'Akun sudah terverifikasi.' ], 400);
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires = now()->addMinutes(5);
        $user->save();

        // Kirim email dengan OTP baru
        Mail::to($user->email)->send(new SendEmail($otp));

        return response()->json([ 'success' => true, 'message' => 'OTP telah dikirim ulang.' ]);
    }
}
