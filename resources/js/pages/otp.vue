<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import Swal from "sweetalert2"; // Import SweetAlert2
import axiosClient from "../axios";
import router from "../router";

const data = ref({
  email: "",
  password: "",
  otp: "", // State baru untuk OTP
});
const isOtpSent = ref(false); // State untuk memeriksa apakah OTP telah dikirim

const submitLogin = async () => {
  try {
    const response = await axiosClient.post('http://127.0.0.1:8000/api/login', {
      email: data.value.email,
      password: data.value.password
    });

    if (response.status === 200) {
      // OTP berhasil dikirim
      isOtpSent.value = true;
      Swal.fire({
        icon: 'success',
        title: 'OTP telah dikirim!',
        text: 'Silakan periksa email Anda untuk mendapatkan OTP.',
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Login Gagal!',
      text: error.response?.data?.message || 'Email atau password salah.',
    });
    console.error('Kesalahan login:', error);
  }
};

const verifyOtp = async () => {
  try {
    const response = await axiosClient.post('http://127.0.0.1:8000/api/verify-otp', {
      email: data.value.email,
      otp: data.value.otp
    });

    if (response.status === 200) {
      const token = response.data.token;
      localStorage.setItem('authToken', token);
      Swal.fire({
        icon: 'success',
        title: 'Login Berhasil!',
      });
      router.push('/home');
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Verifikasi Gagal!',
      text: error.response?.data?.message || 'OTP tidak valid.',
    });
    console.error('Kesalahan verifikasi OTP:', error);
  }
};
</script>

<template>
  <GuestLayout>
    <h2 class="text-center text-2xl/9 font-bold tracking-tight text-gray-900">
      Masukan Akun <span>Anda</span>
    </h2>

    <div class="mt-3 w-99.5 h-80 ml-113 rounded-md" id="data">
      <form @submit.prevent="isOtpSent ? verifyOtp() : submitLogin()" class="space-y-6 ml-4 mt-4">
        <div>
          <div class="flex items-center justify-between">
            <label for="email" class="block text-sm/ font-medium text-gray-900 mt-4">Email :</label>
            <input type="email" name="email" id="email" autocomplete="email" required=""
              class="mt-3 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 focus:outline-black" v-model="data.email">
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/ font-medium text-gray-900 mt-3">Password :</label>
            <input type="password" name="password" id="password" autocomplete="current-password" required=""
              class="mt-2 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 text-base focus:outline-black sm:text-sm/6"
              v-model="data.password" />
          </div>
        </div>

        <div v-if="isOtpSent">
          <div class="flex items-center justify-between">
            <label for="otp" class="block text-sm/ font-medium text-gray-900 mt-3">OTP :</label>
            <input type="text" name="otp" id="otp" required=""
              class="mt-2 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 text-base focus:outline-black sm:text-sm/6"
              v-model="data.otp" />
          </div>
        </div>

        <button type="submit"
          class="mt-5 ml-5 flex w-65 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white btn-hover-black">
          {{ isOtpSent ? 'Verifikasi OTP' : 'Masuk' }}
        </button>
      </form>

      <p class="font-semibold text-center text-sm/6 text-black" id="tes">
        Tidak Memiliki Akun?
        <router-Link to="/register" class="font-semibold" id="buat">Buat Akun</router-Link>
      </p>
    </div>
  </GuestLayout>
</template>

<style>
/* button {
    background: red;
} */
/* Gaya yang sudah ada */
</style>