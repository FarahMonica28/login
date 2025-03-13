<!-- <script setup>
import { ref } from "vue";
import GuestLayout from "../components/GuestLayout.vue";
import axiosClient from "../axios";
import router from "../router";
// import { useRouter } from "vue-router";
// const router = useRouter(); // Menggunakan Vue Router untuk navigasi

const logout = () => {
    // Hapus token dari localStorage
    localStorage.removeItem("authToken");

    // Redirect ke halaman login
    router.push("/");
};
</script> -->

<script setup>
import Swal from "sweetalert2";
import { useRouter } from "vue-router";
// import router from "../router";

//menambahkan nama
// import {ref, onMounted} from "vue";
// const name = ref("");
// onMounted(() => {
//     name.value = localStorage.getItem("name") || "User";
//     console.log(name.value);
// });

const router = useRouter(); // Menggunakan Vue Router untuk navigasi

const logout = () => {
    Swal.fire({
        title: "Apakah Anda yakin ingin keluar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Keluar",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            // Hapus token dari localStorage
            localStorage.removeItem("authToken");

            // Menampilkan notifikasi sukses
            Swal.fire({
                icon: "success",
                title: "Berhasil Keluar!",
                // text: "Anda akan diarahkan ke halaman login.",
                confirmButtonText: "OK"
            }).then(() => {
                // Redirect ke halaman login
                router.push("/");
            });
        }
    });
};
</script>

<template>
    <div>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <!-- <h1>SELAMAT DATANG {{ name }} DI HALAM HOME</h1> -->
                <h1>SELAMAT DATANG DI HALAM HOME</h1>
                <!-- <p>Discover our amazing features and learn more about us.</p>
          <button class="btn btn-light btn-lg mt-4">Learn More</button> -->
            </div>
        </section>
        <button @click="logout"
            class="mt-5 flex justify-center items-center w-40 rounded-md-10 px-3 py-1.5 text-sm/6 font-semibold text-white">
            Keluar
        </button>
        <!-- Features Section -->
        <!-- <section class="features-section">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <h4>Feature One</h4>
                            <p>Explore our first feature that makes your experience better.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <h4>Feature Two</h4>
                            <p>Learn how our second feature can help you achieve more.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <h4>Feature Three</h4>
                            <p>Discover the benefits of our third unique feature.</p>
                        </div>
                    </div>
                    <button @click="logout"
                        class="mt-5 flex justify-center items-center w-55 rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white">
                        Keluar
                    </button>

                </div>
            </div>
        </section> -->
    </div>
</template>


<style scoped>
.hero-section {
    font-family: 'Times New Roman', Times, serif;
    background: linear-gradient(to right, #6a11cb, #da2ae0);
    color: white;
    padding: 100px 0;
    text-align: center;
}

/* button{
    border-bottom: 5%;
} */
.features-section {
    padding: 50px 0;
}

.feature-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    margin-top: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.feature-card h4 {
    font-size: 1.5rem;
}

.feature-card p {
    color: #555;
}

.container {
    max-width: 1140px;
    margin: auto;
}

.btn {
    align-self: center;
}
</style>