<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";
import Swal from "sweetalert2"; // Import SweetAlert2


const otp = ref('');
const message = ref('');
const email = localStorage.getItem('email');

const verifyOtp = async () => {
    try {
        const response = await axiosClient.post("/verify-otp", {
            email: email,
            otp: otp.value
        });

        // localStorage.removeItem('email');
        if (response.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Registasi Berhasil!'
                // timer: 2000, // Auto-close dalam 2 detik
                // showConfirmButton: false
            });

            // Redirect ke dashboard atau halaman utama setelah registrasi sukses
            router.push("/");
        }
        message.value = response.data.message;
    }  catch (error) {
        console.error("OTP Verification Error:", error); // Debugging error di console

        let errorMessage = "Terjadi kesalahan saat verifikasi OTP.";

        if (error.response) {
            if (error.response.status === 400) {
                errorMessage = error.response.data.message || "Kode OTP salah!";
            } else if (error.response.status === 422) {
                errorMessage = "Kode OTP telah kedaluwarsa. Silakan kirim ulang.";
            } else if (error.response.status === 500) {
                errorMessage = "Terjadi kesalahan server. Coba lagi nanti.";
            }
        }

        Swal.fire({
            icon: "error",
            title: "Verifikasi Gagal",
            text: errorMessage,
        });
    }
};

// return {
//   email,
//   otp,
//   message,
//   verifyOtp
// };

</script>

<!-- // Vue Frontend (components/OtpVerification.vue) -->
<template>
    <div class="w-99.5 h-40 rounded-md" id="box">
        <form @submit.prevent="verifyOtp">
            <!-- <div>
            <label for="email" class="mt-3 block text-sm/ font-medium text-gray-900 ">Email :</label>
            <input v-model="email" class=" block w-60 rounded-md bg-white px-3 py-1.5 "
                placeholder="Email" />
            <button @click="sendOtp" class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white ">Send OTP</button>
        </div> -->
            <div>
                <label for="otp" class="mt-4 block text-sm/ font-medium text-gray-900 ">Verify-otp</label>
                <input v-model="otp" class=" block w-60 rounded-md bg-white px-3 py-1.5" placeholder="OTP" />
                <button type="submit"
                    class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white btn-hover-black">Daftar</button>
            </div>
        </form>
        <!-- 
        <input v-model="otp" placeholder="Enter OTP" />
        <button @click="verifyOtp">Verify OTP</button> -->
        <!-- 
        <p>{{ message }}</p> -->
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
    background: linear-gradient(rgb(84, 84, 224), rgb(230, 128, 230));
    justify-items: center;
}

input {
    border: 1px solid;
}
</style>


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
