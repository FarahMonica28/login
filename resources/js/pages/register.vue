<script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";
import { RouterLink } from "vue-router";

const data = ref({
    name: "",
    email: "",
    password: "" // Konfirmasi password jika diperlukan
});

const errorMessage = ref(""); // Untuk menampilkan pesan error jika registrasi gagal

const submitRegister = async () => {
    try {
        const response = await axiosClient.post("http://127.0.0.1:8000/api/register", {
            name: data.value.name,
            email: data.value.email,
            password: data.value.password
        });

        // Simpan token dari respons jika tersedia (untuk sesi login otomatis)
        if (response.data.token) {
            localStorage.setItem("token", response.data.token);
            axiosClient.defaults.headers.common["Authorization"] = `Bearer ${response.data.token}`;
        }

        // Redirect ke dashboard atau halaman utama setelah registrasi sukses
        router.push("/");
    } catch (error) {
        if (error.response) {
            errorMessage.value = error.response.data.message || "Registrasi gagal. Coba lagi!";
            // alert("Email sudah terdaftar")
        } else {
            errorMessage.value = "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
};
</script>

<template>
    <GuestLayout>
        <h2 class="text-center text-2xl/9 font-bold tracking-tight text-gray-900">
            Buat akun Anda
        </h2>
        <div class="mt-3 w-99.5 h-95 ml-113 rounded-md " id="data">
            <form @submit.prevent="submitRegister" class="space-y-6 ml-7 mt-3">
                <div>
                    <div class="flex items-center justify-between">
                    <label for="name" class="block text-sm/ font-medium text-gray-900 mt-4">Nama</label>
                    <input type="name" name="name" id="name" autocomplete="name" required="" v-model="data.name"
                        class="mt-3 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 focus:outline-black ">
                        </div>
                    <!-- <div class="mt-0.5">
                    </div> -->
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="email" class="block text-sm/ font-medium text-gray-900 mt-3">Email</label>
                        <input type="email" name="email" id="email" autocomplete="email" required=""
                            v-model="data.email" class="mt-2 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 focus:outline-black">
                    </div>
                    <!-- <div class="mt-0.5">
                        <input type="email" name="email" id="email" autocomplete="email" required=""
                            v-model="data.email"
                            class="block w-70 rounded-md bg-white px-3 py-1.5 focus:outline-black ">
                    </div> -->
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/ font-medium text-gray-900 mt-3">Password</label>
                        <input type="password" name="password" id="password" autocomplete="current-password" required=""
                            v-model="data.password"
                            class="mt-2 mr-5 block w-60 rounded-md bg-white px-3 py-1.5 focus:outline-black" />
                    </div><br>
                    <!-- <div class="mt-0.5">
                    </div> -->
                </div>
                <div>
                    <button type="submit"
                        class="ml-5 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white">
                        Buat
                    </button>
                </div>
                <!-- <RouterLink
                    class="mt-7 ml-5 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold">
                    <a id="kembali" href="/">Kembali</a>
                </RouterLink> -->
            </form>

        </div>
    </GuestLayout>
</template>

<style>
#kembali{
    color: aliceblue;
}
#kembali:hover{
    color: rgb(0, 0, 0);
}
</style>
