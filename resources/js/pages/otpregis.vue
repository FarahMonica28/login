<!-- // Laravel Backend (routes/api.php)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

Route::post('/send-otp', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    
    $otp = rand(100000, 999999);
    Session::put('otp', $otp);
    Session::put('email', $request->email);
    
    Mail::raw("Your OTP code is: $otp", function ($message) use ($request) {
        $message->to($request->email)->subject('OTP Verification');
    });
    
    return response()->json(['message' => 'OTP sent successfully!']);
});

Route::post('/verify-otp', function (Request $request) {
    if ($request->otp == Session::get('otp')) {
        return response()->json(['message' => 'OTP Verified Successfully!']);
    }
    return response()->json(['message' => 'Invalid OTP'], 400);
}); -->

<!-- // Vue Frontend (components/OtpVerification.vue) -->
<template>
    <div class="w-99.5 h-80 rounded-md" id="box">
        <div>
            <label for="email" class="mt-3 block text-sm/ font-medium text-gray-900 ">Email :</label>
            <input v-model="email" class=" block w-60 rounded-md bg-white px-3 py-1.5 "
                placeholder="Email" />
            <button @click="sendOtp" class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white ">Send OTP</button>
        </div>
        <div>
            <label for="otp" class="mt-4 block text-sm/ font-medium text-gray-900 ">Verify-otp</label>
            <input v-model="email" class=" block w-60 rounded-md bg-white px-3 py-1.5"
                placeholder="OTP" />
            <button @click="sendOtp" class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white btn-hover-black">Send OTP</button>
        </div>
<!-- 
        <input v-model="otp" placeholder="Enter OTP" />
        <button @click="verifyOtp">Verify OTP</button> -->

        <p>{{ message }}</p>
    </div>
</template>
<style>
/* body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
} */
#box {
    margin-left: 35%;
    margin-top: 5%;
    background: linear-gradient(rgb(230, 128, 230), rgb(84, 84, 224));
    justify-items: center;
}
input {
    border: 1px solid;
}
</style>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            email: '',
            otp: '',
            message: ''
        };
    },
    methods: {
        async sendOtp() {
            try {
                const res = await axios.post('/api/send-otp', { email: this.email });
                this.message = res.data.message;
            } catch (error) {
                this.message = 'Error sending OTP';
            }
        },
        async verifyOtp() {
            try {
                const res = await axios.post('/api/verify-otp', { otp: this.otp });
                this.message = res.data.message;
            } catch (error) {
                this.message = 'Invalid OTP';
            }
        }
    }
};
</script>
