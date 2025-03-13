import "./bootstrap";
import { createRouter, createWebHistory } from "vue-router";
import Login from "./pages/login.vue";
import Register from "./pages/register.vue";
import Home from "./pages/home.vue";

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
];

const router = createRouter ({
    history : createWebHistory(),
    routes,
});

export default router;