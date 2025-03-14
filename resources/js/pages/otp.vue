<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
      <div class="bg-white p-6 rounded-lg shadow-md w-80">
        <h2 class="text-xl font-semibold text-center">Masukkan OTP</h2>
        <p class="text-gray-500 text-center">Kode OTP telah dikirim ke nomor Anda.</p>
        
        <div class="flex justify-center gap-2 mt-4">
          <input v-for="(digit, index) in otp" :key="index" v-model="otp[index]" 
            class="w-12 h-12 text-center text-xl border rounded focus:ring-2 focus:ring-blue-500" 
            maxlength="1" @input="moveFocus(index, $event)" />
        </div>
        
        <button @click="verifyOTP" class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
          Verifikasi
        </button>
        
        <p v-if="timer > 0" class="text-center text-gray-500 mt-2">Kirim ulang dalam {{ timer }} detik</p>
        <button v-else @click="resendOTP" class="w-full mt-2 text-blue-500">Kirim Ulang OTP</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  
  const otp = ref(["", "", "", ""]);
  const timer = ref(30);
  
  const moveFocus = (index, event) => {
    if (event.target.value && index < otp.value.length - 1) {
      event.target.nextElementSibling?.focus();
    }
  };
  
  const verifyOTP = () => {
    alert("OTP yang dimasukkan: " + otp.value.join(""));
  };
  
  const resendOTP = () => {
    timer.value = 30;
    const countdown = setInterval(() => {
      timer.value--;
      if (timer.value === 0) clearInterval(countdown);
    }, 1000);
  };
  
  onMounted(() => resendOTP());
  </script>
  
  <style scoped>
  input::-webkit-inner-spin-button, 
  input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  </style>
  