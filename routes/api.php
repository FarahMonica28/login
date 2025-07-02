<?php


use App\Http\Controllers\LoginOtpController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ResendOtpController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');

/**
 * route "/user"`   
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');  

// Route::get("/test-me", function () {
//     return 'Hello from Laravel!';
// });
// Route::get('/send-email',function(){
//     $data = [
//         'name' => 'Farah',
//         'body' => 'haloo'
//     ];
   
//     Mail::to('idontnow251@gmail.com')->send(new SendEmail($data));
   
//     dd("Email Berhasil dikirim.");
// });

// Route::post('/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
Route::post('/send-otp', [LoginOtpController::class, 'login']);
Route::post('/verify', [LoginOtpController::class, 'verify']);

Route::post('/resend-otp', [ResendOtpController::class, 'resend']);
Route::post('/verifyOtp', [ResendOtpController::class, 'verifyOtp']);

// Route::post('/verifyOtp', function (Request $request) {
//     if ($request->otp == Session::get('otp')) {
//         return response()->json(['message' => 'OTP Verified Successfully!']);
//     }
//     return response()->json(['message' => 'Invalid OTP'], 400);
// });




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    Route::post('/roles/{id}/assign-permissions', [RoleController::class, 'assignPermission']);
});