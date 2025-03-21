<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Cek apakah email ada di database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar!'], 404);
        }

        if($user->email_verified_at == null ){
            return response()->json(['massage' => 'email belum diverifikasi.'], 403);
        }

        // Coba login dengan kredensial yang diberikan
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // if (Auth::attempt($credentials)) {
        //     $user = Auth::user();
    
        //     return response()->json([
        //         'user' => [
        //             'name' => $user->name,
        //             'email_verified_at' => $user->email_verified_at, // Tambahkan ini
        //         ],
        //         'token' => $user->createToken('authToken')->plainTextToken
        //     ]);
        // }

        // Jika login berhasil, kembalikan token dan informasi pengguna
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),    
            'token'   => $token,
            'email_verified_at' => $user->email_verified_at // Tambahkan ini
        ], 200);
    }
}
