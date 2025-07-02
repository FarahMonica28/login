<script setup>
import { ref } from "vue";
import GuestLayout from "../../../components/GuestLayout.vue";
import Swal from "sweetalert2"; // Import SweetAlert2
import axiosClient from "../../../axios";
import router from "../../../router";

// localStorage.setItem("name", response.data.user.name);
const data = ref({
    token: router.params.token,
    email: router.query.email,
    password: "",
    password_confirmation: "",
});

const loading = ref(false);
const errors = ref({});

const submitLogin = async () => {
    try {
        const response = await axiosClient.post('/reset-password', {
            token: data.value.token,
            email: data.value.email,
            password: data.value.password,
            password_confirmation: data.value.password_confirmation,
        });
        // const user = response.data.user; // Ambil user dari response

        if (response.status === 200) {
            router.push('/sign-in')


            // **SweetAlert2 Notifikasi Berhasil**
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!'
                // timer: 2000, // Auto-close dalam 2 detik
                // showConfirmButton: false
            });
            router.push('/home');
            // Redirect ke halaman home setelah beberapa detik
            // setTimeout(() => {
            //     router.push('/home'); 
            // }, 2000);
        }
    } catch (error) {
        if (error.response) {
            if (error.response.status === 401) {
                errors.value.general = "Email atau password salah";
                alert(errors.value.general);
            } else if (error.response.status === 403) {
                errors.value = "Email belum terverifikasi";

                Swal.fire({
                    icon: "warning",
                    title: "Email Belum Terverifikasi",
                    text: "Kirim ulang kode OTP ke email Anda?",
                    showCancelButton: true,
                    confirmButtonText: "Kirim Ulang",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log("Mengirim ulang OTP...");

                        // ✅ Simpan email ke localStorage
                        localStorage.setItem("email", data.value.email);

                        axiosClient
                            .post("/resend-otp", { email: data.value.email })
                            .then(() => {
                                Swal.fire({
                                    icon: "success",
                                    title: "OTP Dikirim",
                                    text: "Kode OTP berhasil dikirim ke email Anda.",
                                }).then(() => {
                                    // ✅ Redirect ke halaman verifikasi OTP
                                    router.push("/resend");
                                });
                            })
                            .catch(() => {
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal Mengirim OTP",
                                    text: "Silakan coba lagi nanti.",
                                });
                            });
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Tidak Ditemukan!',
                    text: 'Silakan daftar atau masukkan email yang benar.',
                });
            }
        } else {
            errors.value.general = "Tidak dapat menghubungi server.";
            alert(errors.value.general);
        }
    } finally {
        loading.value = false;
    }

};
</script>


<template>
    <GuestLayout>

        <div class="flex flex-col items-center justify-center mt-15">
            <h2 class="text-2xl font-bold tracking-tight text-black text-center">
                Masukan Akun <span class="text-red-600">Anda</span>
            </h2>

            <div class="mt-6 w-[398px] h-[350px] rounded-md" id="data">
                <form @submit.prevent="submitLogin" class="space-y-6 p-4">
                    <!-- <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 mt-4">Email :</label>
                        <input type="email" v-model="data.email" id="email"
                            class="mt-1 block w-full rounded-md px-3 py-1.5 focus:outline-black" />
                    </div> -->
                    <div class="flex items-center justify-between">
                        <label for="email" class="block text-sm font-medium text-gray-900 mt-4 ml-2">Email :</label>
                        <input type="email" name="email" id="email" autocomplete="email" required=""
                            class="mt-3 mr-2 block w-60 rounded-md bg-white px-3 py-1.5 focus:outline-black"
                            v-model="data.email">
                    </div>
                    <!-- <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 mt-2">Password :</label>
                        <input type="password" v-model="data.password" id="password"
                            class="mt-1 block w-full rounded-md px-3 py-1.5 focus:outline-black" />
                    </div> -->
                    <!-- Password Label -->
                    <!-- Password -->
                    <div class="mb-1">
                        <div class="flex items-center justify-between">
                            <label for="password" class="w-24 text-sm font-medium text-gray-900 mt-4 ml-2">Password
                                :</label>
                            <input type="password" id="password" name="password" v-model="data.password"
                                class="mt-3 mr-2 w-60 rounded-md px-3 py-1.5 bg-white text-base focus:outline-black" />
                        </div>

                        <!-- Forgot Password di bawah input password -->
                        <a href="/forgot" class="block mt-1 text-sm text-right text-black hover:text-white">
                            Forgot password?
                        </a>
                    </div>

                    <!-- <div class="text-sm ml-50"> -->
                    <!-- </div> -->

                    <p class="font-semibold  text-center text-sm/6 text-black mt-3 mr-4" id="otp">
                        Login Menggunakan Kode
                        <router-Link to="/otplogin" class="font-semibold" id="buat">OTP?</router-Link>
                    </p>
                    <button type="submit" class="w-full rounded-md px-3 py-1.5 text-sm font-semibold">
                        Masuk
                    </button>
                </form>

                <!-- <p class="text-center text-sm text-white" id="tes">
                    Tidak Memiliki Akun? <router-link to="/register" id="buat">Buat Akun</router-link>
                </p> -->
                <p class="font-semibold  text-center text-sm/6 text-black" id="tes">
                    Tidak Memiliki Akun?
                    <!-- {{ " " }} -->
                    <!-- <a href="/register" class="font-semibold" id="buat">Buat Akun</a> -->
                    <router-Link to="/sign-up" class="font-semibold" id="buat">Buat Akun</router-Link>
                </p>

            </div>
        </div>
    </GuestLayout>
</template>

<style>
html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden;
    /* ini mencegah scroll */
}

body {
    /* background-image: url('/image/aurora.jpg'); */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    /* display: flex; */
    justify-content: center;
    align-items: center;
}

#data {
    /* background-color: rgb(245, 187, 245); */
    background: linear-gradient(to right, #fd9ffd, #d027d6);
    /* background-image: url('/image/au.jpg');
    background-repeat: no-repeat;
    /* background-size: cover; */
    /* background-position: center; */
    /* min-height: 100vh; */
}

span {
    color: red;
}

p {
    text-align: center;
}

button {
    background-color: rgb(150, 68, 130);
    border-radius: 5px;
    color: rgb(0, 0, 0);
    border: none;
}

button:hover {
    background-color: rgb(85, 56, 83);
    color: rgb(255, 255, 255);
    border: none;
}

#buat {
    /* color: rgb(231, 69, 104); */
    color: rgb(255, 255, 255);

}

#buat:hover {
    color: black;
}


/* #submit {
    background-color: rgb(158, 52, 158);
}

#btn:hover {

</style>