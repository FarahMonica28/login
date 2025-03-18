<!-- <script setup>
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
        Swal.fire({
            icon: 'success',
            title: 'Registasi Berhasil!'
            // timer: 2000, // Auto-close dalam 2 detik
            // showConfirmButton: false
        });

        // Redirect ke dashboard atau halaman utama setelah registrasi sukses
        router.push("/");

        message.value = response.data.message;
    } catch (error) {
        message.value = error.response.data.message || "Error verifying OTP!";
    }
};

// return {
//   email,
//   otp,
//   message,
//   verifyOtp
// };

</script> -->

<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";
import Swal from "sweetalert2";

const otp = ref("");
const message = ref("");
const email = ref("");

const sendOtp = async () => {
    console.log('email ditekan')
    try {
        await axiosClient.post("/send-otp", { email: email.value });
        console.log('mengirim')
        Swal.fire({
            icon: "success",
            title: "OTP berhasil dikirim!",
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Gagal mengirim OTP",
            // text: error.response?.data?.message || "Terjadi kesalahan!",
        });
    }
};

const verifyOtp = async () => {
    try {
        const response = await axiosClient.post("/verify", {
            email: email.value,
            otp: otp.value,
        });
        Swal.fire({
            icon: "success",
            title: "Registrasi Berhasil!",
        });
        router.push("/home");
        message.value = response.data.message;
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Verifikasi Gagal",
            text: error.response?.data?.message || "Kode OTP salah!",
        });  
    }
};
</script>

<!-- // Vue Frontend (components/OtpVerification.vue) -->
<template>
    <GuestLayout>
        <h2 class="text-center text-2xl/9 font-bold tracking-tight text-gray-900">
            Masukan Akun <span>Anda</span>
        </h2>

        <div class="mt-3 w-99.5 h-88 rounded-md" id="box">
            <div>
                <label class="mt-3 block text-sm/ font-medium text-gray-900">Email :</label>
                <input v-model="email" class=" block w-60 rounded-md bg-white px-3 py-1.5" placeholder="Email" />
                <button @click="sendOtp"
                    class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white ">
                    Kirim OTP
                </button>
            </div>
            <form @submit.prevent="verifyOtp">
                <div>
                    <label for="otp" class="mt-4 block text-sm/ font-medium text-gray-900 ">Kode OTP : </label>
                    <input v-model="otp" class=" block w-60 rounded-md bg-white px-3 py-1.5" placeholder="OTP" />
                    <button type="submit"
                        class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white btn-hover-black">
                        Masuk
                    </button>
                </div>
            </form>
            <p class="font-semibold  text-center text-sm/6 text-black mr-2 mt-3" id="otp">
                Login Menggunakan 
                <!-- {{ " " }} -->
                <!-- <a href="/register" class="font-semibold" id="buat">Buat Akun</a> -->
                <router-Link to="/" class="font-semibold" id="buat">Password?</router-Link><br>
                Tidak Memiliki Akun?
                <!-- {{ " " }} -->
                <!-- <a href="/register" class="font-semibold" id="buat">Buat Akun</a> -->
                <router-Link to="/register" class="font-semibold" id="buat">Buat Akun</router-Link>
            </p>
            <!-- <p class="font-semibold  text-center text-sm/6 text-black mr-2" id="otp">
                Login Menggunakan Password?
                {{ " " }}
                <a href="/register" class="font-semibold" id="buat">Buat Akun</a>
                <router-Link to="/" class="font-semibold" id="buat">Masuk</router-Link>
            </p> -->
            <!-- 
        <input v-model="otp" placeholder="Enter OTP" />
        <button @click="verifyOtp">Verify OTP</button> -->
            <!-- 
        <p>{{ message }}</p> -->
        </div>
    </GuestLayout>
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
    background: linear-gradient(rgb(230, 128, 230), rgb(84, 84, 224),);
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
