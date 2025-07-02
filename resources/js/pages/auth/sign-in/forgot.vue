<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';
import axiosClient from '../../../axios'; // Sesuaikan path kalau berbeda

const router = useRouter();
const otp = ref('');
const message = ref('');

const form = ref({email:''});

const submitForgot = async () =>{
    await axios.post('/forgot-password', { 
        email: form.value.email,
    })
    .then(response => {
        if(response.status === 200) {
            message.value = response.data.status;
        }
    }) .cath(error => {
        console.log(error.response.message);
    });
}

</script>


<!-- // Vue Frontend (components/OtpVerification.vue) -->
<template>

    <div class="w-99.5 h-40 rounded-md" id="box">
        <form @submit.prevent="submitForgot">
            <div>
                <label for="email" class="mt-3 block text-sm/ font-medium text-gray-900 ">Email :</label>
                <input v-model="email" class=" block w-60 rounded-md bg-white px-3 py-1.5 " placeholder="Email" />
            </div>
            <div>
                <button type="submit"
                    class="mt-2 flex w-60 justify-center rounded-md px-3 py-1.5 text-sm/6 font-semibold text-white ">Send
                </button>
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
