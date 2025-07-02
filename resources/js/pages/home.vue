<script setup>
import { ref, onMounted } from "vue";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

const router = useRouter(); 
const name = ref("");

// Ambil nama dari localStorage saat halaman dimuat
onMounted(() => {
    const storedName = localStorage.getItem("name");
    const authToken = localStorage.getItem("authToken");

    if (!authToken) {
        // Jika tidak ada token, redirect ke halaman login
        router.push("/");
    } else {
        name.value = storedName || "User"; // Default ke "User" jika nama tidak ada
    }
});

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
            // Hapus data dari localStorage
            localStorage.removeItem("authToken");
            localStorage.removeItem("name");

            // Menampilkan notifikasi sukses
            Swal.fire({
                icon: "success",
                title: "Berhasil Keluar!",
                confirmButtonText: "OK"
            }).then(() => {
                // Redirect ke halaman login
                router.push("/sign-in");
            });
        }
    });
};
</script>

<template>
    <div>
        <section class="hero-section">
            <div class="container">
                <h1>SELAMAT DATANG <b>{{ name }}</b> DI HALAMAN HOME</h1>
            </div>
        </section>
        <button @click="logout"
            class="mt-5 flex justify-center items-center w-40 rounded-md px-3 py-1.5 text-sm font-semibold text-white bg-red-500">
            Keluar
        </button>
    </div>
</template>

<style scoped>
.hero-section {
    font-family: 'Times New Roman', Times, serif;
    /* background: linear-gradient(to right, #6a11cb, #da2ae0); */
    /* color: white; */
    padding: 100px 0;
    text-align: center;
}

.container {
    max-width: 1140px;
    margin: auto;
}
</style>
