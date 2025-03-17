<?php 

namespace App\Http\Controllers;

// use App\Mail\SendEmail;
use App\Models\User;
// use Cache;
// use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Mail;
// use Validator;

class OtpController extends Controller {

// 2. Verifikasi OTP dan registrasi user
// public function verifyOtp(Request $request)
// {
//     // Validasi input
//     $validator = Validator::make($request->all(), [
//         'name' => 'required',
//         'email' => 'required|email|unique:users',
//         'password' => 'required|min:6',
//         'otp' => 'required|digits:6'
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['message' => $validator->errors()], 400);
//     }

//     $email = $request->email;
//     $otpInput = $request->otp;
//     $otpStored = Cache::get('otp_' . $email);

//     // Periksa apakah OTP valid
//     // if (!$otpStored) {
//     //     return response()->json(['message' => 'OTP expired or not found'], 400);
//     // }
//     if ($request->otp != Cache::get('otp_' . $request->email)) {
//         return response()->json(['message' => 'OTP tidak valid'], 400);
//     }

//     if ($otpStored != $otpInput) {
//         return response()->json(['message' => 'Invalid OTP'], 400);
//     }

//     // Hapus OTP setelah verifikasi sukses
//     Cache::forget('otp_' . $email);

//     // Buat user baru
//     $user = User::create([
//         'name' => $request->name,
//         'email' => $email,
//         'password' => Hash::make($request->password),
//     ]);

//     return response()->json(['message' => 'Registration successful', 'user' => $user], 201);
// }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input!'], 400);
        }

        $user = user::where('email', $request->email)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid or expired OTP!'], 400);
        }

        // $otp->delete(); // Hapus OTP setelah berhasil diverifikasi

        return response()->json(['message' => 'OTP Verified!'], 200);
    }
}
