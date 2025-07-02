<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';
import axiosClient from '../../../axios'; // Sesuaikan path kalau berbeda

const router = useRouter();
const otp = ref('');
const message = ref('');

const verifyOtp = async () => {
    const email = localStorage.getItem("email");

    if (!email) {
        Swal.fire({
            icon: "error",
            title: "Email Tidak Ditemukan",
            text: "Silakan daftar atau kirim ulang OTP terlebih dahulu.",
        });
        return;
    }

    if (!otp.value) {
        Swal.fire({
            icon: "warning",
            title: "OTP Kosong",
            text: "Silakan masukkan kode OTP terlebih dahulu.",
        });
        return;
    }

    try {
        const response = await axiosClient.post("/verifyOtp", {
            email: localStorage.getItem('email'), // ✅ email dari localStorage
            otp: otp.value
        });

        if (response.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Verifikasi Berhasil!',
                text: response.data.message || 'Akun Anda berhasil diverifikasi.',
                confirmButtonText: 'OK'
            }).then(() => {
                localStorage.removeItem('email');
                router.push('/sign-in'); // redirect ke homepage
            });
        }
    } catch (error) {
        let errorMessage = "Terjadi kesalahan saat verifikasi.";

        if (error.response) {
            if (error.response.status === 400) {
                errorMessage = error.response.data.message || "Kode OTP salah!";
            } else if (error.response.status === 422) {
                errorMessage = "Kode OTP telah kedaluwarsa. Silakan kirim ulang.";
            } else if (error.response.status === 500) {
                errorMessage = "Kesalahan server. Coba lagi nanti.";
            }
        }

        Swal.fire({
            icon: 'error',
            title: 'Verifikasi Gagal',
            text: errorMessage
        });
    }
};

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
                    class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white btn-hover-black">Verify</button>
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
