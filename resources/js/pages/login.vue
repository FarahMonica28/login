<!-- <script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";

const data = ref({
    email: "",
    password: "",
    errorMessage: ""
});
const submitLogin = async () => {
    try {
        const response = await axiosClient.post('http://127.0.0.1:8000/api/login', {
            email: data.value.email,
            password: data.value.password
        });

        if (response.status === 200) {
            const token = response.data.token;
            localStorage.setItem('authToken', token);
            router.push('/home'); // Redirect ke halaman home
            // alert("Anda berhasil Login");
        }
    } catch (error) {
        errorMessage.value = error.response?.data?.message || 'Login gagal';
        console.error('Login error:', error);
        alert("Login gagal");
    }
};
</script> -->

<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import Swal from "sweetalert2"; // Import SweetAlert2
import axiosClient from "../axios";
import router from "../router";

// localStorage.setItem("name", response.data.user.name);
const data = ref({
    email: "",
    password: "",
});

const loading = ref(false);
const errors = ref({});

const submitLogin = async () => {
    try {
        const response = await axiosClient.post('/login', {
            email: data.value.email,
            password: data.value.password
        });
        const user = response.data.user; // Ambil user dari response

        // **Cek apakah email sudah diverifikasi**
        // if (!user.email_verified_at) {
        //     const { isConfirmed } = await Swal.fire({
        //         icon: 'warning',
        //         title: 'Akun Belum Diverifikasi',
        //         text: 'Anda belum memverifikasi akun Anda. Apakah Anda ingin mengirim ulang email verifikasi?',
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya, Kirim Ulang',
        //         cancelButtonText: 'Tidak'
        //     });
        //     if (isConfirmed) {
        //         await axiosClient.post('/resend-otp', {
        //             email: data.value.email
        //         });
        //         Swal.fire({
        //             icon: 'success',
        //             title: 'Email Verifikasi Dikirim!',
        //             text: 'Silakan periksa email Anda.',
        //         });
        //         router.push('/otpregis')
        //     }
        //     return;
        // }

        if (response.status === 200) {
            const token = response.data.token;
            localStorage.setItem('authToken', token);
            localStorage.setItem("name", response.data.user.name);
            localStorage.getItem("email", response.data.email);


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

                // Tampilkan konfirmasi
                if (
                    confirm(
                        "Email belum terverifikasi. Kirim ulang OTP sekarang?"
                    )
                ) {
                    console.log('kode OTP dikirim')
                    // Kirim ulang OTP
                    axiosClient
                        .post("/resend-otp", { email: data.value.email })
                        .then(() => {
                            // Redirect ke halaman OTP setelah sukses kirim ulang
                            window.location.href = "/otpregis";
                        })
                        .catch((otpError) => {
                            alert("Gagal mengirim OTP. Silakan coba lagi.");
                        });
                }
            } else {
                // errors.value.general = "Email Tidak Ditemukan";
                // alert(errors.value.general);
                Swal.fire({
                icon: 'error',
                title: 'Email Tidak Ditemukan!'
                // timer: 2000, // Auto-close dalam 2 detik
                // showConfirmButton: false
            });

            }
        } else {
            errors.value.general = "Tidak dapat menghubungi server.";
            alert(errors.value.general);
        }
    } finally {
        loading.value = false; // Matikan loading
    }
};
</script>


<template>
    <GuestLayout>
        <h2 class="text-center text-2xl/9 font-bold tracking-tight text-gray-900">
            Masukan Akun <span>Anda</span>
        </h2>

        <div class="mt-3 w-99.5 h-80 ml-113 rounded-md" id="data">
            <form @submit.prevent="submitLogin" class="space-y-6 ml-4 mt-4">
                <div>
                    <div class="flex items-center justify-between">
                        <label for="email" class="block text-sm/ font-medium text-gray-900 mt-4">Email :</label>
                        <input type="email" name="email" id="email" autocomplete="email" required=""
                            class="mt-3 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 focus:outline-black"
                            v-model="data.email">
                    </div>
                    <!-- <div class="mt-0.5">
                    </div> -->
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/ font-medium text-gray-900 mt-3">Password :</label>
                        <!-- <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500 mr-15">Forgot
                                password?</a>
                            </div> -->
                        <input type="password" name="password" id="password" autocomplete="current-password" required=""
                            class="mt-2 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 text-base focus:outline-black sm:text-sm/6"
                            v-model="data.password" />
                    </div>
                </div>
                <!-- <p>Atau</p> -->
                <p class="font-semibold  text-center text-sm/6 text-black mr-4" id="otp">
                    Login Menggunakan Kode
                    <!-- {{ " " }} -->
                    <!-- <a href="/register" class="font-semibold" id="buat">Buat Akun</a> -->
                    <router-Link to="/otplogin" class="font-semibold" id="buat">OTP?</router-Link>
                </p>

                <button type="submit"
                    class="mt-1 ml-5 flex w-65 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white btn-hover-black">
                    Masuk
                </button>
            </form>

            <p class="font-semibold  text-center text-sm/6 text-black" id="tes">
                Tidak Memiliki Akun?
                <!-- {{ " " }} -->
                <!-- <a href="/register" class="font-semibold" id="buat">Buat Akun</a> -->
                <router-Link to="/register" class="font-semibold" id="buat">Buat Akun</router-Link>
            </p>
        </div>
    </GuestLayout>
</template>

<style>
#data {
    /* background-color: rgb(245, 187, 245); */
    background: linear-gradient(to right, #fd9ffd, #d027d6);
}

span {
    color: red;
}

p {
    text-align: center;
}

button {
    background-color: rgb(76, 85, 216);
    border-radius: 5px;
    color: black;
    border: none;
}

button:hover {
    background-color: rgb(161, 143, 143);
    color: rgb(20, 19, 20);
    border: none;
}

#buat {
    /* color: rgb(231, 69, 104); */
    color: rgb(255, 255, 255);
}

#buat:hover {
    color: black;
}

#tes {
    margin-top: 6%;
}

/* #submit {
    background-color: rgb(158, 52, 158);
}

#btn:hover {
    background-color: rgb(43, 42, 43);
    color: aqua;
} */

/* .data {
    background-color: aqua;
    padding-left: 10%;
    height: 100%;
    width: 45%;
    height: 20%;
    border: 1px solid;
    margin-top: 2%;
    margin-left: 370px;
}
.data input {
    align-content: center;
    width: 70%;
}
.submit {
    align-content: center;
    width: 70%;
}
.data p {
    padding-right: 30%; 
    margin-top: 5%;
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    color: rgb(0, 0, 0);
} */
</style>