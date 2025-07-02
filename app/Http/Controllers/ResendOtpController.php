<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class ResendOtpController extends Controller
{
public function resend(Request $request)
    {
        // Validasi email (jangan dikomentari)
        // $request->validate([
        //     'email' => 'required|email',
        // ]);

        // Cari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        // Cek apakah user sudah diverifikasi
        if ($user->email_verified_at !== null) {
            return response()->json(['message' => 'Akun sudah diverifikasi.'], 400);
        }

        // Buat OTP baru (6 digit)
        $otp = rand(100000, 999999); // harus 6 digit, bukan 5 digit

        // Simpan OTP dan waktu kedaluwarsa
        $user->otp = $otp;
        $user->otp_expires = now()->addMinutes(10);
        $user->save();

        // Kirim email
        Mail::to($user->email)->send(new SendEmail($otp));

        return response()->json(['message' => 'OTP baru berhasil dikirim.'], 200);
    }

    
public function verifyOtp(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|digits:6',
    ]);

    // Cari user berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Cek apakah user ditemukan
    if (!$user) {
        return response()->json(['message' => 'Email tidak ditemukan.'], 404);
    }

    // Cek apakah sudah diverifikasi
    if ($user->email_verified_at !== null) {
        return response()->json(['message' => 'Akun sudah diverifikasi.'], 400);
    }

    // Cek apakah OTP cocok
    if ($user->otp !== $request->otp) {
        return response()->json(['message' => 'Kode OTP salah.'], 400);
    }

    // Cek apakah OTP sudah kadaluarsa
    if (now()->gt($user->otp_expires)) {
        return response()->json(['message' => 'Kode OTP telah kedaluwarsa.'], 422);
    }

    // Verifikasi berhasil → update status user
    $user->email_verified_at = now();
    $user->otp = null; // hapus OTP
    $user->otp_expires = null;
    $user->save();

    return response()->json(['message' => 'OTP berhasil diverifikasi.'], 200);
}

}