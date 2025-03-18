<?php

namespace App\Http\Controllers\Api;

use App\Mail\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mail;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8'
        ]);

        //if validation fails
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        $otp = rand(100000, 999999);

        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'otp' => $otp,
            'otp_expires' => now()->addMinutes(5),
        ]);

        // Cache::put('otp_' . $email, $otp, now()->addMinutes(5));

        Mail::to($request->email)->send(new SendEmail($otp));

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    } 
    // public function showRegister (){
    //     return view('app');
    // }
}




// public function sendOtp(Request $request)
//     {
//         // Validate the email input from the request
//         // $request->validate([
//         //     'email' => 'required|email',
//         // ]);

//         // Generate a random OTP
//         $otp = rand(1000, 9999);

//         // Cache::put('otp_' . $email, $otp, now()->addMinutes(5));

//         // Prepare the data for the email
//         $data = [
//             'otp' => $otp
//         ];

//         // Send the OTP email to the provided email address
//         Mail::to($request->email)->send(new SendEmail($data));
//         // Mail::to($request->input('email'))->send(new SendEmail($data));

//         // Return a success response
//         return response()->json(['message' => 'OTP sent successfully']);
//     }
