import "./bootstrap";
import { createRouter, createWebHistory } from "vue-router";
// import Login from "./pages/auth/sign-in/login.vue";
// import Register from "./pages/auth/sign-up/register.vue";
// import Home from "./pages/home.vue";
// import Otp from "./pages/otp.vue";
// import Otpregis from "./pages/auth/sign-up/otpregis.vue";
// import Otplogin from "./pages/auth/sign-in/otplogin.vue";
// import Resend from "./pages/auth/sign-in/resend.vue";
// import Forgot from "./pages/auth/sign-in/forgot.vue";
// import PasswordReset from "./pages/auth/sign-in/reset.vue";

const routes = [
    {
        path : "/sign-in",
        name : "login",
        component : ()  => import("./pages/auth/sign-in/login.vue")
    },
    {
        path : "/sign-up",
        name : "register",
        component : () => import("./pages/auth/sign-up/register.vue")
    },
    {
        path : "/home",
        name : "home",
        component : ()  => import("./pages/home.vue")
    },
    {
        path : "/otp",
        name : "otp",
        component : ()  => import("./pages/otp.vue")
    },
    {
        path : "/otpregis",
        name : "otpregis",
        component :  () => import("./pages/auth/sign-up/otpregis.vue")
    },
    {
        path : "/otplogin",
        name : "otplogin",
        component : ()  => import("./pages/auth/sign-in/otplogin.vue")
    },
    {
        path : "/resend",
        name : "resend",
        component :  () => import("./pages/auth/sign-in/resend.vue")
    },
    {
        path : "/forgot",
        name : "forgot",
        component : ()  => import("./pages/auth/sign-in/forgot.vue")
    },
    {
        path : "/password-reset/:token",
        name : "passwordReset",
        component : () => import("./pages/auth/sign-in/reset.vue")
    },
];

const router = createRouter ({
    history : createWebHistory(),
    routes,
});

export default router;