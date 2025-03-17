import "./bootstrap";
import { createRouter, createWebHistory } from "vue-router";
import Login from "./pages/login.vue";
import Register from "./pages/register.vue";
import Home from "./pages/home.vue";
import Otp from "./pages/otp.vue";
import Otpregis from "./pages/otpregis.vue";
import Otplogin from "./pages/otplogin.vue";

const routes = [
    {
        path : "/",
        name : "login",
        component : Login 
    },
    {
        path : "/register",
        name : "register",
        component : Register 
    },
    {
        path : "/home",
        name : "home",
        component : Home 
    },
    {
        path : "/otp",
        name : "otp",
        component : Otp 
    },
    {
        path : "/otpregis",
        name : "otpregis",
        component : Otpregis 
    },
    {
        path : "/otplogin",
        name : "otplogin",
        component : Otplogin 
    }
];

const router = createRouter ({
    history : createWebHistory(),
    routes,
});

export default router;